<?php

/**
 * Author S Brinta<brrinta@gmail.com>
 * Email: brrinta@gmail.com
 * Web: https://brinta.me
 * Do not edit file without permission of author
 * All right reserved by S Brinta<brrinta@gmail.com>
 * Created on : Apr 30, 2018, 3:40:29 PM
 */


function convertTime($dec) {
	// start by converting to seconds
	$seconds = ($dec * 3600);
	// we're given hours, so let's get those the easy way
	$hours = floor($dec);
	// since we've "calculated" hours, let's remove them from the seconds variable
	$seconds -= $hours * 3600;
	// calculate minutes left
	$minutes = floor($seconds / 60);
	// remove those from seconds as well
	$seconds -= $minutes * 60;
	// return the time formatted HH:MM:SS
	return lz($hours) . ":" . lz($minutes);
}

// lz = leading zero
function lz($num) {
	return (strlen($num) < 2) ? "0{$num}" : $num;
}

function currentUserPosition() {
	return $_SESSION["position"];
}


function getPermissionDetails($path = 0) {
	$ci = &get_instance();
	return $path ? $ci->brt->permissionColumns[$path] : $ci->brt->permissionColumns;
}

/**
 *
 * @param type $array
 * @param type $value
 * @return type
 */
function removeFromArray($array, $value) {
	if (($key = array_search($value, $array)) !== false) {
		unset($array[$key]);
	}
	return $array;
}

function createColumnsArray($end_column, $first_letters = '') {
	$columns = array();
	$length = strlen($end_column);
	$letters = range('A', 'Z');

	// Iterate over 26 letters.
	foreach ($letters as $letter) {
		// Paste the $first_letters before the next.
		$column = $first_letters . $letter;

		// Add the column to the final array.
		$columns[] = $column;

		// If it was the end column that was added, return the columns.
		if ($column == $end_column) {
			return $columns;
		}
	}

	// Add the column children.
	foreach ($columns as $column) {
		// Don't itterate if the $end_column was already set in a previous itteration.
		// Stop iterating if you've reached the maximum character length.
		if (!in_array($end_column, $columns) && strlen($column) < $length) {
			$new_columns = createColumnsArray($end_column, $column);
			// Merge the new columns which were created with the final columns array.
			$columns = array_merge($columns, $new_columns);
		}
	}

	return $columns;
}

function isAdmin() {
	$session = isset($_SESSION["user"]) ? $_SESSION["user"] : false;
	if ($session) {
		return $session->admin;
	} else {
		return false;
	}
}

function isUser() {
	$session = isset($_SESSION["user"]) ? $_SESSION["user"] : false;
	if ($session) {
		return $session->position == 3 ? true : false;
	} else {
		return false;
	}
}

function clean($str) {
	$str = html_entity_decode($str);
	return preg_replace("/\s|&nbsp;/", '', $str);
}

function sendMail($to, $subject, $message, $from = "info@champteks.com") {
	$ci = &get_instance();
	//$ci->email->set_newline("<br>");
	$ci->email->from($from); // change it to yours
	$ci->email->to($to); // change it to yours
	$ci->email->subject($subject);
	$ci->email->message($message);
	if ($ci->email->send()) {
		return true;
	} else {
		return false;
		//show_error($ci->email->print_debugger());
	}
}

/**
 *
 * @param type $string
 * @param type $action = e/d
 * @return type
 */
function my_crypt($string, $action = 'e') {
	// you may change these values to your own
	$secret_key = 'Champ';
	$secret_iv = '2021';

	$output = false;
	$encrypt_method = "AES-256-CBC";
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	if ($action == 'e') {
		$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
	} else {
		if ($action == 'd') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
	}

	return $output;
}

function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) {
		$string = array_slice($string, 0, 1);
	}
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}
