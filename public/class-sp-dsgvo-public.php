<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package WP DSGVO Tools
 * @subpackage WP DSGVO Tools/public
 * @author Shapepress eU
 */
class SPDSGVOPublic
{

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $sp_dsgvo
     *            The name of the plugin.
     * @param string $version
     *            The version of this plugin.
     */
    public function __construct()
    {}

    private static $cookie = array(
        'name' => 'sp_dsgvo_cn_accepted',
        'value' => 'TRUE'
    );

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(sp_dsgvo_NAME, plugin_dir_url(__FILE__) . 'css/sp-dsgvo-public.css', array(), sp_dsgvo_VERSION, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(sp_dsgvo_NAME, plugin_dir_url(__FILE__) . 'js/sp-dsgvo-public.js', array(
            'jquery'
        ), sp_dsgvo_VERSION, FALSE);
        
        wp_localize_script(sp_dsgvo_NAME, 'cnArgs', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'hideEffect' => SPDSGVOSettings::get('cn_animation'),
            'onScroll' => false,
            'onScrollOffset' => 100,
            'cookieName' => self::$cookie['name'],
            'cookieValue' => self::$cookie['value'],
            'cookieTime' => SPDSGVOSettings::get('cn_cookie_validity'),
            'cookiePath' => (defined('COOKIEPATH') ? COOKIEPATH : ''),
            'cookieDomain' => (defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : ''),
            'redirection' => SPDSGVOSettings::get('cn_reload_on_confirm'),
            'reloadOnConfirm' => SPDSGVOSettings::get('cn_reload_on_confirm'),
            'trackerInitMoment' => SPDSGVOSettings::get('cn_tracker_init'),
            'gaTagNumber' => SPDSGVOSettings::get('ga_tag_number'),
            'cache' => defined('WP_CACHE') && WP_CACHE,
            'declineTargetUrl' => SPDSGVOSettings::get('cn_decline_target_url'),
            'declineNoCookie' => SPDSGVOSettings::get('cn_decline_no_cookie'),
            'commentsCb'=> SPDSGVOSettings::get('sp_dsgvo_comments_checkbox'),
            'cf7AccReplace' => SPDSGVOSettings::get('sp_dsgvo_cf7_acceptance_replace'),
            'cf7AccText' => SPDSGVOSettings::get('spdsgvo_comments_checkbox_text')
        ));
    }

    /**
     * Print scripts for GA, FB Pixel,..
     * if enabled
     *
     * @return mixed
     */
    public function wp_print_footer_scripts()
    {
        // $allowed_html = apply_filters( 'cn_refuse_code_allowed_html', array_merge( wp_kses_allowed_html( 'post' ), array(
        // 'script' => array(
        // 'type' => array(),
        // 'src' => array(),
        // 'charset' => array(),
        // 'async' => array()
        // ),
        // 'noscript' => array()
        // ) ) );
        
        // $scripts = apply_filters( 'cn_refuse_code_scripts_html', html_entity_decode( trim( wp_kses( $this->options['general']['refuse_code'], $allowed_html ) ) ) );
        $scripts = ''; // 'place_for_scripts';
        
        if ($this->cookies_accepted() && ! empty($scripts)) {
            echo $scripts;
        }
    }

    /**
     * Checks if cookie is setted
     *
     * @return bool
     */
    public function cookies_set()
    {
        return apply_filters('cn_is_cookie_set', isset($_COOKIE[self::$cookie['name']]));
    }

    /**
     * Checks if third party non functional cookies are accepted
     *
     * @return bool
     */
    public static function cookies_accepted()
    {
        return apply_filters('cn_is_cookie_accepted', isset($_COOKIE[self::$cookie['name']]) && strtoupper($_COOKIE[self::$cookie['name']]) === self::$cookie['value']);
    }

    public function cookieNotice()
    {
        if (SPDSGVOSettings::get('display_cookie_notice') === '1') :
        if (hasUserGivenPermissionFor('cookies') === FALSE) :
        ?>
        
         <?php if (SPDSGVOSettings::get('cn_use_overlay') === '1') : ?>
         	<div id="cookie-notice-blocker"></div>
         <?php endif; ?>	
         
<div id="cookie-notice" role="banner"
            	class="cn-<?= SPDSGVOSettings::get('cn_position') ?> <?= SPDSGVOSettings::get('cn_custom_css_container') !== '' ? SPDSGVOSettings::get('cn_custom_css_container'):'' ?>"
            	style="background-color: <?= SPDSGVOSettings::get('cn_background_color') ?> !important; 
            	       color: <?= SPDSGVOSettings::get('cn_text_color') ?> !important;
            	       height: <?= SPDSGVOSettings::get('cn_height_container') ?> !important;">
	<div class="cookie-notice-container">
            	
            	<?php if (SPDSGVOSettings::get('cn_show_dsgvo_icon') === '1') : ?>
            		<span id="cn-notice-icon"><a
			href="https://wp-dsgvo.eu" target="_blank"><img id="cn-notice-icon"
				src="<?= plugin_dir_url(__FILE__) . 'images/cookie-icon.png' ?>"
				alt="DSGVO Logo" style="display:block !important;" /></a></span>            	
            	<?php endif; ?>	
            	
            	<span id="cn-notice-text" class="<?= SPDSGVOSettings::get('cn_custom_css_text') !== '' ? SPDSGVOSettings::get('cn_custom_css_text'):'' ?>"
            		style="font-size:<?= SPDSGVOSettings::get('cn_size_text') ?>;"
            	><?= convDeChars(SPDSGVOSettings::get('cookie_notice_custom_text')) ?></span>
				
				<a href="#" id="cn-accept-cookie" data-cookie-set="accept"
					class="cn-set-cookie button wp-default <?= SPDSGVOSettings::get('cn_custom_css_buttons') !== '' ? SPDSGVOSettings::get('cn_custom_css_buttons'):'' ?>"
					style="background-color: <?= SPDSGVOSettings::get('cn_background_color_button') ?>; 
            	       color: <?= SPDSGVOSettings::get('cn_text_color_button') ?>"
					><?= SPDSGVOSettings::get('cn_button_text_ok') ?></a>
            				      
	      <?php if(SPDSGVOSettings::get('cn_activate_cancel_btn') != '0'): ?>
				<a href="#" id="cn-refuse-cookie"
					data-cookie-set="refuse" class="cn-set-cookie button wp-default <?= SPDSGVOSettings::get('cn_custom_css_buttons') !== '' ? SPDSGVOSettings::get('cn_custom_css_buttons'):'' ?>"
					style="background-color: <?= SPDSGVOSettings::get('cn_background_color_button') ?>; 
            	       color: <?= SPDSGVOSettings::get('cn_text_color_button') ?>;"
					><?= SPDSGVOSettings::get('cn_button_text_cancel') ?></a>
		  <?php endif; ?>
            					  
		  <?php if(SPDSGVOSettings::get('cn_activate_more_btn') != '0'): ?>
				<a
        			href="<?= get_permalink(SPDSGVOSettings::get('cn_read_more_page')) ?>"
        			id="cn-more-info"
        			target="<?= SPDSGVOSettings::get('cn_decline_target_url') ?>"
        			class="cn-more-info button wp-default <?= SPDSGVOSettings::get('cn_custom_css_buttons') !== '' ? SPDSGVOSettings::get('cn_custom_css_buttons'):'' ?>"
        			style="background-color: <?= SPDSGVOSettings::get('cn_background_color_button') ?>; 
            	       color: <?= SPDSGVOSettings::get('cn_text_color_button') ?>;"
        			><?= SPDSGVOSettings::get('cn_button_text_more') ?></a>
		  <?php endif; ?>
            				      				       
            	 </div>
</div>


<?php
			endif;
		endif;
            
        
    }

    public function writeHeaderScripts()
    {
        //error_log('cn_tracker_init: '. SPDSGVOSettings::get('cn_tracker_init'));
        if (SPDSGVOSettings::get('cn_tracker_init') === 'on_load') {
            //error_log('google-analytics: '. hasUserGivenPermissionFor('google-analytics'));
            //error_log('google-analytics permission: '. hasUserGivenPermissionFor('google-analytics') ? 'true': 'false');
            if (hasUserGivenPermissionFor('google-analytics')) {
                $this->writeGoogleAnalyticsOptOut();
                $this->writeGoogleAnalytics();
            }
            
            if (hasUserGivenPermissionFor('facebook-pixel')) {
                $this->writeFbPixelCode();
            }
            
        } else if (SPDSGVOSettings::get('cn_tracker_init') === 'after_confirm' 
            && ($this->cookies_accepted() || hasUserGivenPermissionFor('cookies'))) {
                
                if (hasUserGivenPermissionFor('google-analytics')) {
                    $this->writeGoogleAnalyticsOptOut();
                    $this->writeGoogleAnalytics();
                }
                
                if (hasUserGivenPermissionFor('facebook-pixel')) {
                    $this->writeFbPixelCode();
                }
        }
    }

    public function writeGoogleAnalytics()
    {
        if (SPDSGVOSettings::get('ga_enable_analytics') === '1') :
            ?>

            <!-- Google Analytics -->
            <script>
                        window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
                        ga('create', '<?= SPDSGVOSettings::get('ga_tag_number') ?>', 'auto');
                        ga('set', 'anonymizeIp', true);
                        ga('send', 'pageview');
                        </script>
            <script async src='https://www.google-analytics.com/analytics.js'></script>
            <!-- End Google Analytics -->

<?php
		endif;
        
    }

    public function writeGoogleAnalyticsOptOut()
    {
        // google analytics
        //if (SPDSGVOSettings::get('ga_enable_analytics') === '1') :
            if ($this->cookies_accepted()) :
                ?>

			<script>
			    // cookie accepted, enable analtics
            	window['ga-disable-<?= SPDSGVOSettings::get('ga_tag_number') ?>'] = false;
            </script>

<?php
            else :
                ?>
                <script>
                // cookie dismissed, disable analtics
            	window['ga-disable-<?= SPDSGVOSettings::get('ga_tag_number') ?>'] = true;
            </script>
<?php
            endif;
		//endif;
        
    }

    public function writeFbPixelCode()
    {
        if (SPDSGVOSettings::get('fb_enable_pixel') === '1') :
            ?>

<!-- Facebook Pixel Code -->
<script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '<?= SPDSGVOSettings::get('fb_pixel_number') ?>');
          fbq('track', 'PageView');
        </script>
