<?php

class SPDSGVOSuperUnsubscribeTab extends SPDSGVOAdminTab{
	
	public $title = 'L&ouml;schanfragen';
	public $slug = 'super-unsubscribe';

	public function __construct(){}

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}	