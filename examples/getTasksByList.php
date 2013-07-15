<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// get available tasks
	// parameter: 
	// 1: list_id
	// 2: include completed tasks? true / false
	$tasks = $wunderlist->getTasksByList('ABPtAATGbYg', false);
	
	// View lists
	echo '<pre>';
	var_dump($tasks);
