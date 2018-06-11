<?php

class SPDSGVOCommonSettingsActivateAction extends SPDSGVOAjaxAction
{
    
    protected $action = 'admin-common-settings-activate';
    
    protected function run()
    {
        $this->requireAdmin();
        
        $oldLicenceKey = SPDSGVOSettings::get('dsgvo_licence');
        $licenceKey = $this->get('dsgvo_licence', '');
        
        if (SPDSGVOSettings::get('license_activated') === '0')
        {
            //error_log('activating licence '.$licenceKey);
            SPDSGVOSettings::set('license_activated', '0');
            SPDSGVOSettings::set('license_key_error', '1');
            
            $url = 'https://wp-dsgvo.eu/spdsgvo-bin/activate.php';
            $url .= '?license_key=' .$licenceKey;
            
            $request = wp_remote_get($url); 
            
            if( is_wp_error( $request ) ) {
                
                try {
                    error_log('error during license activation: '.$request->get_error_message()); // Bail early
                    if (strpos(strtolower($request->get_error_message()), 'curl error 35') !== false) {
                        SPDSGVOSettings::set('license_key_error', '0');
                        SPDSGVOSettings::set('license_activated', '1');
                    } else 
                    {
                        SPDSGVOSettings::set('license_activation_error', $request->get_error_message());
                    }
                } catch (Exception $e) {
                    error_log('error during license activation.');
                }
            } else {
                $result = wp_remote_retrieve_body( $request );
                if (strpos($result, 'OK') !== false) {
                    SPDSGVOSettings::set('license_key_error', '0');
                    SPDSGVOSettings::set('license_activated', '1');
                } else
                {
                    SPDSGVOSettings::set('license_activation_error', $result);
                    SPDSGVOSettings::set('license_key_error', '1');
                }
                
            }
        } elseif(SPDSGVOSettings::get('license_activated') === '1')
        {
            $url = 'https://wp-dsgvo.eu/spdsgvo-bin/deactivate.php';
            $url .= '?license_key=' .$licenceKey;
            
            $request = wp_remote_get($url);
            
            if( is_wp_error( $request ) ) {
                
                try {
                    error_log('error during license activation: '.$request->get_error_message()); // Bail early
                } catch (Exception $e) {
                    error_log('error during license activation.');
                }
            } else {
                $result = wp_remote_retrieve_body( $request );
                if (strpos($result, 'OK') !== false) {
                    SPDSGVOSettings::set('license_key_error', '1');
                    SPDSGVOSettings::set('license_activated', '0');
                } else
                {
    
                }
            }
        }        
        
        SPDSGVOSettings::set('dsgvo_licence', $licenceKey);
        
        $this->returnBack();
    }
}

SPDSGVOCommonSettingsActivateAction::listen();


