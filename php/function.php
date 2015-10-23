<?php
function getMonth($m){
	switch ($m) {
		case '01':
			$month = "Jan";
			break;
		case '02':
			$month = "Feb";
			break;
		case '03':
			$month = "Mar";
			break;
		case '04':
			$month = "Apr";
			break;
		case '05':
			$month = "May";
			break;
		case '06':
			$month = "Jun";
			break;
		case '07':
			$month = "Jul";
			break;
		case '08':
			$month = "Aug";
			break;
		case '09':
			$month = "Sep";
			break;
		case '10':
			$month = "Oct";
			break;
		case '11':
			$month = "Nov";
			break;
		case '12':
			$month = "Dec";
			break;
	}
	return $month;
}
function getMonthNumeric($m){
	$m = strtolower($m);
	switch($m){
		case 'jan':
			$m = '01';
			break;
		case 'feb':
			$m = '02';
			break;
		case 'mar':
			$m = '03';
			break;
		case 'apr':
			$m = '04';
			break;
		case 'may':
			$m = '05';
			break;
		case 'jun':
			$m = '06';
			break;
		case 'jul':
			$m = '07';
			break;
		case 'aug':
			$m = '08';
			break;
		case 'sep':
			$m = '09';
			break;
		case 'oct':
			$m = '10';
			break;
		case 'nov':
			$m = '11';
			break;
		case 'dec':
			$m = '12';
			break;
	}
	return $m;
}
?>