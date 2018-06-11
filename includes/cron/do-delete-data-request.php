<?php

Class DoDSGVODeleteDataRequest extends SPDSGVOCron{

    public $interval = array(
        'days'     => 1,
    );
    
    public function handle(){
        $delCron = SPDSGVOSettings::get('su_auto_del_time');
        if($delCron !== '0'){
    	    
            $daysAgo = strtotime('-'.$delCron.' day');
            
            error_log('DoDSGVODeleteDataRequest with days: '.$delCron . ' and intval: '.$daysAgo);
            
            foreach(SPDSGVOUnsubscriber::finder('pending') as $sar){
	           
	            $post = $sar->_post;//  get_post($sar->ID);
	            error_log('doing sar '. $sar->ID . ' with intval '. intval(strtotime($post->post_date)));
	            
	            if (intval(strtotime($post->post_date)) <= intval($daysAgo)) 
	            {
	                $sar->doSuperUnsubscribe();
	            } else 
	            {
	                error_log('sar '. $sar->ID . ' has not the date to process');
	            }
	        }
	    }
    }
}

DoDSGVODeleteDataRequest::register();