<?php

class SPDSGVOCf7Integration extends SPDSGVOIntegration
{
    
    public $slug = 'cf7';
    
    public $title = 'ContactForm7';
    
    public function boot()
    {
        $this->isHidden = TRUE;
    }
    
    public function view()
    {
        include dirname(__FILE__) . '/page.php';
    }
    
    public function viewSubmit()
    {
        $this->redirectBack();
    }
    
    // -----------------------------------------------------
    // Actions
    // -----------------------------------------------------
    public function onSuperUnsubscribe($email, $firstName = NULL, $lastName = NULL, $user = NULL)
    {
        if (! class_exists('WPCF7_ContactForm')) {
            // error_log('WPCF7_ContactForm not active');
            return;
        }
        
        $cf7Action = SPDSGVOSettings::get('su_cf7_data_action');
        
        if ($cf7Action == 'ignore') return; 
        
        $args = array(
            'title' => $email,
            'post_type' => 'flamingo_contact'
        );
        
        $contacts = get_posts($args);
        
        // search contact
        $args = array(
            'post_type' => 'flamingo_inbound'
        );
        $allInbounds = get_posts($args);
        
        $inbounds = array();
        foreach ($allInbounds as $post) {
            
            if (strpos($post->post_content, $email) !== false)
            {
                $inbounds[] = $post;
            }
        }
        
        $userPosts = array();
        $userPosts = array_merge($contacts, $inbounds);
        
        if ($userPosts) {
            foreach ($userPosts as $post) {
                //error_log('bbpAction: '.$bbpAction .'foreach ($userPosts: '.$post->ID);
                if ($cf7Action == 'del')
                {
                    wp_delete_post( $post->ID, FALSE );
                } elseif ($cf7Action == 'pseudo') {
                    
                    $post->post_content = "Gel$ouml;schter Inhalt.";
                    $post->post_title = "Gel$ouml;schter Inhalt.";
                    $post->post_name = "Gel$ouml;schter Inhalt.";
                    wp_update_post($post);
                }
            }
        }
        
    }
    
    public function onSubjectAccessRequest($email, $firstName = NULL, $lastName = NULL, $user = NULL)
    {
        if (! class_exists('WPCF7_ContactForm')) {
            // error_log('WPCF7_ContactForm not active');
            return;
        }
        
//         if ($user == NULL) {
//             $user = get_user_by('email', $email);
//         }
        
//         if ($user == NULL || ! is_a($user, 'WP_User')) {
//             // error_log('user null or not a wp_user');
//             return;
//         }
        
        $data = array();
        
        // search contacts
        //error_log(' search contacts with email '.$email);
        $args = array(
            'title' => $email,
            'post_type' => 'flamingo_contact'
        );
        
        $contacts = get_posts($args);
        
        // search contact
        $args = array(
            'post_type' => 'flamingo_inbound'
        );
        $allInbounds = get_posts($args);
        
        $inbounds = array();
        foreach ($allInbounds as $post) {
            
            if (strpos($post->post_content, $email) !== false)
            {
                $inbounds[] = $post;
            }
        }
        
        $userPosts = array();
        $userPosts = array_merge($contacts, $inbounds);
        
        if ($userPosts) {
            foreach ($userPosts as $post) {
                if ($post->post_type == 'flamingo_contact') {
                    $data[] = "Kontakteintrag '" . $post->post_title . "'" . ' am '. date("d.m.Y H:i", strtotime($post->post_date));
                } elseif ($post->post_type == 'flamingo_inbound') {
                    $data[] = "Nachricht '" . $post->post_title . "'". ' am '. date("d.m.Y H:i", strtotime($post->post_date));
                    $data[] = '<i>' . $post->post_content . '</i>';
                } 
            }
        }
        
        return $data;
    }
}

SPDSGVOCf7Integration::register();