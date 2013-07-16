<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Demo data (NOTE: due_date = ISO format Y-m-dTH:i:sZ
	$title = "New Task";
	$list_id = "ABPtAATGbYg";
	$due_date = date("Y-m-d\TH:i:s\Z", mktime()+(60*60*24));
	$starred = false;
	
	// Add the new task
	$addTask = $wunderlist->addTask($title, $list_id, $due_date, $starred);
	
	// The task details are returned if the request was succesfull
	echo '<pre>';
	var_dump($addTask);
