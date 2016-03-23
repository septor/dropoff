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
define('DROPOFF_PERIOD', '+6 month');

// Date format to display dates.
// Utilize date() formatting.
define('DATE_FORMAT', 'l, F jS');
