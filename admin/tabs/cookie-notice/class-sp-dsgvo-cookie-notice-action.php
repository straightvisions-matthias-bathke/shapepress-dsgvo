<?php

Class SPDSGVOCookieNoticeAction extends SPDSGVOAjaxAction{
    
    protected $action = 'admin-cookie-notice';
    
    protected function run(){
        $this->requireAdmin();
        
        SPDSGVOSettings::set('cn_tracker_init', $this->get('cn_tracker_init', 'on_load'));
        
        SPDSGVOSettings::set('ga_enable_analytics', $this->get('ga_enable_analytics', '0'));        
        SPDSGVOSettings::set('ga_tag_number', $this->get('ga_tag_number', ''));
        
        SPDSGVOSettings::set('fb_enable_pixel', $this->get('fb_enable_pixel', '0'));
        SPDSGVOSettings::set('fb_pixel_number', $this->get('fb_pixel_number', ''));
        
        SPDSGVOSettings::set('display_cookie_notice', $this->get('display_cookie_notice', '0'));
        SPDSGVOSettings::set('cookie_notice_custom_text', $this->get('cookie_notice_custom_text', ''));
        SPDSGVOSettings::set('cn_cookie_validity', $this->get('cn_cookie_validity', '86400'));
        
        SPDSGVOSettings::set('cn_button_text_ok', $this->get('cn_button_text_ok', ''));
        SPDSGVOSettings::set('cn_reload_on_confirm', $this->get('cn_reload_on_confirm', '0'));
        
        SPDSGVOSettings::set('cn_activate_cancel_btn', $this->get('cn_activate_cancel_btn', '0'));
        SPDSGVOSettings::set('cn_button_text_cancel', $this->get('cn_button_text_cancel', ''));        
        SPDSGVOSettings::set('cn_decline_target_url', $this->get('cn_decline_target_url', ''));
        SPDSGVOSettings::set('cn_decline_no_cookie', $this->get('cn_decline_no_cookie', '0'));
        
        SPDSGVOSettings::set('cn_activate_more_btn', $this->get('cn_activate_more_btn', '0'));
        SPDSGVOSettings::set('cn_button_text_more', $this->get('cn_button_text_more', ''));
        SPDSGVOSettings::set('cn_read_more_page', $this->get('cn_read_more_page', ''));
        
        SPDSGVOSettings::set('cn_position', $this->get('cn_position', 'bottom'));
        SPDSGVOSettings::set('cn_animation', $this->get('cn_animation', 'none'));       
               
        if (isLicenceValid())
        {
            SPDSGVOSettings::set('cn_background_color', $this->get('cn_background_color', '#333333'));
            SPDSGVOSettings::set('cn_text_color', $this->get('cn_text_color', '#ffffff'));
            SPDSGVOSettings::set('cn_background_color_button', $this->get('cn_background_color_button', '#F3F3F3'));
            SPDSGVOSettings::set('cn_text_color_button', $this->get('cn_text_color_button', '#333333'));
            SPDSGVOSettings::set('cn_custom_css_container', $this->get('cn_custom_css_container', ''));
            SPDSGVOSettings::set('cn_custom_css_text', $this->get('cn_custom_css_text', ''));
            SPDSGVOSettings::set('cn_custom_css_buttons', $this->get('cn_custom_css_buttons', ''));
            
            SPDSGVOSettings::set('cn_size_text', $this->get('cn_size_text', 'auto'));
            SPDSGVOSettings::set('cn_height_container', $this->get('cn_height_container', 'auto'));        
            SPDSGVOSettings::set('cn_show_dsgvo_icon', $this->get('cn_show_dsgvo_icon', '0'));
            
            SPDSGVOSettings::set('cn_use_overlay', $this->get('cn_use_overlay', '0'));
        }
        
        $this->returnBack();
    }
}

SPDSGVOCookieNoticeAction::listen();


