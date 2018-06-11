<?php

class SPDSGVOCommonSettingsTab extends SPDSGVOAdminTab{
    
    public $title = 'Allgemeine Einstellungen';
    public $slug = 'common-settings';
    public $isHidden = FALSE;
    
    public function __construct(){}
    
    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}   