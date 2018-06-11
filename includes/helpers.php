<?php

if(!function_exists('hasUserAgreedToTerms')){

	function hasUserAgreedToTerms($user = NULL){
		if(is_null($user)){
			$user = wp_get_current_user();
		}elseif(!$user instanceof WP_User){
			$user = get_user_by('ID', $user);
		}

		if(!$user instanceof WP_User){
			if(!isset($_COOKIE['sp_dsgvo_explicit_permission_given'])){
				return FALSE;	
			}

			return wp_hash(SPDSGVOSettings::get('terms_conditions')) === @$_COOKIE['sp_dsgvo_explicit_permission_given'];
		}
		
		return get_user_meta($user->ID, 'sp_dsgvo_explicit_permission_granted', TRUE) === '1';
	}

}


if(!function_exists('hasUserDeclinedTerms')){

	function hasUserDeclinedTerms(){
		$user = wp_get_current_user();
		if($user instanceof WP_User && $user->ID){
			return (get_user_meta($user->ID, 'sp_dsgvo_explicit_permission_declined', TRUE) === '1');
		}else{
			return (@$_COOKIE['sp_dsgvo_explicit_permission_declined'] === '1');
		}
	}

}


if(!function_exists('sp_dsgvo_CSRF_TOKEN')){

	function sp_dsgvo_CSRF_TOKEN(){
		$user = wp_get_current_user();

		if($user instanceof WP_User && $user->ID){
			return get_user_meta($user->ID, 'sp_dsgvo_CSRF_token', TRUE);
		}
	}

}

if(!function_exists('pageContainsString')){

	function pageContainsString($pageID, $string){
		if(get_post_status($pageID) === FALSE){
			return FALSE;
		}

		return (strpos(get_post($pageID)->post_content, $string) !== FALSE);
	}

}


if(!function_exists('hasUserGivenPermissionFor')){

	function hasUserGivenPermissionFor($slug){
		$user = wp_get_current_user();

		if($slug === 'cookies'){
		    $cnAccepted = sp_dsgvo_cn_cookies_accepted();
		    
			if($user instanceof WP_User && $user->ID){
				$userPermissions = get_user_meta($user->ID, 'sp_dsgvo_user_permissions', TRUE);
			}else{
				$userPermissions = @$_COOKIE['sp_dsgvo_user_permissions'];
				$userPermissions = unserialize(stripslashes($userPermissions));
			}

			if(isset($userPermissions['cookies'])){
			    return $userPermissions['cookies'] == '1'|| $cnAccepted;
			}
			//error_log('hasUserGivenPermissionFor: '.$slug .': '. 'NULL');
			return $cnAccepted; // at last its false -> opt-in
		}

		
		if($user instanceof WP_User && $user->ID){
			
			$userPermissions = get_user_meta($user->ID, 'sp_dsgvo_user_permissions', TRUE);

		}else{

			$userPermissions = @$_COOKIE['sp_dsgvo_user_permissions'];

			$userPermissions = unserialize(stripslashes($userPermissions));
		}

		if(isset($userPermissions[$slug])){
		    //error_log('hasUserGivenPermissionFor: '.$slug .': '. $userPermissions[$slug] == '1');
			return $userPermissions[$slug] == '1';
		}else{
			$defaults = SPDSGVOSettings::get('services');

			if(isset($defaults[$slug])){
			    error_log('hasUserGivenPermissionFor: '.$slug .': '. @$defaults[$slug]['default'] === '1');
				return @$defaults[$slug]['default'] === '1';
			}

			//error_log('hasUserGivenPermissionFor: '.$slug .': '. 'FALSE');
			return FALSE;
		}
	}

}

if(!function_exists('isPremium')){
    function isPremium(){
        return FALSE;
    }
}

if(!function_exists('isFree')){
    function isFree(){
        return TRUE;
    }
}

if(!function_exists('isLicenceValid')){
    function isLicenceValid(){
        return SPDSGVOSettings::get('dsgvo_licence') !== '' 
            //&& SPDSGVOSettings::get('license_key_error') === '0'
            && SPDSGVOSettings::get('license_activated') === '1'
                && isFree();
    }
}

if(!function_exists('enablePremiumFeatures')){
    function enablePremiumFeatures(){
        //error_log('enablePremiumFeatures: '. isPremium() && isLicenceValid() ? 'true' : 'false');
        return isPremium() && isLicenceValid();
    }
}

if(!function_exists('enableLightFeatures')){
    function enableLightFeatures(){
        return isFree() && isLicenceValid();
    }
}


if(!function_exists('createLog')){
	function createLog($content){
		return SPDSGVOLog::insert($content);
	}
}


if(!function_exists('convDeChars')){
    function convDeChars($content){
        
        $content = str_replace('Ã¤', 'ä', $content);
        $content = str_replace('Ã„', 'Ä', $content);
        $content = str_replace('Ã¼', 'ü', $content);
        $content = str_replace('Ãœ', 'Ü', $content);
        $content = str_replace('Ã¶', 'ö', $content);
        $content = str_replace('Ã–', 'Ö', $content);
        $content = str_replace('ÃŸ', 'ß', $content);
        $content = str_replace('ÃŸ', 'ß', $content);
        
        $content = str_replace('ä', '&auml;', $content);
        $content = str_replace('Ä', '&Auml;', $content);
        $content = str_replace('ü', '&uuml;', $content);
        $content = str_replace('Ü', '&Uuml;', $content);
        $content = str_replace('ö', '&ouml;', $content);
        $content = str_replace('Ö', '&Ouml;', $content);
        $content = str_replace('ß', '&szlig;', $content);
        $content = str_replace('ß', '$szlig;', $content);
        
        return $content;
    }
}



