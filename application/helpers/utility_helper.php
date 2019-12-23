<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/30/2019 8:41 PM
 */

/**
 *
 * @param type $uri
 * @return type
 */
function propertyUrl($uri = "") {
	return base_url("property/" . $uri);
}

function uploadUrl($uri = "") {
	return base_url("uploads/" . $uri);
}

/*
 * Setting
 */

function ciInstance() {
	$C = &get_instance();
	$CI = $C->sysModel;
	return $CI;
}

function systemlogoSrc($size = 120) {
	$logo = ciInstance()->getById(TABLE_SETTINGS, ["id" => "1"]);
	return $logo ? uploadUrl($logo->image) : propertyUrl("images/pos.svg");
}

function favicon() {
	$fa = ciInstance()->getById(TABLE_SETTINGS, ["id" => "1"]);
	return $fa ? uploadUrl($fa->favicon) : propertyUrl("images/favicon.ico");
}

function systemName() {
	$n = ciInstance()->getById(TABLE_SETTINGS, ["id" => "1"]);
	return $n ? $n->name : "POS";
}

/*
 *
 * Session user
 */

function currentUserImage() {
	$na = ciInstance()->sysModel->getById(TABLE_USERS, ["id" => currentUserID()]);
	return $na->image != null ? uploadUrl($na->image) : propertyUrl("images/avatar.png");
}

function currentUserName() {
	$nam = ciInstance()->sysModel->getById(TABLE_USERS, ["id" => currentUserID()]);
	return $nam ? $nam->name : 'Shop User';
}

/*
 * Reference
 */
function getReference($table, $field, $reference) {
	$res = ciInstance()->executeCustom("SELECT COUNT(*) as cnt FROM " . $table . " WHERE YEAR(" . $field . ")=YEAR(NOW()) AND MONTH(" . $field . ")=MONTH(NOW())");
	return $reference . '-' . date("ydm", time()) . RandomString(4) . str_pad($res[0]->cnt + 1, 4, "0", STR_PAD_LEFT);;
}

function barcode($table, $field, $reference) {
	$res = ciInstance()->executeCustom("SELECT COUNT(*) as cnt FROM " . $table . " WHERE YEAR(" . $field . ")=YEAR(NOW()) AND MONTH(" . $field . ")=MONTH(NOW())");
	return $reference . date("dm", time()) . RandomString(1) . str_pad($res[0]->cnt + 1, 1, "0", STR_PAD_LEFT);;
}

function RandomString($length) {
	$keys = array_merge(range(0, 9), range('A', 'Z'));
	$key = "";
	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[mt_rand(0, count($keys) - 1)];
	}
	return $key;
}

/*
 * Theme
 */
function topBar() {
	$theme = ciInstance()->getById(TABLE_THEME, ["userID" => currentUserID()]);
	if ($theme) {
		return $theme->topBar ? $theme->topBar : "navbar-light bg-white";
	} else {
		return "navbar-light bg-white";
	}
}

function sideBar() {
	$theme = ciInstance()->getById(TABLE_THEME, ["userID" => currentUserID()]);
	if ($theme) {
		return $theme->sideBar ? $theme->sideBar : "menu-light";
	} else {
		return "menu-light";
	}
}

function centerBrand() {
	$theme = ciInstance()->getById(TABLE_THEME, ["userID" => currentUserID()]);
	if ($theme) {
		return $theme->centerBrand ? $theme->centerBrand : " ";
	} else {
		return " ";
	}
}

function brandNameColor() {
	$theme = ciInstance()->getById(TABLE_THEME, ["userID" => currentUserID()]);
	if ($theme) {
		return $theme->colorBrand ? $theme->colorBrand : " ";
	} else {
		return " ";
	}
}

function borderMenu() {
	$theme = ciInstance()->getById(TABLE_THEME, ["userID" => currentUserID()]);
	if ($theme) {
		return $theme->borderMenu ? $theme->borderMenu : " ";
	} else {
		return " ";
	}
}

function sideBarAlignment() {
	$theme = ciInstance()->getById(TABLE_THEME, ["userID" => currentUserID()]);
	if ($theme) {
		return $theme->flippedSideBar ? $theme->flippedSideBar : " ";
	} else {
		return " ";
	}
}

function footerOption() {
	$theme = ciInstance()->getById(TABLE_THEME, ["userID" => currentUserID()]);
	if ($theme) {
		return $theme->footerOption ? $theme->footerOption : " ";
	} else {
		return " ";
	}
}

/*
 *
 * Link reload
 */
function authUrl($uri = "") {
	return base_url("auth/" . $uri);
}

function loginUrl() {
	return authUrl('login');
}

function posUrl($uri = "") {
	return base_url("pos/" . $uri);
}

function sysUrl($uri = "") {
	return base_url("sys/" . $uri);
}

function reportUrl($uri = "") {
	return base_url("report/" . $uri);
}

/**
 * Check session
 * @return boolean
 */
function currentSession() {
	return isset($_SESSION['user']) ? $_SESSION['user'] : 0;
}

function currentSessionID() {
	return session_id();
}

function currentUserInfo($col) {
	return currentSession()->$col;
}

function currentUserID() {
	return currentSession() ? currentSession()->id : 0;
}

function currentUserType() {
	return currentSession() ? currentSession()->type : 0;
}

function currentUniID() {
	return $_SESSION["uniID"];
}

function isOwner() {
	if (currentUserType() == OWNER) {
		return true;
	}
}

function isStaff() {
	if (currentUserType() == STAFF) {
		return true;
	}
}
