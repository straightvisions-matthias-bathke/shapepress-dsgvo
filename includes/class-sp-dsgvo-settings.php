<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
class SPDSGVOSettings{

	public static $defaults = array(
		/////////////////////////////////////
		// common settings
		/////////////////////////////////////
		'show_setup'                      	=> '0',
		'license_key_error'                 => '1',
	    'license_activated'                 => '0',
		'api_key' 		                    => '',
		'admin_email'                      	=> '',
	    'sp_dsgvo_comments_checkbox' 	    => '0',
	    'spdsgvo_comments_checkbox_confirm'	=> 'Ich stimme zu.',
	    'spdsgvo_comments_checkbox_info' 	=> 'Die Checkbox für die Zustimmung zur Speicherung ist nach DSGVO zwingend.',
	    'spdsgvo_comments_checkbox_text' 	=> 'Dieses Formular speichert Ihren Namen, Ihre Email Adresse sowie den Inhalt, damit wir die Kommentare auf unsere Seite auswerten können. Weitere Informationen finden Sie auf unserer Seite der Datenschutzbestimmungen.',
		
		/////////////////////////////////////
		// SAR
		/////////////////////////////////////
		'sar_cron'		=> '0',
		'sar_page'		=> '0',
	    'sar_dsgvo_accepted_text'       => 'Ich stimme der Speicherung der Daten zur Verarbeitung im Sinne der DSGVO zu.',
	    

		/////////////////////////////////////
		// Third-party Services
		/////////////////////////////////////
		'user_permissions_page' => '0',

		'services' => array(
			'cookies' => array(
				'slug'      => 'cookies',
                'name'      => 'Cookies',
                'reason'    => 'Wir benutzen Cookies um das Besucherverhalten zu analysieren.',
                'link'      => '',
                'default'   => '1',
			),
			'google-analytics' => array(
				'slug'      => 'google-analytics',
                'name'      => 'Google Analytics',
                'reason'    => 'Google Analytics wird zum Anlayiseren des Websitetraffics verwendet.',
                'link'      => 'https://www.google.com/analytics/terms/us.html',
                'default'   => '1',
			),
		    'facebook-pixel' => array(
			    'slug'      => 'facebook-pixel',
			    'name'      => 'Facebook Pixel',
			    'reason'    => 'Facebook Pixel wird zum Analysieren des Besucherverhaltens verwendet.',
			    'link'      => 'https://www.facebook.com/legal/terms/update',
			    'default'   => '1',
			)
		),	


		/////////////////////////////////////
		// Unsubscribe Page
		/////////////////////////////////////
		'super_unsubscribe_page' 	   => '0',	
		'unsubscribe_auto_delete' 	   => '0',
	    'su_auto_del_time'             => '0',
	    'su_woo_data_action'           => 'ignore',
	    'su_dsgvo_accepted_text'       => 'Ich stimme der Speicherung der Daten zur Verarbeitung im Sinne der DSGVO zu.',


		/////////////////////////////////////
		// Cookie Notice
		/////////////////////////////////////
		'display_cookie_notice' 			=> '0',
		'cookie_notice' 					=> "This website uses cookies. By clicking 'accept' you are providing consent to us using cookies on this browser.",
		'cookie_notice_custom_css' 			=> "",
	    'cn_tracker_init'                   => 'on_load',
	    'ga_enable_analytics'               => '0',
	    'ga_tag_number'                     => '',
	    'fb_enable_pixel'                   => '0',
	    'fb_pixel_number'                   => '',
	    'display_cookie_notice'             => '0',
	    'cookie_notice_custom_text'         => 'Wir verwenden Cookies, um Ihnen das beste Nutzererlebnis bieten zu können. Wenn Sie fortfahren, diese Seite zu verwenden, nehmen wir an, dass Sie damit einverstanden sind.',
	    'cn_cookie_validity'                => '86400',
	    'cn_button_text_ok'                 => 'OK',
	    'cn_reload_on_confirm'              => '0',
	    'cn_activate_cancel_btn'            => '1',
	    'cn_button_text_cancel'             => 'Ablehnen',
	    'cn_decline_target_url'             => '',
	    'cn_activate_more_btn'              => '0',
	    'cn_button_text_more'               => 'Mehr Information',
	    'cn_read_more_page'                 => '',
	    'cn_position'                       => 'bottom',
	    'cn_animation'                      => 'none',
	    'cn_background_color'               => '#333333',
	    'cn_text_color'                     => '#ffffff',	
	    'cn_background_color_button'        => '#F3F3F3',
	    'cn_text_color_button'              => '#333333',
	    'cn_custom_css_container'           => '',
	    'cn_custom_css_text'                => '',
	    'cn_custom_css_buttons'             => '',
	    'cn_size_text'                      => '13px',
	    'cn_height_container'               => 'auto',
	    'cn_show_dsgvo_icon'                => '1',
	    'cn_use_overlay'                    => '0',


		/////////////////////////////////////
		// Terms Conditions
		/////////////////////////////////////
		'terms_conditions' 						=> '',
		'terms_conditions_page' 				=> '0',
		'terms_conditions_version' 				=> '1',
		'terms_conditions_hash' 				=> '',
		'force_explicit_permission_public' 		=> '0',
		'force_explicit_permission_authenticated' => '0',
		'explicit_permission_page' 				=> '0',
		'opt_out_page' 							=> '0',


		/////////////////////////////////////
		// Privacy Policy
		/////////////////////////////////////
		'privacy_policy' 		 => '',
		'privacy_policy_page' 	 => '0',
		'privacy_policy_version' => '1',
		'privacy_policy_hash' 	 => '',
	    
		/////////////////////////////////////
	    // imprint
	    /////////////////////////////////////
	    'imprint' 		 => '',
	    'imprint_page' 	 => '0',
	    'imprint_version' => '1',
	    'imprint_hash' 	 => '',
		
	);

