<?php

class DateTimeView {

	public function show() {
		$day = date("l");
		$date = date("jS");
		$month = date("F");
		$year = date("h");
		$time = date("h:i:s");

		$timeString = $day . ", the " . $date . " of " . $month . " " . $year . ", The time is " . $time;

		return '<p>' . $timeString . '</p>';
	}
}
