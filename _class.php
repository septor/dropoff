<?php
/*
 * Dropoff -- Attendance Buddy
 *
 * Copyright (C) 2016 Patrick Weaver (http://septor.xyz)
 * For additional information refer to the README.md file.
 */
class Dropoff
{
	function __construct($user='default')
	{
		$this->user = $user;
	}

	function loadFile()
	{
		$file = simplexml_load_file('data/'.$this->user.'.xml');

		return $file;
	}

	function getDropoffDate($date)
	{
		return strtotime(DROPOFF_PERIOD, strtotime($date));
	}

	function getActivePoints()
	{
		$data = $this->loadFile();
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

	function addOccurrence($type, $date)
	{
		$file = simplexml_load_file('data/'.$this->user.'.xml');

		$child = $file->addChild("occurrence");
		$child->addAttribute("type", $type);
		$child->addAttribute("date", $date);

		$file->asXML('data/'.$this->user.'.xml');
	}


}
