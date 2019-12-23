<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 12/4/2019 12:09 PM
 */


class sdo extends TQ_Controller {

	public function index() {
		$data['name'] = 'Owner';
		$data['email'] = 'owner@gmail.com';
		$data['password'] = getEncryptedText('2021');
		$data['type'] = 'owner';
		if ($this->sysModel->getById(TABLE_USERS, ['email' => $data['email']])) {
			$this->goToUrl(loginUrl(), "<br>" . $data['email'] . ' is already registered as owner and password is ' . getDecryptedText($data['password']), WARNING);
		} else {
			$userID = $this->sysModel->insertData(TABLE_USERS, $data);
			if ($userID) {
				$themeData['userID'] = $userID;
				$themeData['topBar'] = "navbar-light bg-white";
				$themeData['sideBar'] = "menu-light";
				$themeData['centerBrand'] = "";
				$themeData['borderMenu'] = "";
				$themeData['footerOption'] = "light";
				$this->sysModel->insertData(TABLE_THEME, $themeData);

				$cus['name'] = 'Walk-In-Customer';
				$cus['addedBy'] = $userID;
				$this->sysModel->insertData(TABLE_CUSTOMERS, $cus);

				$sett['updateBy'] = $userID;
				$this->sysModel->insertData(TABLE_SETTINGS, $sett);

				$this->goToUrl(loginUrl(), "<br>" . $data['email'] . ' is registered as owner and password is ' . getDecryptedText($data['password']), SUCCESS);
			}
		}

	}

	public function t() {
		$defNoti = [(object)['id' => 0, 'name' => 'None', 'quantity' => '0']];
		dnp($defNoti);
	}
}