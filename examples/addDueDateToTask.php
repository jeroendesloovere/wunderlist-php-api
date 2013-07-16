<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Demo data
	$task_id = "ACPtABaOO3k";
	$due_date = "2013-07-19";
	$recurring = true; // false if the task is not recurring
	$interval_num = 3; // each X $interval_type
	$interval_type = 'weeks'; // days / weeks / months / years
	
	// Add the new task
	$addDueDateToTask = $wunderlist->addDueDateToTask($task_id, $due_date, $recurring, $interval_num, $interval_type);
	
	// The task details are returned if the request was succesfull
	echo '<pre>';
	var_dump($addDueDateToTask);
