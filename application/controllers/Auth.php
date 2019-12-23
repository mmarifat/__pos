<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/30/2019 8:34 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property AuthModel $authModel Description
 */
class Auth extends TQ_Controller {

	public $viewPath = "auth/", $modalPath = "auth/modal/";

	public function __construct() {
		parent::__construct();
		$this->load->model("authModel");
	}


	function password() {
		dnp(getEncryptedText('2021'));
	}

	function index() {
		$this->ifLogin();
		$this->login();
	}

	function login() {
		$this->navBarSettings(0, 0, 1,1);
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');

		if ($this->form_validation->run()) {
			$email = $this->input->post("email");
			$pass = $this->input->post("password");
			if ($user = $this->authModel->loginAuth($email)) {
				if (getDecryptedText($user->password) == $pass) {
					$user = (array)$user;
					unset($user["password"]);
					//dnp($user);
					$this->session->sess_expiration = '60';
					$this->session->sess_expire_on_close = 'true';
					$this->session->set_userdata("user", (object)$user);
					$this->goToUrl(sysUrl(), "Login Succeed! Welcome " . currentUserName() . "! Your are logged in as " . currentUserType() . "!", SUCCESS);
				} else {
					$this->goToReference("<br>Password not matched", DANGER);
				}
			} else {
				$this->goToReference("<br>User not exists", DANGER);
			}
		}
		$this->viewPath(__FUNCTION__);
	}
}
