<?php

Class SPDSGVOSuperUnsubscribeFormAction extends SPDSGVOAjaxAction{

    protected $action = 'super-unsubscribe';

    public function run(){
        if(!$this->has('email') || empty($this->get('email'))){
            $this->error('Bitte eine Email Adresse angeben.');
        }
        
        if(!$this->has('dsgvo_checkbox') || $this->get('dsgvo_checkbox') !== '1'){
            $this->error('Die DSGVO Zustimmung ist zwingend.');
        }

        $unsubscriber = SPDSGVOUnsubscriber::insert(array(
            'first_name' => $this->get('first_name'),
            'last_name'  => $this->get('last_name'),
            'email'      => $this->get('email'),
            'dsgvo_accepted' => $this->get('dsgvo_checkbox'),
            'process_now'=> $this->get('process_now')
        ));

        if($this->has('process_now')){
            $unsubscriber->doSuperUnsubscribe();
        }

        if($this->has('is_admin')){
            $this->returnBack();
        }

        $superUnsubscribePage = SPDSGVOSettings::get('super_unsubscribe_page');
        if($superUnsubscribePage !== '0'){
            $url = get_permalink($superUnsubscribePage);
            $this->returnRedirect($url, array(
                'result' => 'success',
            ));
        }

        $this->returnBack();
    }
}

SPDSGVOSuperUnsubscribeFormAction::listen();
