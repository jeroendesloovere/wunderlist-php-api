<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Try & Catch
	try
	{
		// get available tasks
		// parameter: 
		// 1: list_id
		// 2: include completed tasks? true / false
		$tasks = $wunderlist->getTasksByList('ABPtAATGbYg', false);
		
		// View lists
		echo '<pre>';
		var_dump($tasks);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		// $e->getCode() contains the error code	
	}
