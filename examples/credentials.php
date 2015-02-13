<?php

// define your own credentials
const WUNDERLIST_CLIENT_ID = ''; // required
const WUNDERLIST_CLIENT_SECRET = ''; // required

// throw error
if (empty(WUNDERLIST_CLIENT_SECRET) ||
    empty(WUNDERLIST_CLIENT_ID)
) {
    echo 'Please define your CLIENT_ID & CLIENT_SECRET in ' . __DIR__ . '/credentials.php';
}
