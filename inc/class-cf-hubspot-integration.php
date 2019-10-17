<?php
/**
 * Class CFHubSpotIntegration file.
 *
 * @package cf-hubspot-integration
 * @version 0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


if ( ! class_exists( 'CFHubSpotIntegration', false ) ) :

    /**
     * CFHubSpotIntegration Class
     */
	class CFHubSpotIntegration {

        /**
        * Member Variable
        *
        * @var object instance
        */
        private static $instance;

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @return Singleton The *Singleton* instance.
         */
        public static function get_instance() {
            if ( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Class Constructor
         *
         * @since  0.0.1
         * @return void
         */
		public function __construct() {

			// Load text domain
			add_action( 'plugins_loaded', array( $this, 'cfhi_plugin_load_textdomain' ) );

			// Check whether Caldera form is active or not
			register_activation_hook( __FILE__, array( $this, 'cfhi_integration_activate' ) );

            //Register Processor Hook
	   	   add_filter( 'caldera_forms_get_form_processors',  array( $this, 'cfhi_register_processor' ) );

		}


		/**
	 	* Check Caldera Forms is active or not
		*
		* @since 0.0.1
        * @return void
		*/
	    public function cfhi_integration_activate( $network_wide ) {
			if( ! function_exists( 'caldera_forms_load' ) ) {
			    wp_die( 'The "Caldera Forms" Plugin must be activated before activating the "HubSpot Integration For Caldera Forms" Plugin.' );
			}
		}


        /**
         * Load plugin textdomain.
         *
         * @since 0.0.1
         * @return void
        */
		public function cfhi_plugin_load_textdomain() {
			load_plugin_textdomain( 'cf-hubspot-integration', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}


		/**
		 * Add Our Custom Processor
		 *
		 * @uses "caldera_forms_get_form_processors" filter
		 *
		 * @since 0.0.1
		 *
		 * @param array $processors
		 * @return array Processors
		*/
		public function cfhi_register_processor( $processors ) {
		  	$processors['cf_hubspot_integration'] = array(
				'name'              =>  __( 'HubSpot Integration', 'cf-hubspot-integration' ),
				'description'       =>  __( 'Send Caldera Forms submission data to HubSpot using HubSpot REST API.', 'cf-hubspot-integration' ),
				'pre_processor'		=>  array( $this, 'cf_hubspot_integration_processor' ),
				'template' 			=>  __DIR__ . '/config.php'
			);
			return $processors;
		}


		/**
		 * Send data to HubSpot using Caldera Processor
         *
		 * @param array $config Processor config
		 * @param array $form Form config
		 * @param string $process_id Unique process ID for this submission
		 * @since 0.0.1
		 * @return void|array
		*/
	   	public function cf_hubspot_integration_processor( $config, $form, $process_id ) {

            if( ! isset( $config['cfhi_hubspot_org_id'] ) || empty( $config['cfhi_hubspot_org_id'] ) ) {
                return;
		  	}

      	    if( ! isset( $config['cfhi_hubspot_obj'] ) || empty( $config['cfhi_hubspot_obj'] ) ) {
			    return;
		  	}

            $hubspot_org_id     = Caldera_Forms::do_magic_tags( $config['cfhi_hubspot_org_id'] );
            $hubspot_first_name = Caldera_Forms::do_magic_tags( $config['cfhi_hubspot_first_name'] );
            $hubspot_last_name  = Caldera_Forms::do_magic_tags( $config['cfhi_hubspot_last_name'] );
            $hubspot_email      = Caldera_Forms::do_magic_tags( $config['cfhi_hubspot_email'] );


    	  	/* Saving form submission data into hubspot using  hubspot REST API*/
    	 	$wp_version                 = get_bloginfo( 'version' );
    		$header                     = [];
            $header['user-agent']       = 'Caldera HubSpot plugin - WordPress/'.$wp_version.'; '.get_bloginfo( 'url' );
            $header['content-type']     = 'application/json';
            $header['cache-control']    = 'no-cache';


            //Prepare form data
            $arr = array(
                'properties' => array(
                    array(
                        'property'  => 'email',
                        'value'     =>  $hubspot_email
                    ),
                    array(
                        'property'  => 'firstname',
                        'value'     => 	$hubspot_first_name
                    ),
                    array(
                        'property'  => 'lastname',
                        'value'     =>  $hubspot_last_name
                    ),
                )
            );

            //HubSpot API URL
            $url = 'https://api.hubapi.com/contacts/v1/contact?hapikey='. $hubspot_org_id;

            //Prepare HubSpot arguments for API call
            $args = array( 
                'body'      => json_encode( $arr ), 
                'headers'   => $header, 
                'timeout'   => 45 
            );
            

            // pushing form data into HubSpot account
            try {

                $results    = wp_remote_post( $url, $args );
                $code       = wp_remote_retrieve_response_code( $results );

                if( intval( $code ) !== 200 ) {
                    return;
                }

            } catch ( \Exception $e ) {

            }

		}

	}

	/**
      * Calling class using 'get_instance()' method
    */
    CFHubSpotIntegration::get_instance();

endif;
