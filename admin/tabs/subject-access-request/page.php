<h1>Datenauszug</h1>
<p>
	Mit diesem Feature k&ouml;nnen User einen Auszug &uuml;ber alle von
	ihnen gespeicherten Daten anfordern. <br> S&auml;mtliche Daten in ihrer
	Datenbank werden auf vertrauliche Daten &uuml;berpr&uuml;ft und dem
	User per Email gesendet.
</p>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action"
		value="<?= SPDSGVOAdminSubjectAccessRequestAction::getActionName(); ?>">

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">Automatisch Abarbeitung</th>
				<td>
				<?php $sarCron = SPDSGVOSettings::get('sar_cron'); ?>
    			<label for="sar_cron"> <select name="sar_cron"
    					id="sar_cron">
    						<option value="0" <?= selected($sarCron === '0') ?>>keine</option>
    						<option value="1" <?= selected($sarCron === '1') ?>>1 Tag</option>
    						<option value="2" <?= selected($sarCron === '2') ?>>2 Tage</option>
    						<option value="3" <?= selected($sarCron === '3') ?>>3 Tage</option>
    						<option value="7" <?= selected($sarCron === '4') ?>>1 Woche</option>
    				</select>
    			</label>
					<span class="info-text">Anfragen werden nach eingestellter Zeit
						automatisch bearbeitet und dem User gesendet.</span></td>
			</tr>
             <tr>
                <td>DSGVO Zustimmungstext:</td>
                <td>
                	<input
					name="sar_dsgvo_accepted_text" type="text"  style="width: 550px;"
					id="sar_dsgvo_accepted_text" 	value="<?= SPDSGVOSettings::get('sar_dsgvo_accepted_text');  ?>">
                	<span class="info-text">Der Text der bei der Checkbox f&uuml; die Datenspeicherung angezeigt werden soll</span>
                </td>
            </tr>
			<tr>
				<th scope="row">Seite zum Anfordern:</th>
				<td>

						<?php $sarPage = SPDSGVOSettings::get('sar_page'); ?>
						<label for="sar_page"><select name="sar_page" id="sar_page">
								<option value="0">W&auml;hlen</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($sarPage == $page->ID) ?>
									value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>
						<span class="info-text">Gibt die Seite an auf der Benutzer die M&ouml;glichkeit haben ihren Datenauszug anzufordern.</span>							

						<?php if($sarPage == '0'): ?>
							<p>
							Eine Seite erstellen die den Shortcode <code>[sar_form]</code> verwendet.
							<a class="button button-default"
								href="<?= SPDSGVOCreatePageAction::url(array('sar' => '1')) ?>">Seite erstellen</a>
						</p>
						<?php elseif(!pageContainsString($sarPage, 'sar_form')): ?>
							<p>
							Achtung: Der Shortcode
							<code>[sar_form]</code>
							wurde auf der von ihnen gew&auml;hlten Seite nicht gefunden. Somit hat der User keine M&ouml;glichkeit zur Anforderung der Daten. <a
								href="<?= get_edit_post_link($sarPage) ?>">Seite bearbeiten</a>
						</p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($sarPage) ?>">Seite bearbeiten</a>
						<?php endif; ?>
				</td>
			</tr>

			<tr>
				<th><?php submit_button(); ?></th>
				<td></td>
			</tr>
		</tbody>
	</table>

	<hr class="sp-dsgvo">
</form>


