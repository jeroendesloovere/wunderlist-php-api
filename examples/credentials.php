<?php

// define your own credentials
const WUNDERLIST_CLIENT_ID = ''; // required
const WUNDERLIST_OAUTH_TOKEN = ''; // required

// throw error
if (empty(WUNDERLIST_OAUTH_TOKEN) ||
    empty(WUNDERLIST_CLIENT_ID)
) {
    echo 'Please define your OAUTH_TOKEN and CLIENT_ID in ' . __DIR__ . '/credentials.php';
}
