<div class="caldera-config-group">
    <label><?php esc_html_e( 'HubSpot API key', 'cf-hubspot-integration' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config required" id="cfhi_hubspot_org_id" name="{{_name}}[cfhi_hubspot_org_id]" value="{{cfhi_hubspot_org_id}}" required="required">
        <div class="description">

    </div>
</div>


<div class="caldera-config-group">
	<label><?php esc_html_e( 'HubSpot Object', 'cf-hubspot-integration' ); ?> </label>
	<div class="caldera-config-field">
		<select class="block-input field-config" name="{{_name}}[cfhi_hubspot_obj]" id="cfhi_hubspot_obj">
			<option value="Contact" {{#is context value="Contact"}}selected="selected"{{/is}}><?php esc_html_e( 'Contact', 'cf-hubspot-integration' ); ?></option>
		</select>
	</div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'First Name', 'cf-hubspot-integration' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind required" id="cfhi_hubspot_first_name" name="{{_name}}[cfhi_hubspot_first_name]" value="{{cfhi_hubspot_first_name}}" required="required">
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Last Name', 'cf-hubspot-integration' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind" id="cfhi_hubspot_last_name" name="{{_name}}[cfhi_hubspot_last_name]" value="{{cfhi_hubspot_last_name}}">
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Your Email', 'cf-hubspot-integration' ); ?> </label>
    <div class="caldera-config-field">
        <input type="email" class="block-input field-config magic-tag-enabled caldera-field-bind required" id="cfhi_hubspot_email" name="{{_name}}[cfhi_hubspot_email]" value="{{cfhi_hubspot_email}}" required="required">
    </div>
</div>
