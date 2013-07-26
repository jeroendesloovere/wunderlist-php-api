<?php

	/**
	 * Wrapper for Wunderlist2 API - Files (PRO accounts only)
	 * api.class.php
	 * Purpose: communicate with Wunderlist2 API
	 *
	 * @requires	base.class.php
	 * @author		Joshua de Gier
	 * @version		1.01	18/07/2013
	 */

	require_once('base.class.php');

	class Wunderfiles extends Wunderbase
	{
		
		protected $authtoken = false;
		protected $api_url = 'https://files.wunderlist.com';
		
		protected $files = false;
		
		/**
		 * construct the Wunderlist Files API and save the authentication token for later use
		 *
		 * @param string $token
		 *
		 * @throws Exception if any of the parameters are empty or authentication fails
		 * @return void
		 */
		public function __construct($token)
		{
			// Check for email
			if( $token == "" )
			{
				throw new Exception( "Token parameter empty", 1001 );	
			}
			$this->authtoken = $token;
		}
		
		/**
		 * get all the files of the currently logged in user
		 *
		 * @return array Returns an array with the files of the user
		 */
		public function filelist()
		{
			$return = $this->call('/files', 'get', array());	
			return $return;
		}
		
	}

?>
