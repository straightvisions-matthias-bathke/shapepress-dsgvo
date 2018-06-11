<h1>Setup</h1>
<p>Welcome to All-in-One GDPR, a GDPR toolkit for WordPress that makes it even easier to comply with the GDPR.</p>
<hr>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="<?= SPDSGVOCreatePageAction::getActionName(); ?>">	

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">License Key</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span>License Key</span>
						</legend>
				
						<label for="license_key">
							<input name="license_key" type="text" id="license_key" required value="<?php echo SPDSGVOSettings::get('license_key');?>" />
							<p class="description" id="admin-email-description">If you need a license key you can buy one <a href="https://gdprplug.in">here</a></p>
						</label>
					</fieldset>
				</td>
			</tr>

			
			<?php if(SPDSGVOSettings::get('show_setup') == '1'): ?>
				<tr>
					<th scope="row">
						Enable Cookie Notice
					</th>
					<td>
						<label for="display_cookie_notice">
							<input name="display_cookie_notice" type="checkbox" id="display_cookie_notice" value="1" checked>
						</label>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						Create Subject Access Request Page
					</th>
					<td>
						<label for="sar">
							<input name="sar" type="checkbox" id="sar" value="1" checked>
						</label>
					</td>
				</tr>

				<tr>
					<th scope="row">
						Create User Privacy Settings Page
					</th>
					<td>
						<label for="user_privacy_settings_page">
							<input name="user_privacy_settings_page" type="checkbox" id="user_privacy_settings_page" value="1" checked>
						</label>
					</td>
				</tr>

				<tr>
					<th scope="row">
						Create Terms and Conditione Page
					</th>
					<td>
						<label for="terms_conditions_page">
							<input name="terms_conditions_page" type="checkbox" id="terms_conditions_page" value="1" checked>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">
						Create Privacy Policy Page
					</th>
					<td>
						<label for="privacy_policy_page">
							<input name="privacy_policy_page" type="checkbox" id="privacy_policy_page" value="1" checked>
						</label>
					</td>
				</tr>

				<tr>
					<th scope="row">
						Create Super Unsubscribe Page
					</th>
					<td>
						<label for="super_unsubscribe_page">
							<input name="super_unsubscribe_page" type="checkbox" id="super_unsubscribe_page" value="1" checked>
						</label>
					</td>
				</tr>

				<tr>
					<th scope="row"></th>
					<td>
						<button type="submit" class="button button-primary button-large">Install</button>
					</td>
				</tr>
			
			<?php endif; ?>
		</tbody>
	</table>
</form>
