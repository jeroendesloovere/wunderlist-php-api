<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Demo data
	$list_id = "ABPtAATGbYk";
	
	// Delete the list
	$deleteList = $wunderlist->deleteList($list_id);
	
	// An empty array is returned if the list was deleted
	echo '<pre>';
	var_dump($deleteList);
