<?php

/*
 * Encryption using salt key
 */
function getEncryptedText($text) {
	$ci = &get_instance();
	return $ci->encryption->encrypt($text);
}

function getDecryptedText($text) {
	$ci = &get_instance();
	return $ci->encryption->decrypt($text);
}

/**
 * For testing purpose- 1
 * @param type $data
 */
function dnd($data) {
	echo "<hr style='border:2px solid blue;'><pre>";
	var_dump($data);
	echo "</pre><hr style='border:2px solid #7d2900;'>";
}

/**
 * For testing purpose- 2
 * @param type $data
 */
function dnp($data) {
	echo "<hr style='border:2px solid blue;'><pre>";
	print_r($data);
	echo "</pre><hr style='border:2px solid #7d2900;'>";
}


/**
 * Time related
 * @param type $date
 * @param type $format
 * @return type
 */
function changeDateFormat($date, $format = "Y-m-d") {
	return date($format, strtotime(str_replace(",", " ", $date)));
}

function changeDateFormatToLong($date, $format = "d M, Y") {
	return date($format, strtotime(str_replace(",", " ", $date)));
}

function convertDate($cuDate, $newFormat = "d-m-Y", $currentFormat = "m/d/Y") {
	$date = DateTime::createFromFormat($currentFormat, $cuDate);
	$newDate = $date->format($newFormat);
	return $newDate;
}

function getCurrentTime() {
	return date("Y-m-d H:i:s", time());
}

function getTimeZone($zoneId = false) {
	$ci = &get_instance();
	if ($zoneId) {
		$ci->utility->timezones[$zoneId];
	} else {
		return $ci->utility->timezones;
	}
}

function getIPAddress() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

//deleted status check
function withDeleted() {
	return ["deleted" => 1];
}

function withOutDeleted() {
	return ["deleted" => 0];
}

//two way url encryption
function urlEncrypt($text) {
	return urlencode(base64_encode($text));
}

function urlDecrypt($text) {
	return base64_decode(urldecode($text));
}

//for invoice page msg
function setAlertMsgFromViewPage($msg = "", $msgType = "") {
	if ($msg) {
		$_SESSION["altMsg"] = $msg;
		$_SESSION["altMsgType"] = $msgType;
	}
}