<?php $pending = SPDSGVOSubjectAccessRequest::finder('pending'); ?>
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="request_id" class="manage-column column-request_id"
				scope="col" style="width: 10%">ID</th>
			<th id="email" class="manage-column column-email" scope="col"
				style="width: 20%">Email</th>
			<th id="first_name" class="manage-column column-first_name"
				scope="col" style="width: 15%">Vorname</th>
			<th id="last_name" class="manage-column column-last_name" scope="col"
				style="width: 15%">Nachname</th>
			<th id="dsgvo_accepted" class="manage-column column-dsgvo_accepted" scope="col"
				style="width: 15%">DSGVO Zustimmung</th>
			<th id="process" class="manage-column column-process" scope="col"
				style="width: 15%">Ausf&uuml;hren</th>
		</tr>
	</thead>

	<tbody>
		<?php if(count($pending) !== 0): ?>
			<?php foreach($pending as $key => $pendingRequest): ?>

				<tr class="<?= ($key % 2 == 0)? 'alternate' : '' ?>">
			<td class="column-request-id">
						<?= $pendingRequest->ID ?>
					</td>
			<td class="column-email"><strong><?= $pendingRequest->email ?></strong>
			</td>
			<td class="column-integrations">
						<?= $pendingRequest->first_name ?>
					</td>
			<td class="column-auto-deleting-on">
						<?= $pendingRequest->last_name ?>
					</td>
			<td class="column-auto-deleting-on">
						<?= $pendingRequest->dsgvo_accepted === '1' ? 'Ja' : 'Nein' ?>
			</td>
			<td class="column-unsubscribe-user"><a class="button-primary"
				href="<?= SPDSGVOAdminSubjectAccessRequestAction::url(array('process' => $pendingRequest->ID)) ?>">Ausf&uuml;hren</a></td>
		</tr>
				
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
			<td class="column-slug" colspan="2">Keine offenen Anfragen vorhanden.</td>
			<td class="column-default"></td>
			<td class="column-reason"></td>
		</tr>
		<?php endif; ?>
	</tbody>

	<tfoot>
		<tr>
			<th class="manage-column column-request_id" scope="col">ID</th>
			<th class="manage-column column-email" scope="col">Email</th>
			<th class="manage-column column-first_name" scope="col">Vorname</th>
			<th class="manage-column column-last_name" scope="col">Nachname</th>
			<th class="manage-column column-dsgvo_accepted" scope="col">DSGVO Zustimmung</th>			
			<th class="manage-column column-process" scope="col">Ausf&uuml;hren</th>
		</tr>
	</tfoot>
</table>

<?php if(count($pending) !== 0): ?>
<p>
	<a class="button-primary"
		href="<?= SPDSGVOAdminSubjectAccessRequestAction::url(array('all' => '1')) ?>">Alle ausf&uuml;hren</a>
</p>
<?php endif; ?>



<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action"
		value="<?= SPDSGVOSubjectAccessRequestAction::getActionName(); ?>"> <input
		type="hidden" name="is_admin" value="1"> <br>
	<br>

	<h3>Datenauszug hinzuf&uuml;gen</h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="email">Email <span style="color: #F00">*</span></label></th>
				<td><input name="email" type="email" id="email" value=""
					class="regular-text ltr" required></td>
			</tr>
			<tr>
				<th scope="row"><label for="first_name">Vorname</label></th>
				<td><input name="first_name" type="text" id="first_name" value=""
					class="regular-text ltr"></td>
			</tr>
			<tr>
				<th scope="row"><label for="last_name">Nachname</label></th>
				<td><input name="last_name" type="text" id="last_name" value=""
					class="regular-text ltr"></td>
			</tr>
			<tr>
				<th scope="row"><label for="dsgvo_checkbox">DSGVO Speicherungszustimmung</label></th>
				<td><input name="dsgvo_checkbox" type="checkbox" id="dsgvo_checkbox"
					value="1"></td>
			</tr>
			<tr>
				<th scope="row"><label for="process_now">Sofort ausf&uuml;hren</label></th>
				<td><input name="process_now" type="checkbox" id="process_now"
					value="1"></td>
			</tr>
			<tr style="display: none;">
				<th scope="row"><label for="display_email">Email anzeigen</label></th>
				<td><input name="display_email" type="checkbox" id="display_email"
					value="1"></td>
			</tr>
		</tbody>
	</table>

	<?php submit_button('Hinzuf&uuml;gen'); ?>
</form>