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

// required to load
require_once __DIR__ . '/../src/Wunderlist.php';

use JeroenDesloovere\Wunderlist\Wunderlist;

// define API
$api = new Wunderlist($username, $password);

// get profile
//$items = $api->getProfile();

// get all lists
//$items = $api->getLists();
echo "na getLists";

// get all tasks
//$items = $api->getTasks();
echo "na getTasks";

// get all tasks from inbox
$items = $api->getTasksFromInbox();
echo "na getTasksFromInbox";

// dump items
print_r($items);
