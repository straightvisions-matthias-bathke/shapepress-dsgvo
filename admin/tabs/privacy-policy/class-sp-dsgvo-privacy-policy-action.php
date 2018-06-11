<?php

Class SPDSGVOPrivacyPolicyAction extends SPDSGVOAjaxAction{

    protected $action = 'privacy-policy';

    protected function run(){
    	$this->requireAdmin();


        // Set privacy policy page
        if($this->has('privacy_policy_page')){
            SPDSGVOSettings::set('privacy_policy_page', $this->get('privacy_policy_page', '0'));
        }

        // Update privacy policy
    	if($this->has('privacy_policy')){
    		$version = SPDSGVOSettings::get('privacy_policy_version');
    		$version = intval($version);
    		$version++;
    		$version = SPDSGVOSettings::set('privacy_policy_version', $version);
            SPDSGVOSettings::set('privacy_policy_hash', wp_hash($this->get('privacy_policy')));
    		SPDSGVOSettings::set('privacy_policy', $this->get('privacy_policy'));
    		SPDSGVOLog::insert("Privacy policy updated by {$this->user->user_email}");
    	}

        
        $this->returnBack();
    }
}

SPDSGVOPrivacyPolicyAction::listen();
