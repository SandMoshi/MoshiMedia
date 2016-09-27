<?php
 ini_set('display_errors', 'On');
 error_reporting(E_ALL);

  	header('Content-type: application/json');

			// WE SHOULD ASSUME THAT THE EMAIL WAS NOT SENT AT FIRST UNTIL WE KNOW MORE.
			// WE ALSO ADD AN ATTACHMENT KEY TO OUR STATUS ARRAY TO INDICATE THE STATUS OF OUR ATTACHMENT:  
			$status = array(
							'type'          =>'Error',
							'message'       =>'Couldn\'t send the Email at this Time. Something went wrong',
//							'attachement'   =>'Couldn\'t attach the uploaded File to the Email.'
			);
   
    //Added to deal with Files
    require_once('PHPMailer/class.phpmailer.php');
    
 /*   if(!empty($_FILES['uploaded_file']['name'])){
		//if(isset($_FILES['uploaded_file'])){	
		//Get the uploaded file information
		$name_of_uploaded_file = "NoFilename";
		$name_of_uploaded_file =
			basename($_FILES['uploaded_file']['name']);
		 
		//get the file extension of the file
		$type_of_uploaded_file =
			substr($name_of_uploaded_file,
			strrpos($name_of_uploaded_file, '.') + 1);
		 
		$size_of_uploaded_file =
			$_FILES["uploaded_file"]["size"]/1024;//size in KBs

		//Settings
		$max_allowed_file_size = 10000; // size in KB
		$allowed_extensions = array("jpg", "jpeg", "gif", "bmp","png");
		 
		//Validations
		if($size_of_uploaded_file > $max_allowed_file_size )
		{
		  $status['type'] 	 = 'Error';
    	$status['message'] = 'Error: Size of file should be less than ~10MB. The file you attempted to upload is too large. To reduce the size, open the file in an image editor and change the Image Size and resave the file.';
		  echo(json_encode($status));
		  exit;
		}
		 
		//------ Validate the file extension -----
		$allowed_ext = false;
		for($i=0; $i<sizeof($allowed_extensions); $i++)
		{
		  if(strcasecmp($allowed_extensions[$i],$type_of_uploaded_file) == 0)
		  {
				$allowed_ext = true;
		  }
		}
		 
		if(!$allowed_ext)
		{
		  $status['type'] 	 = 'Error';
    	$status['message'] = 'Error: The uploaded file is not a supported file type.';
		  echo(json_encode($status));
		 	exit;
		}
		
		//copy the temp. uploaded file to uploads folder - make sure the folder exists on the server and has 777 as its permission
  $upload_folder = "temp/";
		$path_of_uploaded_file = $upload_folder . $name_of_uploaded_file;
		$tmp_path = $_FILES["uploaded_file"]["tmp_name"];
		 
		if(is_uploaded_file($tmp_path))
		{
		  if(!copy($tmp_path,$path_of_uploaded_file))
		  {
			  $status['type'] 	 = 'Error';
    		$status['message'] 	 = 'Error: Encountered an error while copying the uploaded file';
		  	exit;
		  }
		}
}*/
    //--end

    $name = @trim(stripslashes($_POST['name'])); 
    $clientemail = @trim(stripslashes($_POST['email'])); 
   	$phone = @trim(stripslashes($_POST['phone']));
    $subject = 'none';
   	$message = @trim(stripslashes($_POST['message']));

    $body = 'Name: ' . $name . "\n\n" . 'Email: ' . $clientemail . "\n\n" . 'Phone: ' . $phone . "\n\n" . 'Message: ' . $message;

	 $email = new PHPMailer();		

 	$email->From      = $clientemail;
 	$email->FromName  = $name;
 	$email->Subject   = 'Message from Website User';//$subject;
	$email->Body      = $body;  
	$email->AddAddress( 'moshimedia@gmail.com' ); //Send to this email

 // EXPLICITLY TELL PHP-MAILER HOW TO SEND THE EMAIL... IN THIS CASE USING PHP BUILT IT MAIL FUNCTION    
		$email->isMail();

 // THE AddAttachment METHOD RETURNS A BOOLEAN FLAG: TRUE WHEN ATTACHMENT WAS SUCCESSFUL & FALSE OTHERWISE:
 // KNOWING THIS, WE MAY JUST USE IT WITHIN A CONDITIONAL BLOCK SUCH THAT 
 // WHEN IT IS TRUE, WE UPDATE OUR STATUS ARRAY...   
/*  if(!empty($_FILES['uploaded_file']['name'])){	 
				if($email->AddAttachment( $path_of_uploaded_file , $name_of_uploaded_file )){
					  $status['type']    = 'success';
            $status['message']   = 'The Uploaded File was successfully attached to the Email.';  
        }
  }*/
 		header("Content-Type: application/json; charset=utf-8", true);
 // NOW, TRY TO SEND THE EMAIL ANYWAY:
        try{
            $success    = $email->send();
            $status['type']    = 'success';
            $status['message']  = 'Thank you for contacting us. We will reply as soon as possible.';   
        }catch(Exception $e){
            $status['type']     ='Error';
            $status['message']  ='Couldn\'t send the Email at this Time. Something went wrong';     
        }   
  
		// SIMPLY, RETURN THE JSON DATA...
 die(json_encode($status));