<?php

class SPDSGVOPrivacyPolicyTab extends SPDSGVOAdminTab{
	
	public $title = 'Privacy Policy';
	public $slug  = 'privacy-policy';
    public $isHidden = TRUE;

	public function __construct(){}

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}	