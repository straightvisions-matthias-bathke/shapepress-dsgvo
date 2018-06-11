<h1>L&ouml;schanfragen</h1>
<p>Hier finden sie alle L&ouml;schanfragen die User ihrer Seite gestellt haben. 
  Mit einem klick auf "Jetzt l&ouml;schen" l&ouml;schen sie alle gespeicherten Daten des Users auf ihrer Seite inklusive Plugins.
</p>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action"
		value="<?= SPDSGVOSuperUnsubscribeAction::getActionName(); ?>"> <input
		type="hidden" name="CSRF" value="<?= sp_dsgvo_CSRF_TOKEN() ?>">

	<table class="form-table">
		<tbody>
            <tr>
            <th scope="row">Automatisches L&ouml;schen</th>
            <td></td>
            </tr>
			<tr>
				<td>Sofort bei Anfrage</td>
				<td><label for="unsubscribe_auto_delete"> <input
						name="unsubscribe_auto_delete" type="checkbox"
						id="unsubscribe_auto_delete" value="1"
						<?= (SPDSGVOSettings::get('unsubscribe_auto_delete') === '1')? ' checked ' : '';  ?>>
				</label>
					<span class="info-text">Wenn aktiviert, werden L&ouml;schanfragen sofort durchgef&uuml;hrt.</span></td>
			</tr>
			<tr>
				<td>Nach Zeit</td>
				<td>
				<?php $suAutoDelTime = SPDSGVOSettings::get('su_auto_del_time'); ?>
    			<label for="su_auto_del_time"> <select name="su_auto_del_time"
    					id="su_auto_del_time">
    						<option value="0" <?= selected($suAutoDelTime === '0') ?>>keine</option>
    						<option value="1m" <?= selected($suAutoDelTime === '1m') ?>>1 Monat</option>
    						<option value="3m" <?= selected($suAutoDelTime === '3m') ?>>3 Monate</option>
    						<option value="6m" <?= selected($suAutoDelTime === '6m') ?>>6 Monate</option>
    						<option value="1y" <?= selected($suAutoDelTime === '1y') ?>>1 Jahr</option>
    						<option value="6y" <?= selected($suAutoDelTime === '6y') ?>>6 Jahre</option>
    						<option value="7y" <?= selected($suAutoDelTime === '7y') ?>>7 Jahre</option>
    				</select>
    			</label>
					<span class="info-text">Daten werden nach eingestellter Zeit
						automatisch gel&ouml;scht. Stellt die maximale Aufbewahrungszeit sicher.</span></td>
			</tr>

            <tr>
                <td>DSGVO Zustimmungstext:</td>
                <td>
                	<input
					name="su_dsgvo_accepted_text" type="text" style="width: 550px;"
					id="su_dsgvo_accepted_text" value="<?= SPDSGVOSettings::get('su_dsgvo_accepted_text');  ?>">
                	<span class="info-text">Der Text der bei der Checkbox f&uuml; die Datenspeicherung angezeigt werden soll</span>
                </td>
            </tr>

			<?php if (enablePremiumFeatures()) :  ?>
            <tr>
				<td>WooCommerce Daten</td>
				<td>
				<?php $wooDataAction = SPDSGVOSettings::get('su_woo_data_action'); ?>
    			<label for="su_woo_data_action"> <select name="su_woo_data_action"
    					id="su_woo_data_action">
    						<option value="ignore" <?= selected($wooDataAction === 'ignore') ?>>Keine Aktion</option>
    						<option value="pseudo" <?= selected($wooDataAction === 'pseudo') ?>>Pseudonymisieren</option>
    						<option value="del" <?= selected($wooDataAction === 'del') ?>>L&ouml;schen</option>
    				</select>
    			</label>
					<span class="info-text">Gibt an was mit pers&ouml;nlichen Daten von Bestellungen passieren soll.</span></td>
			</tr>
			<?php endif;?>

			<tr>
				<th scope="row">Seite f&uuml;r L&ouml;schanfrage:</th>
				<td>

						<?php $unsubscribePage = SPDSGVOSettings::get('super_unsubscribe_page'); ?>
						<label for="super_unsubscribe_page"><select
							name="super_unsubscribe_page" id="super_unsubscribe_page">
								<option value="0">W&auml;hlen</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($unsubscribePage == $page->ID) ?>
									value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>							

						<?php if($unsubscribePage == '0'): ?>
							<p>
							Eine Seite erstellen die den Shortcode <code>[unsubscribe_form]</code> verwendet.
							<a class="button button-default"
								href="<?= SPDSGVOCreatePageAction::url(array('super_unsubscribe_page' => '1')) ?>">Seite erstellen</a>
						</p>
						<?php elseif(!pageContainsString($unsubscribePage, 'unsubscribe_form')): ?>
							<p>
							Achtung: Der Shortcode
							<code>[unsubscribe_form]</code>
							wurde auf der von ihnen gew&auml;hlten Seite nicht gefunden. Somit hat der User keine M&ouml;glichkeit eine L&ouml;schanfrage zu stellen.  <a
								href="<?= get_edit_post_link($unsubscribePage) ?>">Seite bearbeiten</a>
						</p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($unsubscribePage) ?>">Seite bearbeiten</a>
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

