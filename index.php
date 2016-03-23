<?php
/*
 * Dropoff -- Attendance Buddy
 *
 * Copyright (C) 2016 Patrick Weaver (http://septor.xyz)
 * For additional information refer to the README.md file.
 */
// NOTE: Styling will come after the data dump is completed!
require_once('_config.php');
require_once('_class.php');
$drop = new Dropoff();
$user = 'default';

$data = $drop->loadUser($user);
$points = $drop->getActivePoints($user);


echo '<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Dropoff - Attendence Buddy</title>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	</head>
	<body>
		<div>
			<p>You currently have '.$points.' active occurrences.</p>
			<p>Here are how you received them:</p>
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
			echo '
				<li>You called in (+'.ABSENT_VALUE.') on '.$date.'. It drops off on '.$dropoff.'.</li>';
		else if($type == 'tardy')
			echo '
				<li>You were late (+'.TARDY_VALUE.') on '.$date.'. It drops off on '.$dropoff.'.</li>';
		else
			echo '
				<li>You left early (+'.LEAVEEARLY_VALUE.') on '.$date.'. It drops off on '.$dropoff.'.</li>';
	}
}

echo '
			</ul>
			<p>You have '.(TOTAL_ALLOWED_OCCURRENCES - $points).' points you can still use.</p>
		</div>
		<div>
			<p>You can add another occurrence below:</p>

			<form method="post" name="date" action="index.php">
				<p>Date occurrence happened: <input type="text" id="datepicker"></p>
				<p>
					Type of occurrence:
					<select name="type">
						<option value="absent">Absence</option>
						<option value="tardy">Late</option>
						<option value="leaveearly">Left Early</option>
					</select>
				</p>
				<p><input type="submit" name="submit" value="Add occurrence"></p>
			</form>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="dropoff.js"></script>
	</body>
</html>';
