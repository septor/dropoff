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

	function getNextDropoffDing($format='%m months')
	{
		$data = $this->loadFile();

		foreach($data->occurrence as $date)
		{
			$dropoff = $this->getDropoffDate($date['date']);

			if(time() < $dropoff)
				$dates[] = $this->getDropoffDate($date['date']);
		}

		sort($dates);

		$date1 = new DateTime(date('Y-m-d'));
		$date2 = new DateTime(date('Y-m-d', $dates[0]));
		$interval = $date1->diff($date2);

		return $interval->format($format);
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
