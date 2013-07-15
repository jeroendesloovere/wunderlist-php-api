<?php
	
	// Include the class & constructor
	include_once('init.php');
	
	// get available lists
	$lists = $wunderlist->getLists();
	
	// View lists
	echo '<pre>';
	var_dump($lists);
