<?php class imageupload extends CI_Model{

    function imageUploadProfile($rawName,$photo_name){
        	$this->load->library('image_lib');
			$this->load->library('upload');
			// Set configuration array for uploaded photo.
			//$image_path = realpath(APPPATH . '../assets/'.$school_code.'/images/empImage');
			$asset_name = $this->db->get('upload_asset')->row()->asset_name;
		    $image_path = $asset_name.'/images/subscriber';
			$config['upload_path'] = $image_path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
			$config['max_size'] = '100000';
			$config['file_name'] = $photo_name;
			// Upload first photo and create a thumbnail of it.
		
				$this->upload->initialize($config);
			    $status=	$this->upload->do_upload($rawName);
				if ($status) {
					// ---------------------------------- Redirect Success Page ----------------------
					//$this->session->set_userdata("photo",$photo_name);
					$configer = array(
                            'image_library' => 'gd2',
                            'source_image' => $image_path."/".$photo_name,
                            'create_thumb' => FALSE,//tell the CI do not create thumbnail on image
                            'maintain_ratio' => TRUE,
                            'quality' => '40%', //tell CI to reduce the image quality and affect the image size
                            'width' => 150,//new size of image
                            'height' => 200,//new size of image
                        );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configer);
                    if($this->image_lib->resize()){
                        return "success";
                    }else{
                        return $this->image_lib->display_errors();
                    }
				//	redirect("index.php/adminController/adminProfile/true/updateInfo");
				}else{
				   return $this->upload->display_errors();
					//redirect("index.php/errorController");	
				}
			
    }
    
    function imageUploadHomeWork($rawName,$photo_name,$school_code,$tokan){
        	$this->load->library('image_lib');
			$this->load->library('upload');
			// Set configuration array for uploaded photo.
			//$image_path = realpath(APPPATH . '../assets/'.$school_code.'/images/empImage');
		  $asset_name = $this->db->get('upload_asset')->row()->asset_name;
		  if($tokan==2){
		$image_path = $asset_name.$school_code.'/images/submithomeWork';
		  }else{
		      	$image_path = $asset_name.$school_code.'/images/filehomeWork';
		  }
		$config['upload_path'] = $image_path;
		$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|docx|doc|bmp';
		$config['max_size'] = '50096';
		$config['file_name'] = $photo_name;
			// Upload first photo and create a thumbnail of it.
		
				$this->upload->initialize($config);
			    $status=	$this->upload->do_upload($rawName);
				if ($status) {
					// ---------------------------------- Redirect Success Page ----------------------
					//$this->session->set_userdata("photo",$photo_name);
					$configer = array(
                            'image_library' => 'gd2',
                            'source_image' => $image_path."/".$photo_name,
                            'create_thumb' => FALSE,//tell the CI do not create thumbnail on image
                            'maintain_ratio' => TRUE,
                            'quality' => '40%', //tell CI to reduce the image quality and affect the image size
                            'width' => 800,//new size of image
                            'height' => 1000,//new size of image
                        );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configer);
                    if($this->image_lib->resize()){
                        return "success";
                    }else{
                        return $this->image_lib->display_errors();
                    }
				//	redirect("index.php/adminController/adminProfile/true/updateInfo");
				}else{
				   return $this->upload->display_errors();
					//redirect("index.php/errorController");	
				}
    }
}