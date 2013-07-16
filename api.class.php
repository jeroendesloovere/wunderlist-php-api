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
		 * Add a note to a task
		 *
		 * @param string $task_id
		 * @param string $note
		 */
		public function addNoteToTask($task_id, $note)
		{
			if( $task_id == "" || $note == "" )
			{
				return false;
			}
			else
			{
				// Set data for the call
				$data = array(
					'id' => $task_id,
					'note' => $note,
					'type' => 'Task',
					'length' => strlen($note)
				);
				
				return $this->call('/'.$task_id, 'put', $data);
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
			
			// Set request type for POST
			if(strtolower($method) == 'post')
			{
				curl_setopt($ch, CURLOPT_POST, true );
			}
			
			// Set request type for PUT
			if(strtolower($method) == 'put')
			{
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');	
			}
			
			// Set request type for DELETE
			if(strtolower($method) == 'delete')
			{
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');	
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
				// This can be used to handle errors within the wrapper
				return array(
					'action' => $action,
					'method' => $method,
					'data' => serialize($data),
					'httpCode' => $httpCode,
					'output' => $output
				);
			}
						
		}
		
	}

?>
