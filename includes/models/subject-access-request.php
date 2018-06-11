<?php

Class SPDSGVOSubjectAccessRequest extends SPDSGVOModel {

	public $postType = 'subjectaccessrequest';
	public $dataCollecter;
	public $collectedData;
	public $attributes = array(
		'first_name',
		'last_name',
		'email',
	    'dsgvo_accepted',

		'token',
		'status',
		'pdf_path',
		'json_path',
	);
	public $default = array(
		'status' => 'pending'
	);


	//======================================================================
	// doSubjectAccessRequest()
	//======================================================================
	public function doSubjectAccessRequest($displayEmail = FALSE){
		$this->status = 'in-progress';
		$this->save();


		// SAR
		$dataCollecter = new SPDSGVODataCollecter($this->email, $this->first_name, $this->last_name);
        $dataCollecter->sar();
        $this->collectedData = $dataCollecter->getDataByType();
		$this->buildPDF();
		$this->buildJSON();


		// WP_Mail - loop refactor?
		$breakdown = '';
		$i = 0;
		foreach($this->collectedData as $type => $rows){
			$breakdown .= sprintf('<p><strong>%s</strong></p>', ucwords(str_replace('_', ' ', $type)));

			$breakdown .= '<p style="padding-left:20px;">';

			$data = array();
			foreach($rows as $key => $row){
				if($key < 3){
					array_push($data, $row->data);
				}
			}
			$breakdown .= implode(', ', $data);
			$breakdown .= '</p>';
			
			$i++;
			if($i > 5){
				break;
			}
		}
		


		// Send Email
		$email = SPDSGVOMail::init()
		    ->from(SPDSGVOSettings::get('admin_email'))
		    ->to($this->email)
		    ->subject('Anfrage zum Datenauszug: '. parse_url(home_url(), PHP_URL_HOST))
		    ->beforeTemplate(SPDSGVO::pluginDir('includes/emails/header.html'))
		    ->afterTemplate( SPDSGVO::pluginDir('includes/emails/footer.html'))
		    ->template(SPDSGVO::pluginDir('includes/emails/subject-access-request.html'), array(
                'title' 		=> 'Subject Access Request',

                'zip_link' 		=> SPDSGVODownloadSubjectAccessRequestAction::url(array(
                	'token' 	=> $this->token,
                	'file'  	=> 'zip',
                )),

				'count'			=> $dataCollecter->totalFound,
				'breakdown'		=> $breakdown,
                
                'home_url' 		=> home_url(),
		        'website' 		=> home_url(),
				'admin_email' 	=> SPDSGVOSettings::get('admin_email'),
            ));


		try{
			$email->attach(array(
				$this->pdf_path,
			));
		}catch(Exception $e){
			
		}


		$email->send();
		$this->status = 'done';
		$this->save();

		if($displayEmail){
			echo $email->render();
			die;
		}
	}

	public static function doByID($ID, $displayEmail = FALSE){
		$sar = SPDSGVOSubjectAccessRequest::find($ID);
        if(!is_null($sar)){
            $sar->doSubjectAccessRequest($displayEmail);
            return TRUE;
        }

        return FALSE;
	}


	//======================================================================
	// Finders
	//======================================================================
	public function _finderToken($args){
		 return array(
            'meta_query' => array(
                array(
                    'key'	=> 'token',
                    'value' => $args['token']
               	)
            )
        );
	}

	public function _postFinderToken($results, $args){
		return @$results[0]; 
	}

	public function _finderPending($args){
		 return array(
            'meta_query' => array(
                array(
                    'key'	=> 'status',
                    'value' => 'pending'
               	)
            )
        );
	}


	//======================================================================
	// Hooks
	//======================================================================
	public function inserting(){
		$this->token = self::randomString();
	}


	//======================================================================
	// Misc
	//======================================================================
	public function name(){
		return $this->first_name .' '. $this->last_name; 
	}

	public function filename($extension){
		return preg_replace('/\s+/', '', sprintf('SAR-%s-%s-%s.%s', ucfirst($this->first_name), ucfirst($this->last_name), $this->ID, $extension));
	}

	public static function randomString($len = 20){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for($i = 0; $i < $len; $i++){
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

    public function buildPDF(){
        $pdf = new SPDSGVOPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Alle Daten zu '.   $this->name());
        $pdf->SetSubject('Alle Daten zu '. $this->name());

        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, "Alle Daten zu {$this->name()}", sprintf("Datum: %s \nQuelle: %s", date('j. F Y, G:i:s'), home_url()));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
       
        $pdf->SetFont('helvetica', '', 12);
        $pdf->AddPage();
        $pdf->coloredTable($this->collectedData);
        
        $fileName = $this->filename('pdf');
        $upload = wp_upload_bits($fileName, NULL, $pdf->Output($path, 'S'));
        $this->pdf_path = $upload['file'];
        $this->save();
    }

    public function buildJSON(){
        $json = json_encode($this->collectedData);
        $fileName = 'SAR-'.self::randomString().'.json';
        $upload = wp_upload_bits($fileName, NULL, $json);
        $this->json_path = $upload['file'];
        $this->save();
    }
}


SPDSGVOSubjectAccessRequest::register(array(
	'show_in_nav_menus'   => FALSE,
	'show_in_menu' 		  => FALSE,
	'show_ui' 			  => FALSE,
	'publicly_queryable'  => FALSE,
	'exclude_from_search' => FALSE,
	'public' 			  => FALSE,
));