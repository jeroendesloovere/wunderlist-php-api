<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Try & Catch
	try
	{
		// Get reminders
		$reminders = $wunderlist->getReminders();
		
		// Reminders (if found) are returned
		echo '<pre>';
		var_dump($reminders);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		// $e->getCode() contains the error code	
	}