	public static function init(){
		$users = get_users(array('role' => 'administrator'));
		$admin = (isset($users[0]))? $users[0] : FALSE;
		if(!self::get('admin_email')){
			if($admin){
			    self::set('admin_email', $admin->user_email);
			}
		}
		

		if(!self::get('privacy_policy')){
			$privacyPolicy = file_get_contents(SPDSGVO::pluginDir('privacy-policy.txt'));
// 			if($admin){
// 				$privacyPolicy = str_replace('[name]',  $admin->display_name, $privacyPolicy);
// 				$privacyPolicy = str_replace('[email]', $admin->user_email,   $privacyPolicy);
// 			}
    		SPDSGVOSettings::set('privacy_policy_hash', wp_hash($privacyPolicy));
    		self::set('privacy_policy', $privacyPolicy);
		}


		if(!self::get('terms_conditions')){
			$termsConditions = '';// file_get_contents(SPDSGVO::pluginDir('terms-conditions.txt'));
    		SPDSGVOSettings::set('terms_conditions_hash', wp_hash($termsConditions));
    		self::set('terms_conditions', $termsConditions);
		}
		
		if(!self::get('imprint')){
		    $imprint = file_get_contents(SPDSGVO::pluginDir('imprint.txt'));
		    SPDSGVOSettings::set('imprint_hash', wp_hash($imprint));
		    self::set('imprint', $imprint);
		}


		if(!self::get('services')){
		    self::set('services', array(
			    'cookies' => array(
			        'slug'      => 'cookies',
			        'name'      => 'Cookies',
			        'reason'    => 'Wir benutzen Cookies um das Besucherverhalten zu analysieren.',
			        'link'      => '',
			        'default'   => '0',
			    ),
			    'google-analytics' => array(
			        'slug'      => 'google-analytics',
			        'name'      => 'Google Analytics',
			        'reason'    => 'Google Analytics wird zum Anlayiseren des Websitetraffics verwendet.',
			        'link'      => 'https://www.google.com/analytics/terms/us.html',
			        'default'   => '0',
			    ),
			    'facebook-pixel' => array(
			        'slug'      => 'facebook-pixel',
			        'name'      => 'Facebook Pixel',
			        'reason'    => 'Facebook Pixel wird zum Analysieren des Besucherverhaltens verwendet.',
			        'link'      => 'https://www.facebook.com/legal/terms/update',
			        'default'   => '0',
			    )
				
			));
		}


		foreach(self::$defaults as $setting => $value){
		    if(!self::get($setting)){
		        self::set($setting, $value);
			}
		}
	}

	public static function set($property, $value){
		update_option('sp_dsgvo_'.$property, $value);
	}

	public static function get($property){
		$value = get_option('sp_dsgvo_'.$property);

		if($value !== '0'){
			if(!$value || empty($value)){
			    $value = @self::$defaults[$property];
			}
		}

		return $value;
	}
	
	public static function getDefault($property){
	    
	    $value = @self::$defaults[$property];
	    
	    return $value;
	}


	public function __get($property){
	    return self::get($property);
	}

	public function __set($property, $value){
	    return self::set($property, $value);
	}
}
