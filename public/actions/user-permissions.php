<?php

Class SPDSGVOUserPermissionsAction extends SPDSGVOAjaxAction{

    protected $action = 'user-permissions';

    protected function run(){

        $meta = array();
        $services = $this->get('services', NULL, FALSE);
        
        //error_log('SPDSGVOUserPermissionsAction: updating settings');
        if(is_array($services)){
            foreach($services as $slug => $service){
                $meta[$slug] = ($service == '1')? '1' : '0';
            }
        }

        if($this->user){
            update_user_meta($this->user->ID, 'sp_dsgvo_user_permissions', $meta);
            createLog("{$this->user->user_email} updated their user permissions");
        }

        setcookie('sp_dsgvo_user_permissions', serialize($meta), (time()+(365*24*60*60)), '/');

        header('Location: '. $_SERVER['HTTP_REFERER']);
        die;
    }
}

SPDSGVOUserPermissionsAction::listen();