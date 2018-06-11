<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-common-settings-activate">

	<h1>Blog Edition freischalten</h1>

	<table class="form-table">
	<tr>
			<th scope="row">Lizenz</th>
			<td><label for="dsgvo_licence"> <input name="dsgvo_licence"
									type="text" id="dsgvo_licence" style="width: 300px"
									value="<?= SPDSGVOSettings::get('dsgvo_licence');  ?>">
							</label>
							<?php if(SPDSGVOSettings::get('license_activated') === '1'): ?>
							<span class="info-text">
							<?= (SPDSGVOSettings::get('dsgvo_licence') !== '' && SPDSGVOSettings::get('license_key_error') === '0') ? 'G&uuml;ltige Lizenz. Die Blog Edition ist aktiviert.' : 'Ung&uuml;ltige Lizenz';  ?>
							</span>
							<?php submit_button('Lizenz deaktivieren'); ?>
							<?php else: ?>
							<span class="info-text">Lizenz eingeben und auf aktivieren klicken schaltet die Features der "Blog Edition" frei.</span>
							<?php submit_button('Lizenz aktivieren'); ?>
							<?php endif; ?>
							</td>
		</tr>
     </table>
</form>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-common-settings">

<input type="hidden" value="<?= SPDSGVOSettings::get('dsgvo_licence'); ?>" id="dsgvo_licence_hidden" name="dsgvo_licence_hidden" />

	<h1>Allgemeine Einstellungen</h1>

	<table class="form-table">
		<tr>
			<th scope="row">Admin Email</th>
			<td><label for="admin_email"> <input name="admin_email"
									type="text" id="admin_email" style="width: 300px"
									value="<?= SPDSGVOSettings::get('admin_email');  ?>">
							</label><span class="info-text">Wird bei Emails mitgesendet.</span></td>
		</tr>
	   </table>	
	   
   		<?php if (isLicenceValid()) :  ?>
		 <h2>Kommentare</h2>
		<?php else :  ?>
		 <h2>Kommentare</h2><span style="color: orange">Anpassung in der Blog oder Premium Edition m&ouml;glich</span>
		<small><a href="https://www.wp-dsgvo.eu/shop"> Hier klicken um eine Lizenz anzufordern.</a></small>
		<?php endif;  ?>
	   <?php $disableCommentInputs = isLicenceValid() == false; ?>
	   <table class="form-table">
		<tr>
			<th scope="row">Checkbox bei Kommentaren:</th>
			<td><label for="sp_dsgvo_comments_checkbox"> <input
					name="sp_dsgvo_comments_checkbox" type="checkbox"
					id="sp_dsgvo_comments_checkbox" value="1"
					<?= (SPDSGVOSettings::get('sp_dsgvo_comments_checkbox') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text">Zeigt eine Checkbox bei Kommentaren an welche die Zustimmung zu den DSGVO Bestimmungen fordert.</span></td>
		</tr>
		<?php if (class_exists('WPCF7_ContactForm')) :  ?>
		<tr>
			<td>CF7 Acceptance Text ersetzen:</td>
			<td><label for="sp_dsgvo_cf7_acceptance_replace"> <input
					name="sp_dsgvo_cf7_acceptance_replace" type="checkbox"
					id="sp_dsgvo_cf7_acceptance_replace" value="1"
					<?= (SPDSGVOSettings::get('sp_dsgvo_cf7_acceptance_replace') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text">&Uuml;berschreibt den Text von Acceptance Checkboxen von CF7 mit dem nachfolgendem Text.  (Im Formular erg&auml;nzen: [acceptance dsgvo] Text[/acceptance])</span></td>
		</tr>
		<?php endif  ?>
		<tr>
		<th scope="row">Text:</th>
		<td><label for="spdsgvo_comments_checkbox_text"> <textarea name="spdsgvo_comments_checkbox_text"
					placeholder="Gib hier einen Meldungstext ein" id="spdsgvo_comments_checkbox_text" rows="3"
					<?= $disableCommentInputs ? 'disabled' : '';  ?>
					style="width: 100%"><?= $disableCommentInputs ? SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_text') : SPDSGVOSettings::get('spdsgvo_comments_checkbox_text'); ?></textarea>
			</label></td>
		</tr>
		<tr>
			<th scope="row">Hinweistext:</th>
			<td><label for="spdsgvo_comments_checkbox_info"> <input
					name="spdsgvo_comments_checkbox_info" type="text" style="width: 500px"
					<?= $disableCommentInputs ? 'disabled' : '';  ?>
					id="spdsgvo_comments_checkbox_info" value="<?= $disableCommentInputs ? SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_info') : SPDSGVOSettings::get('spdsgvo_comments_checkbox_info');  ?>">
			</label></td>
		</tr>
		<tr>
			<th scope="row">Zustimmungstext:</th>
			<td><label for="spdsgvo_comments_checkbox_confirm"> <input
					name="spdsgvo_comments_checkbox_confirm" type="text" style="width: 300px"
				    <?= $disableCommentInputs ? 'disabled' : '';  ?>
					id="spdsgvo_comments_checkbox_confirm" value="<?= $disableCommentInputs ? SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_confirm') : SPDSGVOSettings::get('spdsgvo_comments_checkbox_confirm');  ?>">
			</label></td>
		</tr>
   </table>

	<hr class="sp-dsgvo">

<h2>Unternehmensdaten</h2>
<p>Die nachfolgenden Eingabefelder stellen die grundlegenden Daten dar, die zum Erzeugen DSGVO-konformer Datenschutzbestimmungen sowie ein Impressum notwendig sind.<br />
Alle Eingaben die sie hier t&auml;tigen werden automatisch in das vom WP DSGVO Tools Plugin generierten Datenschutzbestimmungen sowie Impressum verwendet.</p>

	<table class="form-table">
		<tr>
			<td>Name des Unternehmens:</td>
			<td><label for="spdsgvo_company_info_name"> <input name="spdsgvo_company_info_name"
									type="text" id="spdsgvo_company_info_name" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_name');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td>Stra&szlig;e:</td>
			<td><label for="spdsgvo_company_info_street"> <input name="spdsgvo_company_info_street"
									type="text" id="spdsgvo_company_info_street" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_street');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td>PLZ + Ort:</td>
			<td><label for="spdsgvo_company_info_loc_zip"> <input name="spdsgvo_company_info_loc_zip"
									type="text" id="spdsgvo_company_info_loc_zip" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_loc_zip');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td>Firmenbuch Nummer:</td>
			<td><label for="spdsgvo_company_fn_nr"> <input name="spdsgvo_company_fn_nr"
									type="text" id="spdsgvo_company_fn_nr" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_fn_nr');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td>Gerichtsstand:</td>
			<td><label for="spdsgvo_company_law_loc"> <input name="spdsgvo_company_law_loc"
									type="text" id="spdsgvo_company_law_loc" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_law_loc');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td>USt. Id.:</td>
			<td><label for="spdsgvo_company_uid_nr"> <input name="spdsgvo_company_uid_nr"
									type="text" id="spdsgvo_company_uid_nr" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_uid_nr');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td>Gesetzlicher Vertreter:</td>
			<td><label for="spdsgvo_company_law_person"> <input name="spdsgvo_company_law_person"
									type="text" id="spdsgvo_company_law_person" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_law_person');  ?>">
							</label><span class="info-text">Die Person die das Unternehmen gesetzlich vertritt.</span></td>
		</tr>
		<tr>
			<td>Gesellschafter:</td>
			<td><label for="spdsgvo_company_chairmen"> <input name="spdsgvo_company_chairmen"
									type="text" id="spdsgvo_company_chairmen" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_chairmen');  ?>">
							</label><span class="info-text">Im Fall von Gesellschaften hier bitte alle Gesellschafter anf&uuml;hren.</span></td>
		</tr>
		<tr>
			<td>Verantwortlicher f&uuml;r Inhalt:</td>
			<td><label for="spdsgvo_company_resp_content"> <input name="spdsgvo_company_resp_content"
									type="text" id="spdsgvo_company_resp_content" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_resp_content');  ?>">
							</label><span class="info-text">Die Person die f&uuml;r den Inhalt auf dieser Website verantwortlich ist.</span></td>
		</tr>
		<tr>
			<td>Telefon:</td>
			<td><label for="spdsgvo_company_info_phone"> <input name="spdsgvo_company_info_phone"
									type="text" id="spdsgvo_company_info_phone" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_phone');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><label for="spdsgvo_company_info_email"> <input name="spdsgvo_company_info_email"
									type="text" id="spdsgvo_company_info_email" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_email');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td>Newsletter Service:</td>
			<td><label for="spdsgvo_newsletter_service"> <input name="spdsgvo_newsletter_service"
									type="text" id="spdsgvo_newsletter_service" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_newsletter_service');  ?>">
							</label><span class="info-text">Name des Versanddienstleisters mit dem die Newsletter versendet werden.</span></td>
		</tr>
		<tr>
			<td>URL Datenschutz Newsletter Service:</td>
			<td><label for="spdsgvo_newsletter_service_privacy_policy_url"> <input name="spdsgvo_newsletter_service_privacy_policy_url"
									type="text" id="spdsgvo_newsletter_service_privacy_policy_url" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_newsletter_service_privacy_policy_url');  ?>">
							</label><span class="info-text">Die URL zu den Datenschutzbestimmungen des Versanddienstleisters mit dem die Newsletter versendet werden.</span></td>
		</tr>
   </table>


	<br>	
    <?php submit_button(); ?>
</form>

