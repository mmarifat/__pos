<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 11/26/2019 3:37 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property SysModel $sysModel Description
 * @property \CI_Upload $upload Description *
 */
class TQ_Controller extends CI_Controller {

	private $viewInit = "theme/";
	public $viewPath = "", $modalPath = "";
	public $meta = [], $data = [], $navMeta = [];

	public function __construct() {
		parent::__construct();
		$upconfig['upload_path'] = 'uploads/';
		$upconfig["encrypt_name"] = TRUE;
		$upconfig['max_size'] = 1024;
		$upconfig['allowed_types'] = '*';
		$this->upload->initialize($upconfig);
		/* if (isset($_SESSION["user"])) {
		  $this->checkPer($_SESSION["user"]);
		  } */
	}

//	View path dynamic
	public function viewPath($page, $hideContentHeader = false) {
		$this->view($this->viewPath . $page, $hideContentHeader);
	}

	public function view($page, $hideContentHeader = false) {
		$this->data["title"] = isset($this->data["title"]) ? $this->data["title"] : systemName();
		$noti = $this->sysModel->getData(TABLE_PRODUCTS, ['quantity <=' => LOW_STORAGE], ["quantity" => "ASC"], 0, 0, 0, 0);
		if ($noti) {
			$this->data["productNoti"] = $noti;
		} else {
			$this->data["productNoti"] = [(object)['id' => 0, 'name' => 'None', 'quantity' => '0']];
		}

		if (!isset($this->data["navBarSettings"])) {
			$this->navBarSettings();
		}

		$this->setNavMeta($hideContentHeader);
		$passData = array_merge($this->data, ["navMeta" => $this->navMeta], $this->meta);
		$this->load->view($this->viewInit . "header", $passData);
		$this->load->view($this->viewInit . "navbar", $passData);
		$this->load->view($this->viewInit . $page, $passData);
		$this->load->view($this->viewInit . "footer", $passData);
	}

//	Modal path dynamic
	public function modalPath($page) {
		$this->modal($this->modalPath . $page);
	}

	public function modal($page) {
		$passData = array_merge($this->data, $this->meta);
		$this->load->view($this->viewInit . $page, $passData);
	}

	//	Navbar, SlideBar, Alert handle
	private function setNavMeta($hideContentHeader) {
		$this->navMeta["pageTitle"] = isset($this->navMeta["pageTitle"]) ? $this->navMeta["pageTitle"] : "";
		$this->navMeta["bc"] = isset($this->navMeta["bc"]) ? $this->navMeta["bc"] : [["page" => "", "url" => "j"]];
		$this->navMeta["hideContentHeader"] = $hideContentHeader;
	}

	/**
	 * Setting for menubar
	 * @param type $topBar
	 * @param type $slideBar
	 * @return type
	 */
	function navBarSettings($topBar = true, $slideBar = true, $topAlert = true, $mainContentCard = true) {
		$this->data["showNavBar"] = $slideBar;
		$this->data["navBarSettings"] = ["slideBar" => $slideBar, "topBar" => $topBar, "topAlert" => $topAlert, "mainContentCard" => $mainContentCard];
	}

	//	Set alert
	function setAlertMsg($msg = "", $msgType = "") {
		if ($msg) {
			$_SESSION["altMsg"] = $msg;
			$_SESSION["altMsgType"] = $msgType;
		}
	}

//	Url redirection handler
	function goToReference($msg = "", $msgType = "") {
		$this->setAlertMsg($msg, $msgType);
		return redirect($_SERVER["HTTP_REFERER"]);
	}

	function gotoReferrer() {
		return redirect($this->agent->referrer());
	}

	function goToUrl($url, $msg = "", $msgType = "") {
		$this->setAlertMsg($msg, $msgType);
		return redirect($url);
	}

	function someThingWrong() {
		$this->setAlertMsg("Something Wrong!", DANGER);
		return redirect(base_url());
	}


	/**
	 * redirect to login page if not loged in user
	 * @return type
	 */
	function ifLogin() {
		if (currentSession()) {
			return $this->goToUrl(sysUrl(), "Welcome back - " . currentUserName() . " !", INFO);
		}
	}

	function ifNotLogin() {
		if (!currentSession()) {
			$request_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
			return $this->goToUrl(loginUrl() . "?redirect=" . $request_link, "<br>Access proteced- Please Login!!!", DANGER);
		}
	}

	/**
	 * redirect if not admin staff
	 * @return type
	 */
	function ifNotOwner() {
		if (isStaff()) {
			return $this->goToUrl(loginUrl(), "<br>Access protected! Only admin can access", DANGER);
		}
	}

	function ifNotStaff() {
		if (isOwner()) {
			return $this->goToUrl(loginUrl(), "<br>Access protected! Only staff can access", DANGER);
		}
	}

	public function logout() {
		$this->session->unset_userdata('user');
		session_destroy();
		return redirect(site_url());
	}

}
