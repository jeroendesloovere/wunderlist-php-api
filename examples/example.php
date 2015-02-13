<?php

/**
 * Wunderlist
 *
 * This Wunderlist PHP Class connects to the Wunderlist API.
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */

// add your own credentials in this file
require_once __DIR__ . '/credentials.php';

// required to load (only when not using an autoloader)
require_once __DIR__ . '/../vendor/autoload.php';

use JeroenDesloovere\Wunderlist\Wunderlist;

// define API
$api = new Wunderlist($username, $password);

/*
 * Profile
 */

// get profile
$items = $api->getProfile();

// get settings
//$items = $api->getSettings();

/*
 * Lists
 */

// get all lists
//$items = $api->getLists();

// get a list
//$items = $api->getList('ENTER_YOUR_LIST_ID_HERE');

// get shares for a list
//$items = $api->getListShares('ENTER_YOUR_LIST_ID_HERE');

/*
 * Tasks
 */

// get all tasks
//$items = $api->getTasks();

// get all tasks from inbox
//$items = $api->getTasksFromInbox();

// get a task
//$items = $api->getTask('ENTER_YOUR_TASK_ID_HERE');

// get all task messages
//$items = $api->getTaskMessages('ENTER_YOUR_TASK_ID_HERE');

/*
 * Other
 */

// get all events
//$items = $api->getEvents();

// get all friends
//$items = $api->getFriends();

// get all reminders
//$items = $api->getReminders();

// get all shares
//$items = $api->getShares();

// get all services
//$items = $api->getServices();

/*
 * Inserts
 */

$listId = '';
//$taskId = '';

// insert a list
//$items = $api->insertList('NEW');

// insert a task
//$items = $api->insertTask('NEW TASK', $listId);

/*
 * Deletes
 */

// delete list
//$items = $api->deleteList($listId);

// delete task
//$items = $api->deleteTask($taskId);

// dump items
print_r($items);
