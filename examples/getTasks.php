<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// get available tasks
	// parameter: include completed tasks? true / false
	$tasks = $wunderlist->getTasks(true);
	
	// View lists
	echo '<pre>';
	var_dump($tasks);
