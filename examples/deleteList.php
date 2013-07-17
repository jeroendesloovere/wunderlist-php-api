<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// Try & Catch
	try
	{
		// Demo data
		$list_id = "ABPtAATGbYk";
		
		// Delete the list
		$deleteList = $wunderlist->deleteList($list_id);
		
		// An empty array is returned if the list was deleted
		echo '<pre>';
		var_dump($deleteList);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		// $e->getCode() contains the error code	
	}