<noscript>
	<img height="1" width="1" style="display: none"
		src="https://www.facebook.com/tr?id=<?= SPDSGVOSettings::get('fb_pixel_number') ?>&ev=PageView&noscript=1" />
</noscript>
<!-- End Facebook Pixel Code -->

<?php 
        endif;
        
    }

    public function writeFooterScripts()
    {
        $this->cookieNotice();
    }

    public function addCommentsCheckBoxForDSGVO()
    {
        if (SPDSGVOSettings::get('sp_dsgvo_comments_checkbox') === '0') {} else {
            
            $validLicence = isLicenceValid();
            $infoText = $validLicence ? htmlentities(SPDSGVOSettings::get('spdsgvo_comments_checkbox_info'), ENT_IGNORE, 'UTF-8') : htmlentities(SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_info'), ENT_IGNORE, 'UTF-8');
            $checkboxText = $validLicence ? htmlentities(SPDSGVOSettings::get('spdsgvo_comments_checkbox_text'), ENT_IGNORE, 'UTF-8') : htmlentities(SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_text'), ENT_IGNORE, 'UTF-8');
            $confirmText = $validLicence ? htmlentities(SPDSGVOSettings::get('spdsgvo_comments_checkbox_confirm'), ENT_IGNORE, 'UTF-8') : htmlentities(SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_confirm'), ENT_IGNORE, 'UTF-8');
            
            $privacy_policy_string = '';
            
            $privacy_policy_string .= '<p class="gdpr-cb-info-text"><small>* '.convDeChars($infoText).'</small></p>';
            
            $privacy_policy_string .= '<div class="info-text"></div><label for="gdpr-cb">'.convDeChars($checkboxText).'</label>';
            
            $privacy_policy_string .= '<p class="comment-form-gdpr"><input required="required" id="gdpr-cb" name="gdpr-cb" type="checkbox"  />';
            $privacy_policy_string .= convDeChars($confirmText);
            $privacy_policy_string .= '</p>';
            
            echo $privacy_policy_string;
        }
    }

    public function loadSpecificPlugins($plugins)
    {
        error_log('loadSpecificPlugins: '.$_SERVER['REQUEST_URI']);
        if (strpos(strtolower($_SERVER['REQUEST_URI']),'wp-admin') === FALSE) {
            error_log('loadSpecificPlugins');
            foreach(SPDSGVOSettings::get('services') as $slug => $service) {
    
                if ($slug === 'cookies') continue;
                if ($slug === 'google-analytics') continue;
                if ($slug === 'facebook-pixel') continue;
                
                if (! hasUserGivenPermissionFor($slug) ) {
                    $key = array_search( $slug, $plugins );
                    error_log('disabling plugin '.$slug);
                    //unset( $plugins[ $key ] );
                } else
                {
                    error_log('active plugin '.$slug);
                }
               
            }
        } else 
        {
            error_log('loadSpecificPlugins in admin');
        }
        
        return $plugins;
    }
    
    public function newUserRegistered($userID)
    {
        update_user_meta($userID, 'SPDSGVO_settings', json_encode('{}'));
    }

    public function allowJSON($mime_types)
    {
        $mime_types['json'] = 'application/json';
        return $mime_types;
    }

    public function autoDeleteUnsubscribers()
    {
        if (SPDSGVOSettings::get('auto_delete_erasure_requests') === '1') {
            if (SPDSGVOSettings::get('last_auto_delete_cron') !== date('z')) {
                foreach (SPDSGVOUnsubscriber::all() as $unsubscriber) {
                    if ($unsubscriber->delete_on < time()) {
                        $unsubscriber->unsubscribe();
                    }
                }
                SPDSGVOSettings::set('last_auto_delete_cron', date('z'));
            }
        }
    }

    public function forcePermisson()
    {
        $page = SPDSGVOSettings::get('explicit_permission_page');
        
        if (hasUserDeclinedTerms()) {
            return;
        }
        
        if ($page == '0') {
            return;
        }
        
        if (get_post($page) instanceof WP_Post) {
            return;
        }
        
        if (strpos(get_post($page)->post_content, 'explicit_permission_form') === FALSE) {
            return;
        }
        
        if (SPDSGVOSettings::get('force_explicit_permission_authenticated') == '1' && is_user_logged_in()) {
            
            if (! SPDSGVO::isAjax() && ! hasUserAgreedToTerms()) {
                if (get_the_ID() != $page) {
                    $url = get_permalink($page);
                    if (! is_admin()) {
                        wp_redirect($url);
                        exit();
                    }
                }
            }
        } elseif (SPDSGVOSettings::get('force_explicit_permission_public') == '1' && ! is_user_logged_in()) {
            
            if (! SPDSGVO::isAjax() && ! hasUserAgreedToTerms()) {
                if (get_the_ID() != $page) {
                    $url = get_permalink($page);
                    if (! is_admin()) {
                        wp_redirect($url);
                        exit();
                    }
                }
            }
        }
    }
}

/**
 * Get the cookie notice status
 *
 * @return boolean
 */
function sp_dsgvo_cn_cookies_accepted()
{
    return (bool) SPDSGVOPublic::cookies_accepted();
}
