<?php

function SPDSGVODeclinePermissionShortcode($atts){
    $atts = shortcode_atts(array(
        'button_text' => 'Decline Terms & Conditions',
    ), $atts);

    return '<span class="sp-dsgvo-framework"><a class="button" href="'. SPDSGVOExplicitPermissionAction::url(array('permission' => 'declined')) .'">'. $atts['button_text'] .'</a></span>';
}

add_shortcode('decline_permission', 'SPDSGVODeclinePermissionShortcode');
