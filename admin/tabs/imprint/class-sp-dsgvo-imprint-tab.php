<?php

class SPDSGVOImprintTab extends SPDSGVOAdminTab{
	
	public $title = 'Impressum';
	public $slug  = 'imprint';
    public $isHidden = TRUE;

	public function __construct(){}
	
    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}	