<?php

class SPDSGVOIntegrationsTab extends SPDSGVOAdminTab{
	
	public $title = 'Integrations';
	public $slug = 'integrations';
    public $isHidden = true;

	public function __construct(){}

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}	