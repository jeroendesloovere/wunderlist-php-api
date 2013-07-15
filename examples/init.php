<?php

	// Contains my demo login credentials, make sure to change these as
	// this file is not part of the repository
	require_once("../../credits.php");

	// Require the API class
	require_once('../api.class.php');
	
	// construct the Wunderlist class using user Wunderlist e-mailaddress and password	
	$wunderlist = new Wunderlist($wlUser, $wlPass);