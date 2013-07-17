<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Try & Catch
	try
	{
		// get available tasks
		// parameter: include completed tasks? true / false
		$tasks = $wunderlist->getTasks(true);
		
		// View lists
		echo '<pre>';
		var_dump($tasks);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		// $e->getCode() contains the error code	
	}
