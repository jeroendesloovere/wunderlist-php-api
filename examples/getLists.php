<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Try & Catch
	try
	{
		// get available lists
		$lists = $wunderlist->getLists();
		
		// View lists
		echo '<pre>';
		var_dump($lists);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		// $e->getCode() contains the error code	
	}
