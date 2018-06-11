<h1>Integrations</h1>
<hr>

<form method="post" action="<?= SPDSGVOIntegrationsAction::formURL() ?>">
	<input type="hidden" name="action" value="<?= SPDSGVOIntegrationsAction::getActionName() ?>">

	<table class="form-table">
		<tbody>
			
			<?php $integrations = SPDSGVOIntegration::getAllIntegrations(FALSE); ?>
			<?php if(count($integrations) === 0): ?>

				<tr>
					<th scope="row">No integrations installed</th>
					<td></td>
				</tr>

			<?php else: ?>

				<?php foreach($integrations as $key => $integration): ?>

					<tr>
						<th scope="row"><?= $integration->title ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span><?= $integration->title ?></span>
								</legend>

								<label for="<?= $integration->slug ?>">
									<input name="integrations[<?= $integration->slug ?>]" type="checkbox" id="<?= $integration->slug ?>" value="1" <?= (SPDSGVOIntegration::isEnabled($integration->slug))? ' checked ' : '';  ?>>
								</label>
							</fieldset>
						</td>
					</tr>

				<?php endforeach; ?>
			<?php endif; ?>

		</tbody>
	</table>

	<?php submit_button(); ?>
</form>
