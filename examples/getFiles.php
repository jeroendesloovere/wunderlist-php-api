<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Try & Catch
	try
	{
		// Construct the Wunderfiles class and pass our token
		$wunderFiles = new Wunderfiles( $wunderlist->authtoken );
		
		// Get all available files
		$files = $wunderFiles->filelist();
		
		// View lists
		echo '<pre>';
		var_dump($files);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		// $e->getCode() contains the error code	
	}
