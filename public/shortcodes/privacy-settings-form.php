<?php

function SPDSGVOUserPrivacySettingsFormShortcode($atts)
{
    $atts = shortcode_atts(array(
    ), $atts);
    
    ob_start();
    ?>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>"
	class="sp-dsgvo-framework">
	<input type="hidden" name="action" value="user-permissions">
	<div class="container container-no-padding">
		<div class="row">
			<div class="column strong">Dienst</div>
			<div class="column column-50 strong">Grund der Nutzung</div>
			<div class="column strong">AGB</div>
			<div class="column strong">Aktiviert</div>
		</div>
		<hr />
		<?php foreach(SPDSGVOSettings::get('services') as $slug => $service): ?>
    		<div class="row">
    			<div class="column"><?= $service['name'] ?></div>
    			<div class="column column-50"><?= $service['reason'] ?></div>
    			<div class="column"><a href="<?= @$service['link'] ?>" target="_blank">AGB</a></div>
    			<div class="column"><select name="services[<?= $slug ?>]">
							<option
								<?= (hasUserGivenPermissionFor($service['slug']))? ' selected ' : '' ?>
								value="1">Ja</option>
							<option
								<?= (hasUserGivenPermissionFor($service['slug']))? '' : ' selected ' ?>
								value="0">Nein</option>
					</select></div>
    		</div>
    		<hr />
		<?php endforeach; ?>
	</div>
	
			<?php if(!is_user_logged_in()): ?>
				<p>
		<small>Da Sie nicht eingeloggt sind speichern wir diese Einstellungen
			in einem Cookie. Diese Einstellungen sind somit nur auf diesem PC
			aktiv.</small>
	</p>
			<?php endif; ?>

			<input type="submit" value="Speichern">
</form>

<?php
    return ob_get_clean();
}

add_shortcode('user_privacy_settings_form', 'SPDSGVOUserPrivacySettingsFormShortcode');
