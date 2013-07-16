<?php

	/**
	 * Wrapper for Wunderlist2 API
	 * api.class.php
	 * Purpose: communicate with Wunderlist2 API
	 *
	 * @author		Joshua de Gier
	 * @version		0.1b	15/07/2013
	 */

	class Wunderlist
	{
		
		private $authtoken = false;
		private $api_url = 'http://api.wunderlist.com';
		
		public $tasks = false;
		public $lists = false;
		public $listTasks = false;
		
		/**
		 * construct the Wunderlist API and save the authentication token for later use
		 *
		 * @param string $email
		 * @param string $password
		 *
		 * @return bool
		 */
		public function __construct($email, $password)
		{
			$data = array(
				'email' => $email,
				'password' => $password
			);
			$return = $this->call('/login', 'post', $data);
			
			if($return != false)
			{
				$this->authtoken = $return['token'];
				return true;
			} 
			else
			{
				return false;	
			}
		}
		
		/**
		 * get the details of the currently logged in user
		 *
		 * @return bool|array
		 */
		public function me()
		{
			$return = $this->call('/me', 'get', array());	
			return $return;
		}
		
		/**
		 * get all tasks connected to the account
		 *
		 * @param bool $completed
		 * @return array
		 */
		public function getTasks($completed = false)
		{
			$return = $this->call('/me/tasks', 'get', array());
			
			// Put subtasks within their parents
			$aOrdened = $subtasks = array();
			foreach($return as $task)
			{
				if(($completed == true) || ($completed == false && $task['completed_at'] == NULL))
				{
					if( $task['parent_id'] == NULL ) 
					{
						$aOrdened[ $task['id'] ] = $task;
						$aOrdened[ $task['id'] ]['subtasks'] = array();
					}
					else
					{
						$subtasks[] = $task;	
					}
				}
			}
			
			// Insert subtasks
			foreach($subtasks as $subtask)
			{
				$aOrdened[ $subtask['parent_id'] ]['subtasks'][] = $subtask;	
			}
			
			// Put tasks in variable
			$this->tasks = $aOrdened;
			
			return $aOrdened;	
		}
		
		/**
		 * get all lists connected to the account
		 *
		 * @return array
		 */
		public function getLists()
		{
			$return = $this->call('/me/lists', 'get', array());
			
			// Create a useable array
			$aOrdened = array();
			foreach($return as $list)
			{
				$aOrdened[ $list['id'] ] = $list;
			}
			$this->lists = $aOrdened;
			
			return $aOrdened;	
		}
		
		/**
		 * get all tasks belonging to a specified task list
		 *
		 * @param string $list_id
		 * @param bool $completed
		 *
		 * @return array
		 */
		public function getTasksByList($list_id, $completed = false)
		{
			// Get all lists
			if($this->lists == false)
			{
				$this->getLists();	
			}
			
			// Get all tasks
			if($this->tasks == false)
			{
				$this->getTasks();	
			}
			
			// Build an associative array with all tasks
			if($this->listsTasks == false)
			{
				// Loop lists
				foreach($this->lists as $list)
				{
					$this->listTasks[ $list['id'] ] = array(
						'details' => $list,
						'tasks' => array()
					);
				}
				
				// Loop tasks
				foreach($this->tasks as $task)
				{
					// Check for completed state
					if(($completed == true) || ($completed == false && $task['completed_at'] == NULL))
					{
						$this->listTasks[ $task['list_id'] ]['tasks'][] = $task;	
					}
				}
			}
			
			// Return the list
			if( array_key_exists( $list_id, $this->listTasks )) 
			{
				return $this->listTasks[ $list_id ];	
			} else {
				return false;	
			}
			
		}
		
		/**
		 * Add a list to the Wunderlist account
		 *
		 * @param string $title
		 * @return bool|array
		 */
		public function addList($title)
		{
			if( $title == "" )
			{
				return false;
			}
			else
			{
				return $this->call('/me/lists', 'post', array('title' => $title));	
			}
		}
		
		/**
		 * Add a task to a list
		 *
		 * @param string $title
		 * @param string $list_id
		 * @param date $due_date (format "YYYY-mm-ddTHH:ii:ssZ")
		 * @param bool $starred
		 */
		public function addTask($title, $list_id, $due_date='', $starred=false)
		{
			if( $title == "" || $list_id == "" )
			{
				return false;
			}
			else
			{
				// Set data for the call
				$data = array(
					'title' => $title,
					'list_id' => $list_id,
					'starred' => $starred == true ? 1 : 0
				);
				
				// Add due date of found
				if( $due_date != "" )
				{
					$data['due_date'] = date("Y-m-d\TH:i:s\Z", strtotime($due_date));
				}	
				
				return $this->call('/me/tasks', 'post', $data);
			}
		}
		
		/**
		 * performs the call to the Wunderlist API
		 *
		 * @param string $action
		 * @param string $method
		 * @param array $data
		 *
		 * @return array
		 */
		private function call($action, $method, $data)
		{
			
			$ch = curl_init($this->api_url.$action);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
			
			// What method?
			if(strtolower($method) == 'post')
			{
				curl_setopt($ch, CURLOPT_POST, true );
			}
			
			// Pass data?
			if(is_array($data) && count($data) > 0)
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );
			}
			
			// Send authtoken if set
			if($this->authtoken != false)
			{
				$headers = array(
					'authorization: Bearer '.$this->authtoken
				);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);	
			}
			
			$output = curl_exec($ch);
			
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpCode != 200 && $httpCode != 201)
			{
				return false;	
			}
			
			curl_close($ch);
			
			return json_decode($output, true);			
		}
		
	}

?>
