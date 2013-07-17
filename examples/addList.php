<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Try & Catch
	try
	{
		// add a new list
		$addList = $wunderlist->addList('Listname');
		
		// The list details are returned if the request was succesfull
		echo '<pre>';
		var_dump($addList);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		// $e->getCode() contains the error code	
	}
