<h1>Datenschutz</h1>
<p>
	Mit dem Shortcode <code>[privacy_policy]</code> wird eine Datenschutzseite aus den unter Allgemeinen Einstellungen get&auml;tigten Eingaben generiert..
</p>
<p>Initial wird dieser Text mit einer Vorlage bef&uuml;llt. Die Textbausteine in den rechteckigen Klammern ([]) werden mit den Werten belegt, die sie in den Allgemeinen Einstellungen eingegeben haben. Sie k&ouml;nnen den kompletten Text ihren Anforderungen anpassen, sowie Textpassagen rausl&ouml;schen falls diese bei ihnen nicht zutreffen.
</p>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<table class="form-table btn-settings-show">
		<tbody>
			<tr>
				<th scope="row">Datenschutz Seite</th>
				<td>
						<?php $privacyPolicyPage = SPDSGVOSettings::get('privacy_policy_page'); ?>
						<label for="privacy_policy_page">Seite:
							<select name="privacy_policy_page" id="privacy_policy_page">
								<option value="0">W&auml;hlen</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($privacyPolicyPage == $page->ID) ?> value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>							

						<?php if($privacyPolicyPage == '0'): ?>
							<p>Eine Seite erstellen die den Shortcode <code>[privacy_policy]</code> verwendet.  <a class="button button-default" href="<?= SPDSGVOCreatePageAction::url(array('privacy_policy_page' => '1')) ?>">Seite erstellen</a></p>
						<?php elseif(!pageContainsString($privacyPolicyPage, 'privacy_policy')): ?>
							<p>Achtung: Der Shortcode <code>[privacy_policy]</code> wurde auf der von ihnen gew&auml;hlten Seite nicht gefunden. <a href="<?= get_edit_post_link($privacyPolicyPage) ?>">Seite bearbeiten</a></p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($privacyPolicyPage) ?>">Seite bearbeiten</a>
						<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<hr class="sp-dsgvo">


	<input type="hidden" name="action" value="privacy-policy">
	
	<br>
	<?php 
    	$pageContent = SPDSGVOSettings::get('privacy_policy');
    	if ($pageContent == NULL || strlen($pageContent) < 10)
    	{
    	    $pageContent = file_get_contents(SPDSGVO::pluginDir('privacy-policy.txt'));
    	    //$pageContent = mb_convert_encoding($pageContent, 'HTML-ENTITIES', "UTF-8");
    	}
	
    	wp_editor($pageContent, 'privacy_policy', array('textarea_rows'=> '20'));     	
	?>
    <?php submit_button(); ?>
 
</form>

