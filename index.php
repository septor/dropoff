<?php
/*
 * Dropoff -- Attendance Buddy
 *
 * Copyright (C) 2016 Patrick Weaver (http://septor.xyz)
 * For additional information refer to the README.md file.
 */
// NOTE: Styling will come after the data dump is completed!
require_once('_config.php');
require_once('_passwords.php');
require_once('_class.php');

$drop = new Dropoff();
$data = $drop->loadFile();
$points = $drop->getActivePoints();
$dod = $drop->getNextDropoffDing('%m months, %d days');

if(isset($_POST['submit']))
{
	// Needs actual testing, plus we need to define the file somewhere and then send it.
	if($_POST['password'] == $PASSWORD['default.xml'])
		$drop->addOccurrence($_POST['type'], $_POST['date']);
}


echo '<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Dropoff - Attendence Buddy</title>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="assets/style.css">
	</head>
	<body>
		<div id="header">
			<h1>Dropoff</h1>
			<p>Attendance Buddy</p>
		</div>
		<div id="content">
			<h1>Active Occurrences</h1>
			<p style="text-align:center;">
				You currently have <strong>'.$points.'</strong> points. Your next occurrence drops off in <strong>'.$dod.'</strong>.
			</p>
			<table id="dings">
				<thead>
					<tr>
						<td>What Happened</td>
						<td>Occurrence Date</td>
						<td>Dropoff Date</td>
					</tr>
				</thead>
				<tbody>';

foreach($data->occurrence as $ding)
{
	$type = $ding['type'];
	$date = date(DATE_FORMAT, strtotime($ding['date']));
	$dropunix = $drop->getDropoffDate($ding['date']);
	$dropoff = date(DATE_FORMAT, $dropunix);

	if(time() < $dropunix)
	{
		if($type == 'absent')
			$wordtype = 'Called In';
		else if($type == 'tardy')
			$wordtype = 'Came In Late';
		else
			$wordtype = 'Left Early';

		echo '
					<tr>
						<td>'.$wordtype.'</td>
						<td>'.$date.'</td>
						<td>'.$dropoff.'</td>
					</tr>';
	}
}

echo '
				</tbody>
			</table>
		</div>
		<div id="manage">
			<h1>Add Occurrence</h1>
			<form method="post" action="index.php">
				<p>Date occurrence happened: <input type="text" name="date" id="datepicker"></p>
				<p>
					Type of occurrence:
					<select name="type">
						<option value="absent">Absence</option>
						<option value="tardy">Late</option>
						<option value="leaveearly">Left Early</option>
					</select>
				</p>
				<p>Password: <input type="password" name="password"></p>
				<p><input type="submit" name="submit" value="Add occurrence"></p>
			</form>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="assets/dropoff.js"></script>
	</body>
</html>';
