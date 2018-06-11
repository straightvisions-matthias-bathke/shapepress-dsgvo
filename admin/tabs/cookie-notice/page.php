<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-cookie-notice">

	<h1>Cookie Notice</h1>

	<table class="form-table">
		<tr>
			<th scope="row">Tracker Initialisierung:</th>
			<td>
			<?php $cnTrackerInit = SPDSGVOSettings::get('cn_tracker_init'); ?>
			<label for="cn_tracker_init"> <select name="cn_tracker_init"
					id="cn_tracker_init">
						<option value="on_load" <?= selected($cnTrackerInit == 'on_load') ?>> Beim Laden der Seite</option>
						<option value="after_confirm" <?= selected($cnTrackerInit == 'after_confirm') ?>> Nach Zustimmung des Cookies</option>
				</select>
			</label> <span class="info-text"> Gibt an wann die Tracker aktiv sein sollen. Ob vor Zustimmung des Cookies oder nach dem Klick auf Ok. Bei "Nach Zustimmung" muss "Neuladen nach Zustimmung" angehakt sein.</span>
			</td>
		</tr>
   </table>

	<table class="form-table" style="margin-top: 0">
		<tbody>
			<tr>
				<td>
					<table class="form-table">
						<tr>
							<th scope="row">Google Analytics:</th>
							<td><label for="ga_enable_analytics"> <input
									name="ga_enable_analytics" type="checkbox"
									id="ga_enable_analytics" value="1"
									<?= (SPDSGVOSettings::get('ga_enable_analytics') === '1')? ' checked ' : '';  ?>>
							</label></td>
						</tr>
						<tr>
							<th scope="row">GTAG Number:</th>
							<td><label for="ga_tag_number"> <input name="ga_tag_number"
									type="text" id="ga_tag_number"
									value="<?= SPDSGVOSettings::get('ga_tag_number');  ?>">
							</label></td>
						</tr>
						<tr>
							<td colspan="2" class="info-text">Die IP Adresse wird
								anonymisiert und die Besucher erhalten die M&ouml;glichkeit das
								Tracking abzulehnen.<br /> Tipp: L&auml;nderspezfische Geodaten
								werden auch bei Anonymisierung weitergetracked.
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table class="form-table">
						<tr>
							<th scope="row">Facebook Pixel:</th>
							<td><label for="fb_enable_pixel"> <input name="fb_enable_pixel"
									type="checkbox" id="fb_enable_pixel" value="1"
									<?= (SPDSGVOSettings::get('fb_enable_pixel') === '1')? ' checked ' : '';  ?>>
							</label></td>
						</tr>
						<tr>
							<th scope="row">FB Pixel Id:</th>
							<td><label for="fb_pixel_number"> <input name="fb_pixel_number"
									type="text" id="fb_pixel_number"
									value="<?= SPDSGVOSettings::get('fb_pixel_number');  ?>">
							</label></td>
						</tr>
						<tr>
							<td colspan="2" style="vertical-align: top" class="info-text">Besucher
								erhalten die M&ouml;glichkeit das Tracking abzulehnen.</td>
						</tr>
					</table>
				</td>
			</tr>
	
	</table>
	<hr class="sp-dsgvo">

	<table class="form-table">
		<tr>

			<th scope="row">Cookie Notice:</th>
			<td><label for="display_cookie_notice"> <input
					name="display_cookie_notice" type="checkbox"
					id="display_cookie_notice" value="1"
					<?= (SPDSGVOSettings::get('display_cookie_notice') === '1')? ' checked ' : '';  ?>>
			</label></td>
		</tr>

		<tr>
			<th scope="row">Meldungstext:</th>
			<td><textarea name="cookie_notice_custom_text"
					placeholder="Gib hier einen Meldungstext ein" id="cookie_notice_custom_text" rows="10"
					style="width: 100%"><?= SPDSGVOSettings::get('cookie_notice_custom_text') ?></textarea></td>
		</tr>
		<tr>
			<td>G&uuml;ltigkeit:</td>
			<td>
			<?php $cnCookieValidity = SPDSGVOSettings::get('cn_cookie_validity'); ?>
			<label for="cn_cookie_validity"> <select name="cn_cookie_validity"
					id="cn_cookie_validity">
						<option value="86400" <?= selected($cnCookieValidity == 86400) ?>>1
							Tag</option>
						<option value="604800" <?= selected($cnCookieValidity == 604800) ?>>1
							Woche</option>
						<option value="2592000"
						<?= selected($cnCookieValidity == 2592000) ?>>1 Monat</option>
						<option value="7862400"
						<?= selected($cnCookieValidity == 7862400) ?>>2 Monate</option>
						<option value="15811200"
						<?= selected($cnCookieValidity == 15811200) ?>>6 Monate</option>
						<option value="31536000"
						<?= selected($cnCookieValidity == 31536000) ?>>1 Jahr</option>
				</select>
			</label> <span class="info-text"> F&uuml;r diesen Zeitraum ist der Cookie
					g&uuml;ltig.</span>
			</td>
		</tr>
		<tr>
			<th scope="row"></th>
			<td></td>
		</tr>

		<tr>
			<th scope="row">Zustimmung</th>
			<td></td>
		</tr>

		<tr>
			<td>Buttontext:</td>

			<td><label for="cn_button_text_ok"> <input name="cn_button_text_ok"
					style="width: 300px" type="text" id="cn_button_text_ok"
					value="<?= SPDSGVOSettings::get('cn_button_text_ok');  ?>"
					placeholder="zB.: Ok">
			</label><span class="info-text">Der Text der angezeigt werden soll um
					den Hinweis zu akzeptieren und die Nachricht ausblendet.</span></td>

		</tr>

		<tr>
			<td>Neuladen nach Zustimmung:</td>

			<td><label for="cn_reload_on_confirm"> <input
					name="cn_reload_on_confirm" type="checkbox"
					id="cn_reload_on_confirm" value="1"
					<?= (SPDSGVOSettings::get('cn_reload_on_confirm') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text">Aktiviere diese Option, um die Seite
					neu zu laden, nachdem Cookies akzeptiert wurden.</span></td>

		</tr>

		<tr>
			<th scope="row">Ablehnen</th>
			<td></td>
		</tr>

		<tr>
			<td>Button aktiv:</td>

			<td><label for="cn_activate_cancel_btn"> <input
					name="cn_activate_cancel_btn" type="checkbox"
					id="cn_activate_cancel_btn" value="1"
					<?= (SPDSGVOSettings::get('cn_activate_cancel_btn') === '1')? ' checked ' : '';  ?>>
			</label></td>

		</tr>
		<tr>
			<td>Buttontext:</td>

			<td><label for="cn_button_text_cancel"> <input
					name="cn_button_text_cancel" type="text" id="cn_button_text_cancel"
					style="width: 300px"
					value="<?= SPDSGVOSettings::get('cn_button_text_cancel');  ?>"
					placeholder="zB.: Ablehnen">
			</label><span class="info-text">Der Text der Option zum Ablehnen von
					Cookies.</span></td>

		</tr>

		<tr>
			<td>Linkziel bei Ablehnung:</td>

			<td><label for="cn_decline_target_url"> <input
					name="cn_decline_target_url" type="text" id="cn_decline_target_url"
					style="width: 300px"
					value="<?= SPDSGVOSettings::get('cn_decline_target_url');  ?>"
					placeholder="zb.: https://www.google.at">
			</label><span class="info-text">Gibt das Ziel an wohin Besucher, die
					die Nachricht ablehnen weitergeleitet werden sollen. Inklusive http(s) angeben.</span></td>

		</tr>

		<tr>
			<td>Kein Cookie setzen bei Weiterleitung:</td>
			<td><label for="cn_decline_no_cookie"> <input
					name="cn_decline_no_cookie" type="checkbox"
					id="cn_decline_no_cookie" value="1"
					<?= (SPDSGVOSettings::get('cn_decline_no_cookie') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text">Wenn aktiv, der Besucher ablehnt und erneut auf die Seite kommt wird ihm die Notice wieder angezeigt.</span></td>
		</tr>

		<tr>
			<th scope="row">Weiterlesen</th>
			<td></td>
		</tr>

		<tr>
			<td>Button aktiv:</td>

			<td><label for="cn_activate_more_btn"> <input
					name="cn_activate_more_btn" type="checkbox"
					id="cn_activate_more_btn" value="1"
					<?= (SPDSGVOSettings::get('cn_activate_more_btn') === '1')? ' checked ' : '';  ?>>
			</label></td>

		</tr>

		<tr>
			<td>Buttontext:</td>

			<td><label for="cn_button_text_more"> <input
					name="cn_button_text_more" type="text" id="cn_button_text_more"
					style="width: 300px"
					value="<?= SPDSGVOSettings::get('cn_button_text_more');  ?>"
					placeholder="zB.: Erfahre mehr">
			</label><span class="info-text">Der Text der Option zum Erhalten von
					mehr Informationen.</span></td>

		</tr>
		<tr>
			<td>Linkziel zum Weiterlesen:</td>

			<td>
			<?php $readMorePage = SPDSGVOSettings::get('cn_read_more_page'); ?>
						<label for="cn_read_more_page"><select style="width: 300px"
					name="cn_read_more_page" id="cn_read_more_page">
						<option value="0">W&auml;hlen</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($readMorePage == $page->ID) ?>
							value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select> </label><span class="info-text">Gibt das Ziel an wohin
					Besucher weitere Informationen &uuml;ber Cookies finden.</span>
			</td>

		</tr>

		<tr>
			<th scope="row" colspan="2">Optionen zur Darstellung der Cookie Notice</th>
		</tr>

		<tr>
			<td>Position:</td>
			<td>
			<?php $cnNoticePosition = SPDSGVOSettings::get('cn_position'); ?>
			<label for="cn_position"> <select name="cn_position" id="cn_position">
						<option value="top" <?= selected($cnNoticePosition == 'top') ?>>Oben</option>
						<option value="bottom"
							<?= selected($cnNoticePosition == 'bottom') ?>>Unten</option>
				</select>
			</label> <span class="info-text">Gibt die Position an wo die Cookie
					Notice angezeigt werden soll.</span>
			</td>
		</tr>
		<tr>
			<td>Animation:</td>
			<td>
			<?php $cnNoticeAnimation = SPDSGVOSettings::get('cn_animation'); ?>
			<label for="cn_animation"> <select name="cn_animation"
					id="cn_animation">
						<option value="none" <?= selected($cnNoticeAnimation == 'none') ?>>Keine</option>
						<option value="fade"
						<?= selected($cnNoticeAnimation == 'fade') ?>>Ausgleiten</option>
						<option value="hide"
						<?= selected($cnNoticeAnimation == 'hide') ?>>Ausblenden</option>
				</select>
			</label> <span class="info-text">Animation beim Akzeptieren der
					Cookie-Nachricht.</span>
			</td>
		</tr>
		</tbody>
		</table>
		
		<?php if (isFree() || isPremium()) :  ?>
		<?php $disableCnStylingOptionTableInput = isLicenceValid() == false; ?>
   <table class="form-table" id="cnStylingOptionTable">
    <tbody>
		<tr>
		    <?php if (isLicenceValid()) :  ?>
    		<th scope="row" colspan="2">Farbliche Anpassung</th>
    		<?php else :  ?>
    		<th scope="row" colspan="2">Farbliche Anpassung <span style="color: orange">In der Blog oder Premium Edition m&ouml;glich</span>
    		<small><a href="https://www.wp-dsgvo.eu/shop"> Hier klicken um eine Lizenz anzufordern.</a></small>
    		</th>
    		<?php endif;  ?>
		</tr>
		<tr>
			<td style="width: 200px">Hintergrund:</td>
			<td><label for="cn_background_color"> <input
					name="cn_background_color" type="color" id="cn_background_color"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					value="<?= SPDSGVOSettings::get('cn_background_color');  ?>">
			</label>
			</td>
		</tr>
		<tr>
			<td>Text:</td>
			<td><label for="cn_text_color"> <input
					name="cn_text_color" type="color" id="cn_text_color"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					value="<?= SPDSGVOSettings::get('cn_text_color');  ?>">
			</label></td>
		</tr>
		<tr>
			<td>Buttons:</td>
			<td>Hintergrund: <label for="cn_background_color"> <input
					name="cn_background_color_button" type="color" id="cn_background_color_button"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					value="<?= SPDSGVOSettings::get('cn_background_color_button');  ?>">
			</label>
			Schrift: <label for="cn_text_color_button"> <input
					name="cn_text_color_button" type="color" id="cn_text_color_button"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					value="<?= SPDSGVOSettings::get('cn_text_color_button');  ?>">
			</label></td>
		</tr>
		<tr>
    		<th scope="row">CSS Klassen</th>
    		<td><span class="info-text">Die unter "Farbliche Anpassung" angef&uuml;hrten Farben m&uuml;ssen mit !important &uuml;berschrieben werden.</span></td>
		</tr>
		<tr>
			<td>Cookie Notice:</td>
			<td><label for="cn_custom_css_container"> <input
					name="cn_custom_css_container" type="text" id="cn_custom_css_container"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					value="<?= SPDSGVOSettings::get('cn_custom_css_container');  ?>">
			</label></td>
		</tr>
		<tr>
			<td>Text:</td>
			<td><label for="cn_custom_css_text"> <input
					name="cn_custom_css_text" type="text" id="cn_custom_css_text"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					value="<?= SPDSGVOSettings::get('cn_custom_css_text');  ?>">
			</label></td>
		</tr>
		<tr>
			<td>Buttons:</td>
			<td><label for="cn_custom_css_buttons"> <input
					name="cn_custom_css_buttons" type="text" id="cn_custom_css_buttons"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					value="<?= SPDSGVOSettings::get('cn_custom_css_buttons');  ?>">
			</label></td>
		</tr>
		<tr>
    		<th scope="row" colspan="2">Weitere Darstellungsoptionen</th>
		</tr>
		<tr>
			<td>Textgr&ouml;&szlig;e:</td>
			<td><label for="cn_size_text">
					
				    <?php $cnSizeText = SPDSGVOSettings::get('cn_size_text'); ?>
					<select name="cn_size_text" 
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					  id="cn_size_text">
					    <option value="auto" <?= selected($cnSizeText == '11px') ?>>Standard</option>
						<option value="11px" <?= selected($cnSizeText == '11px') ?>>11px</option>
						<option value="12px" <?= selected($cnSizeText == '12px') ?>>12px</option>
						<option value="13px" <?= selected($cnSizeText == '13px') ?>>13px</option>
						<option value="14px" <?= selected($cnSizeText == '14px') ?>>14px</option>
						<option value="15px" <?= selected($cnSizeText == '15px') ?>>15px</option>
						<option value="16px" <?= selected($cnSizeText == '16px') ?>>16px</option>
						<option value="17px" <?= selected($cnSizeText == '17px') ?>>17px</option>
						<option value="18px" <?= selected($cnSizeText == '18px') ?>>18px</option>
						<option value="19px" <?= selected($cnSizeText == '19px') ?>>19px</option>
						<option value="20px" <?= selected($cnSizeText == '20px') ?>>20px</option>
				</select>
					
			</label></td>
		</tr>
		<tr>
			<td>H&ouml;he der Cookie Notice:</td>
			<td><label for="cn_height_container">
					
					 <?php $cnHeightContainer = SPDSGVOSettings::get('cn_height_container'); ?>
					<select name="cn_height_container" 
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					  id="cn_height_container">
						<option value="auto" <?= selected($cnHeightContainer == 'auto') ?>>Standard</option>
						<option value="40px" <?= selected($cnHeightContainer == '40px') ?>>40px</option>
						<option value="45px" <?= selected($cnHeightContainer == '45px') ?>>45px</option>
						<option value="50px" <?= selected($cnHeightContainer == '50px') ?>>50px</option>
						<option value="55px" <?= selected($cnHeightContainer == '55px') ?>>55px</option>
						<option value="60px" <?= selected($cnHeightContainer == '60px') ?>>60px</option>
						<option value="65px" <?= selected($cnHeightContainer == '65px') ?>>65px</option>
						<option value="70px" <?= selected($cnHeightContainer == '70px') ?>>70px</option>
						<option value="75px" <?= selected($cnHeightContainer == '75px') ?>>75px</option>
						<option value="80px" <?= selected($cnHeightContainer == '80px') ?>>80px</option>
				</select>
					
			</label></td>
		</tr>
		<tr>
			<td>Icon anzeigen:</td>
			<td><label for="cn_show_dsgvo_icon"> <input
									name="cn_show_dsgvo_icon" type="checkbox"
									<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
									id="cn_show_dsgvo_icon" value="1"
									<?= (SPDSGVOSettings::get('cn_show_dsgvo_icon') === '1')? ' checked ' : '';  ?>>
							</label></td>
		</tr>
		<tr>
			<td>Overlay verwenden:</td>
			<td><label for="cn_use_overlay"> <input
					name="cn_use_overlay" type="checkbox"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					id="cn_use_overlay" value="1"
					<?= (SPDSGVOSettings::get('cn_use_overlay') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text"> Blendet einen grauen Hintergrund ein und verhindert das Besucher mit der Site agiern bevor eine Wahl getroffen wurde.</span></td>
		</tr>
		<?php endif;?>
		</tbody>
	</table>

	<hr class="sp-dsgvo">




	<br>	
    <?php submit_button(); ?>
</form>

