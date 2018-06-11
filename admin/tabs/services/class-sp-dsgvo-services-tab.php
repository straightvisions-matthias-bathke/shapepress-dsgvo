<?php

class SPDSGVOServicesTab extends SPDSGVOAdminTab{
    
    public $title = 'Datenschutz & Plugins';
    public $slug = 'services';

    public function __construct(){}
    
    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}   