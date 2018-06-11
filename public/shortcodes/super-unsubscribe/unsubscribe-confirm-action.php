<?php

Class SPDSGVOSuperUnsubscribeConfirmAction extends SPDSGVOAjaxAction{

    protected $action = 'super-unsubscribe-confirm';

    public function run(){
        
        if(!$this->has('token')){
            $this->error('No token provided.');
        }

        $unsubscriber = SPDSGVOUnsubscriber::finder('token', array(
            'token' => $this->get('token')
        ));

        if(is_null($unsubscriber)){
            $this->error('Bad token provided.');
        }

        if(SPDSGVOSettings::get('unsubscribe_auto_delete') == '1'){
            $unsubscriber->doSuperUnsubscribe();
        }else{
            $unsubscriber->status = 'confirmed';
            $unsubscriber->save();
        }

        $superUnsubscribePage = SPDSGVOSettings::get('super_unsubscribe_page');
        if($superUnsubscribePage !== '0'){
            $url = get_permalink($superUnsubscribePage);
            $this->returnRedirect($url, array(
                'result' => 'confirmed',
            ));
        }
        
    }
}

SPDSGVOSuperUnsubscribeConfirmAction::listen();
