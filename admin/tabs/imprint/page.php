<h1>Impressum</h1>
<p>Mit dem Shortcode<code>[imprint]</code> wird ein Impressum aus den unter Allgemeinen Einstellungen get&auml;tigten Eingaben generiert.</p>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="imprint">

	<table class="form-table btn-settings-show">
		<tbody>
			<tr>
				<th scope="row">Impressum Seite:</th>
				<td>
						
						<?php $imprintPage = SPDSGVOSettings::get('imprint_page'); ?>
						<label for="imprint_page">Page:
							<select name="imprint_page" id="imprint_page">
								<option value="0">W&auml;hlen</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($imprintPage == $page->ID) ?> value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>							

						<?php if($imprintPage == '0'): ?>
							<p>Eine Seite erstellen die den Shortcode <code>[imprint]</code> verwendet. <a class="button button-default" href="<?= SPDSGVOCreatePageAction::url(array('imprint_page' => '1')) ?>">Seite erstellen</a></p>
						<?php elseif(!pageContainsString($imprintPage, 'imprint')): ?>
							<p>Achtung: Der Shortcode <code>[imprint]</code> wurde auf der von ihnen gew&auml;hlten Seite nicht gefunden. <a href="<?= get_edit_post_link($imprintPage) ?>">Seite bearbeiten</a></p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($imprintPage) ?>">Seite bearbeiten</a>
						<?php endif; ?>
				</td>
			</tr>

			
		</tbody>
	</table>
	<hr class="sp-dsgvo">


	<br>
	<?php 
	$imprintContent = SPDSGVOSettings::get('imprint');
	if ($imprintContent == NULL || strlen($imprintContent) < 10)
	{
	    $imprintContent = file_get_contents(SPDSGVO::pluginDir('imprint.txt'));
	
	  
	}
	wp_editor($imprintContent, 'imprint', array('textarea_rows'=> '20')); 
	
	?>    
    <?php submit_button(); ?>
</form>