<?php
$statuses = array(
    'pending',
    'done'
);
if (in_array($_GET['status'], $statuses)) {
    $status = $_GET['status'];
} else {
    $status = 'pending';
}
?>

<ul class="subsubsub">
		<li>
			<a
		href="<?= SPDSGVO::adminURL(array('tab' => 'super-unsubscribe', 'status' => 'pending')) ?>"
		class="<?= ($status === 'pending')? 'current' : '';  ?>" aria-current="page">
				Ausstehend
			</a>
	</li>
	<li>
			<a
		href="<?= SPDSGVO::adminURL(array('tab' => 'super-unsubscribe', 'status' => 'done')) ?>"
		class="<?= ($status === 'done')? 'current' : '';  ?>" aria-current="page">
				Erledigt
			</a>
	</li>
</ul>
<br>
<br>

<?php $confirmed = SPDSGVOUnsubscriber::finder('status', array('status' => $status)); ?>
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
			<th id="status" class="manage-column column-status" scope="col"
				style="width: 15%">Status</th>
			<th id="process" class="manage-column column-process" scope="col"
				style="width: 15%">Jetzt l&ouml;schen</th>
		</tr>
	</thead>

	<tbody>
		<?php if(count($confirmed) !== 0): ?>
			<?php foreach($confirmed as $key => $confirmedRequest): ?>

				<tr class="<?= ($key % 2 == 0)? 'alternate' : '' ?>">
			<td class="column-request-id">
						<?= $confirmedRequest->ID ?>
					</td>
			<td class="column-email"><strong><?= $confirmedRequest->email ?></strong>
			</td>
			<td class="column-integrations">
						<?= $confirmedRequest->first_name ?>
					</td>
			<td class="column-auto-deleting-on">
						<?= $confirmedRequest->last_name ?>
					</td>
			<td class="column-auto-deleting-on">
						<?= $confirmedRequest->dsgvo_accepted === '1' ? 'Ja' : 'Nein' ?>
			</td>
			<td class="column-auto-deleting-on">
						<?= ucfirst($confirmedRequest->status) ?>
					</td>
			<td class="column-unsubscribe-user">

						<?php if($status == 'done'): ?>
							<a class="button-primary disabled" href="#">Delete Now</a>
						<?php else: ?>
							<a class="button-primary"
				href="<?= SPDSGVOSuperUnsubscribeAction::url(array('process' => $confirmedRequest->ID)) ?>">Jetzt l&ouml;schen</a>
						<?php endif; ?>
					</td>
		</tr>
				
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
			<td class="column-slug" colspan="2">
					<?php if($status == 'done'): ?>
						<h4>Es wurden noch keine L&ouml;schanfragen durchgef&uuml;hrt.</h4>
					<?php else: ?>
						<h4>Keine L&ouml;schanfragen vorhanden.</h4>
					<?php endif; ?>
				</td>
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
			<th class="manage-column column-status" scope="col">Status</th>
			<th class="manage-column column-process" scope="col">Jetzt l&ouml;schen</th>
		</tr>
	</tfoot>
</table>

<?php if(count($pending) !== 0): ?>
<p>
	<a class="button-primary"
		href="<?= SPDSGVOSuperUnsubscribeAction::url(array('all' => '1')) ?>">Alle löschen</a>
</p>
<?php endif; ?>


<br>
<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action"
		value="<?= SPDSGVOSuperUnsubscribeFormAction::getActionName(); ?>"> <input
		type="hidden" name="is_admin" value="1"> <br>
	<br>

	<h3>L&ouml;schanfrage hinzuf&uuml;gen</h3>
		<span style="color:red">ACHTUNG: Mit Ausf&uuml;hren dieser Aktion wird der Account gel&ouml;scht (Administratoren ausgenommen).</span>
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
				<th scope="row"><label for="process_now">Ohne Benutzerbest&auml;tigung ausf&uuml;hren</label></th>
				<td><input name="process_now" type="checkbox" id="process_now"
					value="1"></td>
			</tr>
		</tbody>
	</table>

	<?php submit_button('Hinzuf&uuml;gen'); ?>
</form>