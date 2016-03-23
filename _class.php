<?php
/*
 * Dropoff -- Attendance Buddy
 *
 * Copyright (C) 2016 Patrick Weaver (http://septor.xyz)
 * For additional information refer to the README.md file.
 */
class Dropoff
{
	function loadUser($user)
	{
		$file = simplexml_load_file('data/'.$user.'.xml');

		if(file_exists($file))
			return $file;
	}

	function getDropoffDate($date)
	{
		return strtotime("+6 month", strtotime($date));
	}

	function getActivePoints($user)
	{
		$data = $this->loadUser($user);
		$points = 0;
		$currDate = time();

		foreach($data->occurrence as $md)
		{
			$dropoff = $this->getDropoffDate($md['date']);

			if($currDate < $dropoff)
			{
				if($md['type'] == 'absent')
					$points += 1;
				else if($md['type'] == 'tardy')
					$points += .5;
				else if($md['type'] == 'leaveearly')
					$points += .5;
			}
		}

		return $points;
	}
}
