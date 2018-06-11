<?php

function SPDSGVODisplayServicesShortcode(){
    ob_start();
    ?>
    	<ul>
    		<?php foreach(SPDSGVOSettings::get('services') as $slug => $service): ?>
	    		<li>
	    			<strong><?= $service['name'] ?>: </strong>
	    			<?= $service['reason'] ?>

	    			<?php if($service['link']): ?>
	    				<a href="<?= $service['link'] ?>">AGB des Dienstes aufrufen</a>
	    			<?php endif; ?>
	    		</li>
    		<?php endforeach; ?>
    	</ul>
	<?php
	return ob_get_clean();
}

add_shortcode('display_services', 'SPDSGVODisplayServicesShortcode');
