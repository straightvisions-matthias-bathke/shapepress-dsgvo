<?php

class SPDSGVOCookieNoticeTab extends SPDSGVOAdminTab{
    
    public $title = 'Cookie Notice';
    public $slug = 'cookie-notice';
    public $isHidden = FALSE;
    
    public function __construct(){}
    
    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}   