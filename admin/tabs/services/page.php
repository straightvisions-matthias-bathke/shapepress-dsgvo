<h1>Datenschutz: Einstellungen und 3rd Party Plugins</h1>
<p>Hier k&ouml;nnen alle 3rd Party Plugins (Google Analytics, Facebook Pixel,..) aufgelistet werden um ihren Benutzern ein selektives Opt-In/Opt-Out zu erm&ouml;glichen.</p>
<p>Mit dem Shortcode <code>[display_services]</code> k&ouml;nnen diese Dienste dann dem User angezeigt werden.</p>


<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-services">

	<table class="form-table btn-settings-show" >
		<tbody>
			<tr>
				<th scope="row">Datenschutz Seite f&uuml;r ihre Benutzer</th>
				<td>

						<ul>
							<li>
								<label for="user_permissions_page">Seite:
									<select name="user_permissions_page" id="user_permissions_page">
										<option value="0">W&auml;hlen</option>

										<?php $userPermissionsPage = SPDSGVOSettings::get('user_permissions_page'); ?>
										<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
											<option <?= selected($userPermissionsPage == $page->ID) ?> value="<?= $page->ID ?>">
												<?= $page->post_title ?>
											</option>
										<?php endforeach; ?>
									</select>
								</label>
								<span class="info-text">Gibt die Seite an auf der Benutzer die M&ouml;glichkeit haben ihre Datenschutzeinstellungen (selektivies Opt-In/Opt-out) anzupassen.</span>							
							</li>
						</ul>
						
						<?php if($userPermissionsPage == '0'): ?>
							<p>
							Eine Seite erstellen die den Shortcode <code>[user_privacy_settings_form]</code> verwendet.
							<a class="button button-default"
								href="<?= SPDSGVOCreatePageAction::url(array('user_privacy_settings_page' => '1')) ?>">Seite erstellen</a>
						   </p>
						
						<?php elseif($userPermissionsPage != '0' && strpos(get_post($userPermissionsPage)->post_content, 'user_privacy_settings_form') === FALSE): ?>
							<p>Achtung: Der Shortcode <code>[user_privacy_settings_form]</code> wurde auf der gew&auml;hlten Seite nicht gefunden. Das Formular wird somit nicht angezeigt. <a href="<?= get_edit_post_link($userPermissionsPage) ?>">Seite bearbeiten</a></p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($userPermissionsPage) ?>">Seite bearbeiten</a>
						<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<hr class="sp-dsgvo">


	
    <table class="widefat fixed" cellspacing="0">
	    <thead>
		    <tr>
				<th id="slug" class="manage-column column-slug" scope="col" style="width:12%">Slug</th>
				<th id="name" class="manage-column column-name" scope="col">Name</th>
				<th id="reason" class="manage-column column-reason" scope="col">Grund</th>
				<th id="reason" class="manage-column column-link" scope="col">AGB URL</th>
				<th id="default" class="manage-column column-default" scope="col" style="width:10%">Standard</th>
				<th id="delete" class="manage-column column-delete" scope="col" style="width:10%">L&ouml;schen</th>
		    </tr>
	    </thead>

	    <tbody>
			<?php $i = 0; // AB: This is justified ?>
	    	<?php foreach(SPDSGVOSettings::get('services') as $slug => $service): ?>

		        <tr class="<?= ($i % 2 == 0)? 'alternate' : '' ?>">
		            <td class="column-slug">
		            	<span><?= $slug ?></span>
		            	<input type="hidden" name="services[<?= $slug ?>][slug]" value="<?= $slug ?>">
		            </td>
		            <td class="column-name">
		            	<input type="text" class="aio-transparent" name="services[<?= $slug ?>][name]" value="<?= $service['name'] ?>">
		            </td>
		            <td class="column-reason">
		            	<textarea class="aio-transparent" name="services[<?= $slug ?>][reason]" id="" cols="30" rows="5"><?= $service['reason'] ?></textarea>
					</td>

		            <td class="column-link">
		            	<input type="text" class="aio-transparent" placeholder="Terms & Conditions link" name="services[<?= $slug ?>][link]" value="<?= $service['link'] ?>">
		            </td>
		            <td class="column-default">
						<select name="services[<?= $slug ?>][default]">
							<option <?= ($service['default'] == '1')? ' selected ' : '' ?> value="1">Aktiviert</option>
							<option <?= ($service['default'] == '0')? ' selected ' : '' ?> value="0">Deaktiviert</option>
						</select>
					</td>
		            <td class="column-reason">
		            	<a href="<?= SPDSGVODeleteServiceAction::url(['slug' => $slug]) ?>">L&ouml;schen</a>
					</td>
		        </tr>
				
				<?php $i++; ?>
	    	<?php endforeach; ?>
	    </tbody>

	    <tfoot>
		    <tr>
				<th class="manage-column column-slug" scope="col">Slug</th>
				<th class="manage-column column-name" scope="col">Name</th>
				<th class="manage-column column-reason" scope="col">Grund</th>
				<th class="manage-column column-link" scope="col">AGB URL</th>
				<th class="manage-column column-default" scope="col">Standard</th>
				<th class="manage-column column-delete" scope="col">L&ouml;schen</th>
		    </tr>
	    </tfoot>
	</table>
	
	<?php submit_button(); ?>
</form>


<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-add-service">
	<br><br>	

	<h3>Dienst hinzuf&uuml;gen</h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="new_name">Name</label></th>
				<td>
					<input name="new_name" type="text" id="new_name" value="" class="regular-text ltr">
					<p class="description" >Der Name des Dienstes</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="new_reason">Grund</label></th>
				<td>
					<input name="new_reason" type="text" id="new_reason" value="" class="regular-text ltr">
					<p class="description">Der Grund f&uuml;r die Benutzung</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="new_link">AGB URL</label></th>
				<td>
					<input name="new_link" type="text" id="new_link" value="" class="regular-text ltr">
					<p class="description">Die URL zu den AGB des Dienstes</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="new_default">Standard</label></th>
				<td>
					<select name="new_default">
						<option value="1">Aktiviert</option>
						<option value="0">Deaktiviert</option>
					</select>
					<p class="description">Gibt an ob der Dienst standardm&auml;&szlig;ig aktiviert sein soll oder nicht.</p>
				</td>
			</tr>
		</tbody>
	</table>

	<?php submit_button('Dienst hinzuf&uuml;gen'); ?>
</form>