<?php

	/**
	 * Wrapper for Wunderlist2 API
	 * api.class.php
	 * Purpose: communicate with Wunderlist2 API
	 *
	 * @author		Joshua de Gier
	 * @version		1.01	18/07/2013
	 */		
	
	class Wunderbase
	{
	
		protected function call($action, $method, $data)
		{	
			// Check action parameter
			if( $action == "" )
			{
				throw new Exception( "No API action given", 0001 );
			}
			
			// Check method parameter
			if( $action == "" )
			{
				throw new Exception( "No API method given", 0002 );
			}
			
			// Expected response is 200 OK
			$expectedResponse = 200;
				
			// Start with an empty set of headers
			$headers = array();
			
			// Init cURL
			$ch = curl_init($this->api_url.$action);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
			
			// Pass data?
			if( is_array($data) && count($data) > 0 )
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );
			}
			
			// Set request type for POST
			if( strtolower($method) == 'post' )
			{
				if( $action != "/login" )
				{
					// For post-request the expected response is 201 Created
					$expectedResponse = 201;
				}
				curl_setopt($ch, CURLOPT_POST, true );
			}
			
			// Set request type for PUT
			if( strtolower($method) == 'put' )
			{
				// Set custom request to put
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				
				// Data needs to be send as json
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data) );	
				
				// Set header content-type to application/json
				$headers[] = 'content-type: application/json';
				
				// Set header Content-Lenght to the json encoded length
				$headers[] = 'Content-Length: '.strlen(json_encode($data));
			}
			
			// Set request type for DELETE
			if( strtolower($method) == 'delete' )
			{
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');	
			}
			
			// Send authtoken if set
			if( $this->authtoken != false )
			{
				$headers[] = 'authorization: Bearer '.$this->authtoken; 
			}
			
			// Files
			if( strpos($action, "/files") )
			{
				$headers[] = "Accept: application/json";
				$headers[] = "Accept-Encoding: gzip, deflate";
				$headers[] = "Accept-Language: nl,en-us;q=0.7,en,q=0.3";
				$headers[] = "Content-Type: application/json; charset=utf-8";
				$headers[] = "Host: files.wunderlist.com";
				$headers[] = "Origin: https://www.wunderlist.com";
				$headers[] = "Referer: https://www.wunderlist.com";
				$headers[] = "X-6W-Platform: web";
				$headers[] = "X-6W-Product: wunderlist";
				$headers[] = "X-6W-System: MacIntel";	
			}
			
			// Send headers with the request
			if( count($headers) > 0 ) 
			{
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);	
			}
			
			$output = curl_exec($ch);
			
			// Get HTTP response
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			// Close CURL
			curl_close($ch);
			
			// get / put / delete requests should have HTTP Code 200 OK
			// only exception is the login method, which returns HTTP Code 200 OK
			if($httpCode == 200 && (strtolower($method) != 'post' || $action == '/login'))
			{
				return json_decode($output, true);
			}
			// all non-login post requests should have HTTP Code 201 Created
			elseif($httpCode == 201 && strtolower($method) == 'post')
			{
				return json_decode($output, true);
			}
			// If the HTTP code did not match, than the request failed
			else
			{
				throw new Exception( "API Call failed - Method: $method - Action: $action - HTTP Response: $httpCode (Expected $expectedResponse)", 0000 );
			}		
		}
		
	}