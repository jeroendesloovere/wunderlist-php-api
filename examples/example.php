<?php

/**
 * Wunderlist
 *
 * This Wunderlist PHP Class connects to the Wunderlist API.
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */

// required to load (only when not using an autoloader)
require_once __DIR__ . '/../vendor/autoload.php';

// add your own credentials in this file
require_once __DIR__ . '/credentials.php';

use JeroenDesloovere\Wunderlist\Wunderlist;

// define API
$api = new Wunderlist(
    WUNDERLIST_CLIENT_ID,
    WUNDERLIST_OAUTH_TOKEN
);

//$api->authorize();


/*
 * Lists
 */

// get all lists
$items = $api->lists->getAll();

// get a list
//$items = $api->lists->get('ENTER_YOUR_LIST_ID_HERE');

/*
 * Tasks
 */

// get all tasks
//$items = $api->tasks->getAll();

// get a task
//$items = $api->tasks->get('ENTER_YOUR_TASK_ID_HERE');

// dump items
print_r($items);
