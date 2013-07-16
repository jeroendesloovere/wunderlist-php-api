<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Demo data
	$task_id = "ACPtABaN-bY";
	
	// Delete the task
	$deleteTask = $wunderlist->deleteTask($task_id);
	
	// An empty array is returned if the task was deleted
	echo '<pre>';
	var_dump($deleteTask);
