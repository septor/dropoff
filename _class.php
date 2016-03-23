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
		return strtotime(DROPOFF_PERIOD, strtotime($date));
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
					$points += ABSENT_VALUE;
				else if($md['type'] == 'tardy')
					$points += TARDY_VALUE;
				else if($md['type'] == 'leaveearly')
					$points += LEAVEEARLY_VALUE;
			}
		}

		return $points;
	}
}
