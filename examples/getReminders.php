<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Get reminders
	$reminders = $wunderlist->getReminders();
	
	// Reminders (if found) are returned
	echo '<pre>';
	var_dump($reminders);
