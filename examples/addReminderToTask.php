<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Try & Catch
	try
	{
		// Demo data
		$task_id = "ACPtABaOXeM";
		// WunderlistAPI expects Date in ISO format: YYYY-mm-ddTHH:ii:ssZ
		// However, this API Wrapper uses strtotime() to convert any valid PHP date to the correct format
		$date = "21-07-2013 18:00:00";
		
		// Add the new task
		$addReminderToTask = $wunderlist->addReminderToTask($task_id, $date);
		
		// The reminder details are returned if the request was succesfull
		echo '<pre>';
		var_dump($addReminderToTask);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		// $e->getCode() contains the error code	
	}
