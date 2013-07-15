<?php

	// Login Credits
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
	 
	$tasks = $wunderlist->getTasks();
	$lists = $wunderlist->getLists();
	
	foreach($tasks as $task)
	{
		
		if($task['due_date'] !== NULL)
		{
		
			$output .= "BEGIN:VEVENT
SUMMARY:".$wunderlist->lists[ $task['list_id'] ]['title']." - ".$task['title']."
UID:".$task['id']."
STATUS: CONFIRMED
DTSTART:" . date(DATE_ICAL, strtotime($task['due_date'])) . "
DTEND:" . date(DATE_ICAL, strtotime($task['due_date'])) . "
LAST-MODIFIED:" . date(DATE_ICAL, (strtotime($task['updated_at']))) . "
LOCATION: Wunderlist2-PHP
END:VEVENT\n";

			if( count($task['subtasks']) > 0) {
				foreach($task['subtasks'] as $subtask)
				{
					
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
	 
// close calendar
$output .= "END:VCALENDAR";
 
echo $output;

?>
