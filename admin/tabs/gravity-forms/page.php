<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-gravity-forms">

	<h1>Gravity Forms</h1>

	<p>Mit diesen Einstellungen kann das Speicherverhalten von Gravity
		Forms konfiguriert werden.</p>

	<hr>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">Keine Formulardaten in der Datenbank speichern</th>
				<td><label for="gf_save_no_data"> <input name="gf_save_no_data"
						type="checkbox" id="gf_save_no_data" value="1"
						<?= (SPDSGVOSettings::get('gf_save_no_data') === '1')? ' checked ' : '';  ?>>
				</label> <span class="info-text">Wenn aktiviert, werden keine Daten
						gespeichert, sonder nur per Email versendet. (Anmerkung: Diese
						Option &uuml;berschreibt formularspezfische Einstellungen).</span></td>
			</tr>
			<tr>
				<th scope="row">Keine IP Addresse und User Agent speichern</th>
				<td><label for="gf_no_ip_meta"> <input name="gf_no_ip_meta"
						type="checkbox" id="gf_no_ip_meta" value="1"
						<?= (SPDSGVOSettings::get('gf_no_ip_meta') === '1')? ' checked ' : '';  ?>>
				</label> <span class="info-text">Standardm&auml;&szlig;ig speichert
						Gravity Forms die IP Adresse und den User Agent des Absenders.
						Wenn diese Checkbox aktiviert ist, wird dies verhindert.</span></td>
			</tr>

		</tbody>
	</table>

	<?php $gf_save_no_ = SPDSGVOSettings::get('gf_save_no_');?>

	<div>

		<h2>Spezifische Formulareinstellungen</h2>
		<h4>F&uuml;r jedes Gravity Forms Formular kann nachfolgend pro Feld
			definiert werden, ob die Daten des Eingabefeldes in der Datenbank
			gespeichert werden oder nicht.</h4>
		<table class="form-table ">
			<tbody>
				<?php foreach( SPDSGVOGravityFormsTab::get_gf_forms() as $form ) :?> 
				<tr>
					<th scope="row">Form: <?= $form['title'];?></th>
					<td>
							<?php foreach( $form['fields'] as $field ): ?>
							
								<input type="checkbox" id="" value="1"
						name="gf_save_no_[<?= $form['id'];?>][<?= $field->id;?>]"
						<?= (isset( $gf_save_no_[$form['id']][$field->id] ) && $gf_save_no_[$form['id']][$field->id] === '1')? ' checked ' : '';  ?>> <?= $field->label; ?> <small><em>(Nicht in der Datenbank speichern.)</em></small>
						
						<?php endforeach; ?>
					</td>
				</tr>
				<?php endforeach; ?>

			</tbody>
		</table>
	</div>
	<hr>
	
    <?php submit_button(); ?>
</form>

