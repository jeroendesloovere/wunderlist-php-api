<?php

	/**
	 * Wrapper for Wunderlist2 API
	 * api.class.php
	 * Purpose: communicate with Wunderlist2 API
	 *
	 * @requires	base.class.php
	 * @author		Joshua de Gier
	 * @version		1.02	26/07/2013
	 */

	require_once('base.class.php');
	
	class Wunderlist extends Wunderbase
	{
		
		public $authtoken = false;
		protected $api_url = 'https://api.wunderlist.com';
		
		private $tasks = false;
		private $lists = false;
		private $listTasks = false;
		
		/**
		 * construct the Wunderlist API and save the authentication token for later use
		 *
		 * @param string $email
		 * @param string $password
		 *
		 * @throws Exception if any of the parameters are empty or authentication fails
		 * @return void
		 */
		public function __construct($email, $password)
		{
			// Check for email
			if( $email == "" )
			{
				throw new Exception( "E-mail parameter empty", 1001 );	
			}
			
			// Check for password
			if( $password == "" )
			{
				throw new Exception( "Password parameter empty", 1002 );	
			}
			
			$data = array(
				'email' => $email,
				'password' => $password
			);
			$return = $this->call('/login', 'post', $data);
			
			if($return != false)
			{
				$this->authtoken = $return['token'];
			} 
			else
			{
				throw new Exception( "Authentication failed", 3001 );	
			}
		}
		
		/**
		 * get the details of the currently logged in user
		 *
		 * @return array Returns an array with the data of the user
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
		 * @return array Returns an array with all tasks
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
		 * @return array Returns an array with all lists
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
		 * @throws Exception if any of the parameters are empty
		 * @return array Returns an array with tasks belonging to $list_id
		 */
		public function getTasksByList($list_id, $completed = false)
		{
			// Check data
			if( $list_id == "" )
			{
				throw new Exception( "list_id parameter empty", 1003 );	
			}
			
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
				throw new Exception( "List not found", 2001 );	
			}
		}
		
		/**
		 * get reminders that are set
		 *
		 * @return array Returns an array containing the reminders
		 */
		public function getReminders()
		{
			// Get all tasks
			if($this->tasks == false)
			{
				$this->getTasks();	
			}
			
			// Get the reminders
			$reminders = $this->call('/me/reminders', 'get', array());
			
			// Loop reminders to add task data
			foreach($reminders as $key => $data)
			{
				$reminders[$key]['task'] = $this->tasks[ $data['task_id'] ];	
			}
			
			// Return the reminders
			return $reminders;
		}
		
		/**
		 * Add a list to the Wunderlist account
		 *
		 * @param string $title
		 *
		 * @throws Exception if any of the parameters are empty
		 * @return array Returns the array with the added list
		 */
		public function addList($title)
		{
			// Check title parameter
			if( $title == "" )
			{
				throw new Exception( "title parameter empty", 1004 );
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
		 * @param date $due_date (format "YYYY-mm-dd")
		 * @param bool $starred
		 *
		 * @throws Exception if any of the parameters are empty
		 * @return array Returns the array with the added task
		 */
		public function addTask($title, $list_id, $due_date='', $starred=false)
		{
			// Check title parameter
			if( $title == "" )
			{
				throw new Exception( "title parameter empty", 1004 );
			}
			
			// Check list_id parameter
			if( $list_id == "" )
			{
				throw new Exception( "list_id parameter empty", 1003 );
			}
			
			// Set data for the call
			$data = array(
				'title' => $title,
				'list_id' => $list_id,
				'starred' => $starred == true ? 1 : 0
			);
			
			// Add due date of found
			if( $due_date != "" )
			{
				if( !strtotime($due_date) )
				{
					throw new Exception( "due_date parameter invalid", 1006 );	
				}
				$data['due_date'] = date("Y-m-d", strtotime($due_date));
			}	
			
			return $this->call('/me/tasks', 'post', $data);
		}
		
		/**
		 * Add a note to a task
		 *
		 * @param string $task_id
		 * @param string $note
		 *
		 * @throws Exception if any of the parameters are empty
		 * @return array Returns an array with the task details
		 */
		public function addNoteToTask($task_id, $note)
		{
			// Check title parameter
			if( $task_id == "" )
			{
				throw new Exception( "task_id parameter empty", 1005 );
			}
			
			// Check list_id parameter
			if( $note == "" )
			{
				throw new Exception( "note parameter empty", 1007 );
			}
			
			// Set data for the call
			$data = array(
				'note' => $note
			);
			
			return $this->call('/'.$task_id, 'put', $data);
		}
		
		/**
		 * set a due date for a task, optional: recurring
		 *
		 * @param string $task_id
		 * @param date $due_date
		 * @param bool $recurring
		 * @param int $recurring_interval_num
		 * @param string $recurring_interval_type
		 *
		 * @throws Exception if any of the parameters are empty
		 * @return array Returns an array with the task details
		 */
		public function addDueDateToTask($task_id, $due_date, $recurring = false, $interval_num = 0, $interval_type = 'none')
		{
			switch($interval_type)
			{
				case 'days':$interval_type='day';break;
				case 'weeks':$interval_type='week';break;
				case 'months':$interval_type='month';break;
				case 'years':$interval_type='year';break;
				default:$interval_type=false;break;
			}
			
			// Check title parameter
			if( $task_id == "" )
			{
				throw new Exception( "task_id parameter empty", 1005 );
			}
			
			// Check for a valid due_date
			if( $due_date == "" || !strtotime($due_date) )
			{
				throw new Exception(" due_date parameter invalid", 1006 );	
			}
			
			// Set the data
			$data = array(
				'due_date' => date("Y-m-d", strtotime($due_date))
			);
			
			// If the task is recurring, set the interval
			if( $recurring )
			{
				if( !$interval_type || intval($interval_num) == 0 )
				{
					throw new Exception( "Invalid recurring profile", 1008 );
				}
				else
				{
					$data['recurrence_count'] = intval($interval_num);
					$data['recurrence_type'] = $interval_type;	
				}
			}
			
			return $this->call('/'.$task_id, 'put', $data);
		}
		
		/**
		 * add a reminder to a task
		 *
		 * @param string $task_id
		 * @param date $reminder_date
		 *
		 * @throws Exception if any of the parameters are empty
		 * @return array Returns an array with the task detaild
		 */
		public function addReminderToTask($task_id, $reminder_date)
		{
			// Check title parameter
			if( $task_id == "" )
			{
				throw new Exception( "task_id parameter empty", 1005 );
			} 
			
			// Check reminder_date
			if( $reminder_date == "" || !strtotime($reminder_date))
			{
				throw new Exception( "reminder_date parameter invalid", 1009 );
			}
			
			// Set data for the call
			$data = array(
				'task_id' => $task_id,
				'date' => date("Y-m-d\TH:i:s\Z", strtotime($reminder_date))
			);
			
			return $this->call('/me/reminders', 'post', $data);
		}
		
		/**
		 * delete a task
		 *
		 * @param string $task_id
		 *
		 * @throws Exception if any of the parameters are empty
		 * @return bool 
		 */
		public function deleteTask($task_id)
		{
			// Check title parameter
			if( $task_id == "" )
			{
				throw new Exception( "task_id parameter empty", 1005 );
			} 
			
			$return = $this->call('/'.$task_id, 'delete', array());
			
			// If delete was succesfull an empty array is return
			if( is_array($return) && count($array) == 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/**
		 * delete a list
		 *
		 * @param string $list_id
		 *
		 * @throws Exception if any of the parameters are empty
		 * @return bool
		 */
		public function deleteList($list_id)
		{
			// Check data
			if( $list_id == "" )
			{
				throw new Exception( "list_id parameter empty", 1003 );	
			}
			
			$return = $this->call('/'.$list_id, 'delete', array());
			
			// If delete was succesfull an empty array is return
			if( is_array($return) && count($array) == 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
	}

?>
