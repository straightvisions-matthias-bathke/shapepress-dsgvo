<div class="wrap dsgvo-wrap" style="">
	<h2>WP DSGVO Tools</h2>

	<h2 class="nav-tab-wrapper">
        <?php foreach($tabs as $t): ?>
        	<?php if(!$t->isHidden()): ?>
	            <a href="<?= $t->uri() ?>"
			class="nav-tab <?= ($tab === $t->slug)? 'nav-tab-active' : '' ?> <?= ($t->isHighlighted())? 'nav-tab-highlighted' : '' ?>">
	                <?= $t->title ?>
	            </a>
	        <?php endif; ?>
        <?php endforeach; ?>
    </h2>

    <?php
    if (isset($tabs[$tab])) {
        $tabs[$tab]->page();
    } else {
        $tabs['common-settings']->page();
    }
    ?>
</div>


<div class="wrap-premium">

	<form id="checklist-form" method="post"
		action="<?= admin_url('/admin-ajax.php'); ?>">
		<input type="hidden" name="action" value="admin-common-action">

		<div style="border: dashed 1px black; padding: 10px;">
			<span style="font-size: 1.2rem; line-height: 1.3rem;">WP DSGVO Tools
				ist unverbindlich &amp; ersetzt keine Expertenberatung</span>
		</div>
		<h2 style="margin-bottom: 0">DSGVO Website Selbstcheck</h2>
		<small>(Umfasst nur Ihren Webauftritt!)</small>
		<ul id="dsgvo-checklist">
			<li><input id="cb_spdsgvo_cl_vdv" name="cb_spdsgvo_cl_vdv"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_vdv') === '1')? ' checked ' : '';  ?> /><span>
					VdV (Verzeichnis der Verarbeitungst&auml;tigkeiten) <a href="https://www.wp-dsgvo.eu/spdsgvo-bin/wp-dsgvp-tools-vdv.xls">heruntergeladen</a>
					&amp; ausgef&uuml;llt
			</span></li>
			<li><input id="cb_spdsgvo_cl_filled_out"
				name="cb_spdsgvo_cl_filled_out" type="checkbox" class="cbChecklist"
				value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_filled_out') === '1')? ' checked ' : '';  ?> /><span>
					WP DSGVO Tools Plugin vollst&auml;ndig ausgef&uuml;llt</span></li>
			<li><input id="cb_spdsgvo_cl_maintainance"
				name="cb_spdsgvo_cl_maintainance" type="checkbox"
				class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_maintainance') === '1')? ' checked ' : '';  ?> /><span>
					Monatliche Wartung der Website (Wartungsvertrag beim Webdesigner)</span></li>
			<li><input id="cb_spdsgvo_cl_security" name="cb_spdsgvo_cl_security"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_security') === '1')? ' checked ' : '';  ?> /><span>
					Sicherheitsvorkehrungen (Starke Passw&ouml;rter, wer hat
					Zugriff,...)</span></li>
			<li><input id="cb_spdsgvo_cl_hosting" name="cb_spdsgvo_cl_hosting"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_hosting') === '1')? ' checked ' : '';  ?> /><span>
					DSGVO konformes und sicheres Web-Hosting? Unsere Empfehlung: <a
					href="https://raidboxes.de/?aid=14330" target="_blank">Raidboxes</a>
			</span></li>
			<li><input id="cb_spdsgvo_cl_plugins" name="cb_spdsgvo_cl_plugins"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_plugins') === '1')? ' checked ' : '';  ?> /><span>
					Sicherheit von nicht unterst&uuml;tzten Plugins pr&uuml;fen</span></li>
			<li><input id="cb_spdsgvo_cl_experts" name="cb_spdsgvo_cl_experts"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_experts') === '1')? ' checked ' : '';  ?> /><span>
					<a href="https://www.wp-dsgvo.eu/experten/"
					target="_blank">Expertenberatung</a> angefordert
			</span></li>
		</ul>
		<?php if (isLicenceValid() == false) :  ?>
		<h1 style="margin-top: 1em">Neu: Blog Edition!</h1>
		<ul id="dsgvo-premium-featurelist">
			<li>Stylebare Cookie Notice: Passe das Look &amp; Feel deiner Wordpress Page an!</li>
			<li>Texte bei Kommentarcheckbox anpassbar</li>
		</ul>
		<div>
			<a href="https://www.wp-dsgvo.eu/shop" target="_blank"
				class="button button-primary" style="font-size: 1rem">Jetzt die Blog Edition holen</a>
		</div>
		<?php endif;?>
		<h1 style="margin-top: 1em">Upgrade to Premium</h1>
		<ul id="dsgvo-premium-featurelist">
			<li>Support &amp; Community</li>
			<li>Woocommerce Integration</li>
			<li>Automatische Userdaten Ausz&uuml;ge</li>
			<li>Email Benachrichtigungen</li>
			<li>Style &amp; Farbanpassungen (Ab Blog Edition)</li>
			<li>Texte bei Kommentarcheckbox anpassbar (Ab Blog Edition)</li>
		</ul>
		<div>
			<a href="https://www.wp-dsgvo.eu/shop" target="_blank"
				class="button button-primary" style="font-size: 1rem">Hol dir jetzt
				unser Premium Plugin</a>
		</div>
		<ul id="dsgvo-premium-featurelist-tipps">
			<li>FAQ &amp; Checklisten</li>
			<li>DSGVO Experten buchen</li>
			<li>Rechtliche Beratung buchen</li>
		</ul>
		

</form>
</div>