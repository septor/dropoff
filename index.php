<?php
/*
 * Dropoff -- Attendance Buddy
 *
 * Copyright (C) 2016 Patrick Weaver (http://septor.xyz)
 * For additional information refer to the README.md file.
 */
require_once('_config.php');
require_once('_class.php');
$drop = new Dropoff();
$user = 'default';

$data = $drop->loadUser($user);
$points = $drop->getActivePoints($user);
echo 'You  currently have '.$points.' active occurrences.<br /><br />
Here are how you received them:
<ul>';

foreach($data->occurrence as $ding)
{
	$type = $ding['type'];
	$date = date(DATE_FORMAT, strtotime($ding['date']));
	$dropunix = $drop->getDropoffDate($ding['date']);
	$dropoff = date(DATE_FORMAT, $dropunix);

	if(time() < $dropunix)
	{
		if($type == 'absent')
			echo '<li>You called in (+'.ABSENT_VALUE.') on '.$date.'. It drops off on '.$dropoff.'.</li>';
		else if($type == 'tardy')
			echo '<li>You were late (+'.TARDY_VALUE.') on '.$date.'. It drops off on '.$dropoff.'.</li>';
		else
			echo '<li>You left early (+'.LEAVEEARLY_VALUE.') on '.$date.'. It drops off on '.$dropoff.'.</li>';
	}
}

echo '</ul>
You have '.(TOTAL_ALLOWED_OCCURRENCES - $points).' points you can still use.';
