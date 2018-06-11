<?php

class SPDSGVOSubjectAccessRequestTab extends SPDSGVOAdminTab{
	
	public $title = 'Datenauszug';
	public $slug = 'subject-access-request';

	public function __construct(){}

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}	