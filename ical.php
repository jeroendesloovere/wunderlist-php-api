<?php

	// In order to keep your tasklist secure for just yourself I would suggest adding a small
	// layer of security to this file. Perhaps a password. Remove the /* and */ below to activate
	// a password that has to be available in the GET-parameters of the request:
	/*
		$iCal_password = "myUnh4ck4bl3_password";
		if($_GET['pass'] != $iCal_password)
		{
			die("iCal is currently unavailable");
		}
	*/
	// By using the above security to this fill, you should add the ical to your agenda using the URL:
	//	http://www.yourdomain.com/folder-to-wrapper/ical.php?pass=myUnh4ck4ble_password

	// Login Credits
	// This file should be removed if you use it yourself
	// Change $wlUser and $wlPass on line 15 to your own login data
	// Or create a "credits.php" file outside the github folder containing both variables
	// A future release will have this option inside the Wunderlist API Wrapper, for now it's meant to be used quickly
	require_once("../credits.php");

	// Header
	header('Content-Type: text/html; charset=utf-8');

	// Require Class
	require_once('api.class.php');
	
	// Setup Wunderlist
	$wunderlist = new Wunderlist($wlUser, $wlPass);
		
	// Set iCal Date
	define('DATE_ICAL', 'Ymd\THis');
	 
$output = "BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
PRODID:-//Wunderlist2-PHP//Tasks//NL\n";
	 
	// Get all tasks and lists: we need some of this information in the ical
	// we can also do $tasks = $wunderlist->getTasks(false); to have completed tasks not included in the ical
	$tasks = $wunderlist->getTasks();
	$lists = $wunderlist->getLists();
	
	// Loop all tasks
	foreach($tasks as $task)
	{
		
		// Only view tasks with a due date
		if($task['due_date'] !== NULL)
		{
		
			// Start ical output for the parent task
			$output .= "BEGIN:VEVENT
SUMMARY:".$wunderlist->lists[ $task['list_id'] ]['title']." - ".$task['title']."
UID:".$task['id']."
STATUS: CONFIRMED
DTSTART:" . date(DATE_ICAL, strtotime($task['due_date'])) . "
DTEND:" . date(DATE_ICAL, strtotime($task['due_date'])) . "
LAST-MODIFIED:" . date(DATE_ICAL, (strtotime($task['updated_at']))) . "
LOCATION: Wunderlist2-PHP
END:VEVENT\n";

			// Loop all subtasks if there are any
			if( count($task['subtasks']) > 0) {
				foreach($task['subtasks'] as $subtask)
				{
					
					// Subtask due date is the same as the head task
					// Maybe in the future subtasks will have due dates aswel
					// Start ical output for the subtask
					$output .= "BEGIN:VEVENT
SUMMARY:".$wunderlist->lists[ $task['list_id'] ]['title']." - ".$task['title']." - ".$subtask['title']."
UID:".$subtask['id']."
STATUS: CONFIRMED
DTSTART:" . date(DATE_ICAL, strtotime($task['due_date'])) . "
DTEND:" . date(DATE_ICAL, strtotime($task['due_date'])) . "
LAST-MODIFIED:" . date(DATE_ICAL, (strtotime($subtask['updated_at']))) . "
LOCATION: Wunderlist2-PHP
END:VEVENT\n";

				}
			}

		}
			
	}
	 
// Close calendar
$output .= "END:VCALENDAR";
 
// Output the ical file to your screen
echo $output;

?>
