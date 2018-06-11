<?php

Class SPDSGVOSubjectAccessRequestAction extends SPDSGVOAjaxAction{

    protected $action = 'subject-access-request';

    public function run(){
        if(!$this->has('email') || empty($this->get('email'))){
            $this->error('Bitte eine Email Adresse angeben.');
        }
        
        if(!$this->has('dsgvo_checkbox') || $this->get('dsgvo_checkbox') !== '1'){
            $this->error('Die DSGVO Zustimmung ist zwingend.');
        }

        $sar = SPDSGVOSubjectAccessRequest::insert(array(
            'first_name' => $this->get('first_name'),
            'last_name'  => $this->get('last_name'),
            'email'      => $this->get('email'),
            'dsgvo_accepted' => $this->get('dsgvo_checkbox')
        ));


        if($this->has('process_now')){
            $displayEmail = ($this->get('display_email', '0') == '1');
            $sar->doSubjectAccessRequest($displayEmail);
        }

        if($this->has('is_admin')){
            $this->returnBack();
        }

        if($this->has('is_ajax')){
            echo json_encode(array(
                'success'   => '1',
                'zip_link'  => SPDSGVODownloadSubjectAccessRequestAction::url(array(
                    'token'     => $sar->token,
                    'file'      => 'zip',
                )),
                'pdf_link'  => SPDSGVODownloadSubjectAccessRequestAction::url(array(
                    'token'     => $sar->token,
                    'file'      => 'pdf',
                )),
            ));
        }

        $SARPage = SPDSGVOSettings::get('sar_page');
        if($SARPage !== '0'){
            $url = get_permalink($SARPage);
            $this->returnRedirect($url, array(
                'result' => 'success',
            ));
        }

        $this->returnBack();
    }
}

SPDSGVOSubjectAccessRequestAction::listen();
