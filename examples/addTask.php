<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Demo data
	$title = "New Task #2";
	$list_id = "ABPtAATIHNM";
	//$due_date = date("Y-m-d", mktime()+(60*60*24));
	$due_date = false;
	$starred = false;
	
	// Add the new task
	$addTask = $wunderlist->addTask($title, $list_id, $due_date, $starred);
	
	// The task details are returned if the request was succesfull
	echo '<pre>';
	var_dump($addTask);
