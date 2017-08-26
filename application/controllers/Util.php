<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Util extends MY_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function upload()
	{
		if (!$this->ion_auth->logged_in())
		{
			 echo "Chưa đăng nhập";
			 return;
		}
		// Step 2: Put here the full absolute path of the folder where you want to save the files:
		$basePath = FCPATH."assets/upload/";

		// Step 3: Put here the Url that should be used for the upload folder (it the URL to access the folder that you have set in $basePath
		// you can use a relative url "/images/", or a path including the host "http://example.com/images/"
		$baseUrl = base_url("assets/upload/");

		// Optional: instance name (might be used to adjust the server folders for example)
		$CKEditor = $_GET['CKEditor'] ;

		// Required: Function number as indicated by CKEditor.
		$funcNum = $_GET['CKEditorFuncNum'] ;

		// Optional: To provide localized messages
		$langCode = $_GET['langCode'] ;

		// The returned url of the uploaded file
		$url = '' ;

		// Optional message to show to the user (file renamed, invalid file, not authenticated...)
		$message = '';

		// in CKEditor the file is sent as 'upload'
		if (isset($_FILES['upload'])) {
		    // Be careful about all the data that it's sent!!!
		    // Check that the user is authenticated, that the file isn't too big,
		    // that it matches the kind of allowed resources...
		    $name = $_FILES['upload']['name'];

			// It doesn't care if the file already exists, it's simply overwritten.
			move_uploaded_file($_FILES["upload"]["tmp_name"], $basePath . $name);

		    // Build the url that should be used for this file
		    $url = $baseUrl . $name ;

		}
		else
		{
		    $message = 'No file has been sent';
		}
		// ------------------------
		// Write output
		// ------------------------
		echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message')</script>";
	}
}
