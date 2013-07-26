<?php

	// Contains my demo login credentials, make sure to change these as
	// this file is not part of the repository
	require_once("../../credits.php");

	// Require the API class
	require_once('../api.class.php');
	require_once('../api.files.class.php');
	
	// construct the Wunderlist class using user Wunderlist e-mailaddress and password	
	try
	{
		$wunderlist = new Wunderlist($wlUser, $wlPass);
	}
	catch(Exception $e)
	{
		die( $e->getMessage() );
		// $e->getCode() contains the error code	
	}