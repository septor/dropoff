<?php
/*
 * Dropoff -- Attendance Buddy
 *
 * Copyright (C) 2016 Patrick Weaver (http://septor.xyz)
 * For additional information refer to the README.md file.
 */
require_once('_class.php');
$drop = new Dropoff();
$user = 'example';

$data = $drop->loadUser($user);
echo 'You currently have '.$drop->getActivePoints($user).' active occurrences.<br /><br />';
