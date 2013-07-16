<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Demo data
	$task_id = "ACPtABaOO3k";
	// Use \n to get a newline within the note 
	$note = "New note to this task";
	
	// Add the new task
	$addNoteToTask = $wunderlist->addNoteToTask($task_id, $note);
	
	// The task details are returned if the request was succesfull
	echo '<pre>';
	var_dump($addNoteToTask);
