<?php
/*
 * Dropoff -- Attendance Buddy
 *
 * Copyright (C) 2016 Patrick Weaver (http://septor.xyz)
 * For additional information refer to the README.md file.
 */
// Number of occurrences you can accumulate.
define('TOTAL_ALLOWED_OCCURRENCES', 8);

// Point values for each occurrence type.
define('ABSENT_VALUE', 1);
define('TARDY_VALUE', .5);
define('LEAVEEARLY_VALUE', .5);

// Rolling period in which points drop off.
// Utilize strtotime() formatting.
// http://php.net/manual/en/function.strtotime.php
define('DROPOFF_PERIOD', '+6 month');

// Date format to display dates.
// Utilize date() formatting.
// http://php.net/manual/en/function.date.php
define('DATE_FORMAT', 'l, F jS');

// Drop off date format.
// Utilize DateInterval::format formatting.
// http://php.net/manual/en/dateinterval.format.php
define('DROPOFFDAYS_FORMAT', '%m months, %d days');
