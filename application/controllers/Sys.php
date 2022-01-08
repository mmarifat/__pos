<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property SysModel $sysModel Description
 * @property \CI_Upload $upload Description *
 */
class Sys extends TQ_Controller {

	public $viewPath = "sys/", $modalPath = "sys/";

	public function __construct() {
		parent::__construct();
		$this->ifNotLogin();

		$addedByOwner = [];
		foreach ($this->sysModel->getData(TABLE_USERS, ['deleted' => 0, 'type' => 'owner'], 0, 0, "id,name") as $array) {
			array_push($addedByOwner, (object)["value" => $array->id, "label" => $array->name]);
		}
		$this->data['addedByOwner'] = $addedByOwner;
	}

	public function index() {
		$this->dashboard();
	}

	/*
	 * Dashboard start
	 */

	public function dashboard() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Dashboard", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => "", "page" => __FUNCTION__]
		)];

		$this->data['totalCustomers'] = $this->sysModel->countTotal(TABLE_CUSTOMERS, withOutDeleted());
		$this->data['totalProducts'] = $this->sysModel->countTotal(TABLE_PRODUCTS, withOutDeleted());
		$this->data['totalDue'] = $this->sysModel->getData(TABLE_PAYMENTS, ('DATE(addedDate) = "' . date('Y-m-d', strtotime(changeDateFormat("now"))) . '" AND deleted = 0'), 0, 0, ('sum(due) as due'))[0]->due;
		$this->data['totalUsers'] = $this->sysModel->countTotal(TABLE_USERS, withOutDeleted());
		$this->data['totalSales'] = $this->sysModel->getTotalSum(TABLE_SALES, "grandTotal", ('DATE(date) = "' . date('Y-m-d', strtotime(changeDateFormat("now"))) . '" AND deleted = 0'));
		$this->data['todaysSales'] = $this->todaysSales();
		$this->data['todaysTopTenProducts'] = $this->todaysTopTenProducts();
		$this->viewPath(__FUNCTION__);
	}

	public function todaysSales() {
		$tSales = [];
		$tdate = changeDateFormat("now");
		$dt = $this->sysModel->getDataJoin(TABLE_SALEITEMS, ('DATE(saleDate) BETWEEN "' . date('Y-m-d', strtotime($tdate)) . '" and "' . date('Y-m-d', strtotime($tdate)) . '" AND products.deleted = 0'),
			TABLE_PRODUCTS, ('products.id = saleitems.productID'), (['sum(saleitems.qty)' => 'DESC']), 0,
			('sum(saleitems.orgSubTotal) as orgSubTotal, sum(saleitems.subTotal) as subTotal, sum(saleitems.qty) as qty, products.name as name'),
			0, ('saleitems.productID'));
		if ($dt) {
			foreach ($dt as $pro) {
				array_push($tSales, (object)["label" => $pro->name, "sale" => $pro->subTotal, "qty" => $pro->qty,
					"profit" => ($pro->subTotal - $pro->orgSubTotal)]);
			}
		}
		return $tSales;
	}

	public function todaysTopTenProducts() {
		$topTen = [];
		$tdate = changeDateFormat("now");

		$dt = $this->sysModel->getDataJoin(TABLE_SALEITEMS, ('DATE(saleDate) BETWEEN "' . date('Y-m-d', strtotime($tdate)) . '" and "' . date('Y-m-d', strtotime($tdate)) . '" AND products.deleted = 0'),
			TABLE_PRODUCTS, ('products.id = saleitems.productID'), (['sum(saleitems.qty)' => 'DESC']), 10,
			('sum(saleitems.qty) as qty, products.name as name'), 0, ('saleitems.productID'));

		if ($dt) {
			foreach ($dt as $pro) {
				array_push($topTen, (object)["label" => $pro->name, "value" => $pro->qty]);
			}
		}

		return $topTen;
	}

	/*
	 * Dashboard end
	 *
	 * User start
	 */

	public function users() {
		$this->ifNotOwner();
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Employee", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];
		$this->viewPath("people/users/" . __FUNCTION__);
	}

	public function getUsers() {
		$this->ifNotOwner();
		$dlt = "<p>Are you sure?</p><a class='btn btn-danger po-delete btn-sm p-1 rounded-0' href='" . sysUrl('removeUser/$1') . "'>I am sure</a> <button class='btn pop-close btn-sm rounded-0 p-1'>No</button>";
		$extra = '<a class = "btn btn-link p-0 px-1" modal-toggler="true" data-target="#remoteModal1" data-remote="' . sysUrl("updateUser/$1") . '"><i class="fa fa-edit"></i></a>';
		$extra .= '<button type="button" class="btn btn-link p-0 px-1" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="' . $dlt . '"><i class="fa fa-trash"></i></button>';
		$action = "<div class = \"text-center\">"
			. $extra
			. "</div>";
		$this->datatables->select('id, name, email, type, addedBy, addedTime, ip, deleted')
			->from(TABLE_USERS)
			->addColumn('actions', $action, 'id')
			->where(['id !=' => 1])
			->where(withOutDeleted())
			->generate();
		return true;
	}

	public function checkUserAvalibility() {
		$checkUserName = $this->input->post('name');
		if ($this->sysModel->is_available(TABLE_USERS, ['name' => $checkUserName, 'deleted' => 0])) {
			echo '<label class="text-danger"><span class="glyphicon glyphicon-ok"></span>Username taken. Choose another</label>';
		} else {
			echo '<label class="text-success"><span class="glyphicon glyphicon-remove"></span>Available</label>';
		}
	}

	public function checkEmailAvalibility() {
		$checkUserEmail = $this->input->post('email');
		if ($this->sysModel->is_available(TABLE_USERS, ['email' => $checkUserEmail, 'deleted' => 0])) {
			echo '<label class="text-danger"><span class="glyphicon glyphicon-ok"></span>Email taken. Choose another</label>';
		} else {
			echo '<label class="text-success"><span class="glyphicon glyphicon-remove"></span>Available</label>';
		}
	}

	public function addUser() {
		$this->ifNotOwner();
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run()) {
			$array = ["name", "email", "type"];
			$data = [];
			$themeData = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['password'] = getEncryptedText($this->input->post("password"));
			$data['addedTime'] = getCurrentTime();
			$data['ip'] = getIPAddress();
			$data['addedBy'] = currentUserName();

			$insertUser = $this->sysModel->insertData(TABLE_USERS, $data);

			if ($insertUser) {
				$themeData['userID'] = $insertUser;
				$themeData['topBar'] = "navbar-light bg-white";
				$themeData['sideBar'] = "menu-light";
				$themeData['centerBrand'] = "";
				$themeData['borderMenu'] = "";
				$themeData['footerOption'] = "light";
				$this->sysModel->insertData(TABLE_THEME, $themeData);
				return $this->goToUrl(sysUrl('users'), $data["name"] . " is being registered as " . $data["type"], SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->modalPath("people/users/modal/" . __FUNCTION__);
	}

	public function updateUser($id) {
		$this->ifNotOwner();
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run()) {
			$array = ["name", "email", "type"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['ip'] = getIPAddress();
			if ($this->sysModel->updateData(TABLE_USERS, $data, ["id" => $id])) {
				return $this->goToUrl(sysUrl('users'), $data["name"] . " is being updated as " . $data["type"], SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->data["auth"] = $this->sysModel->getById(TABLE_USERS, ["id" => $id]);
		$this->modalPath("people/users/modal/" . __FUNCTION__);
	}

	public function removeUser($id) {
		$data['deleted'] = 1;
		if ($this->sysModel->softRemoveData(TABLE_USERS, $data, ["id" => $id])) {
			return $this->goToUrl(sysUrl("users"), "Successfully deleted !!!", SUCCESS);
		} else {
			return $this->goToReference("Failed to delete!!!", DANGER);
		}
	}

	public function profile() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => currentUserName(), "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => "", "page" => __FUNCTION__]
		)];

		$this->data["profile"] = $this->sysModel->getById(TABLE_USERS, ["id" => currentUserID()]);
		$this->data["theme"] = $this->sysModel->getById(TABLE_THEME, ["userID" => currentUserID()]);

		$this->form_validation->set_rules('email', 'Email can not be blank', 'required');
		$this->form_validation->set_rules('name', 'Name can not be blank', 'required');
		if ($this->form_validation->run()) {
			$array = ["name", "email"];
			$themeArray = ["topBar", "sideBar", "centerBrand", "colorBrand", "borderMenu", "flippedSideBar", "footerOption"];
			$data = [];
			$themeData = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			foreach ($themeArray as $aa) {
				$themeData[$aa] = $this->input->post($aa);
			}
			if ($this->upload->do_upload('image') != null) {
				$img = $this->upload->data();
				$data["image"] = $img["file_name"];
				if ($this->data["profile"]->image) {
					unlink($img["file_path"] . $this->data["profile"]->image);
				}
			}
			if ($this->input->post('password') != NULL) {
				$data['password'] = getEncryptedText($this->input->post('password'));
			}
			if ($this->sysModel->updateData(TABLE_USERS, $data, ['id' => currentUserID()])) {
				$this->sysModel->updateData(TABLE_THEME, $themeData, ['userID' => currentUserID()]);
				$this->goToUrl(sysUrl("profile"), "Successfully updated profile!!", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->viewPath("people/users/" . __FUNCTION__);
	}


	/*
	 * User end
	 *
	 * Customer start
	 */

	public function customers() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Customers", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];
		$this->viewPath("people/customers/" . __FUNCTION__);
	}

	public function getCustomers() {
		$dlt = "<p>Are you sure?</p><a class='btn btn-danger po-delete btn-sm p-1 rounded-0' href='" . sysUrl('removeCustomer/$1') . "'>I am sure</a> <button class='btn pop-close btn-sm rounded-0 p-1'>No</button>";
		$extra = '<a class = "btn btn-link p-0 px-1" modal-toggler="true" data-target="#remoteModal1" data-remote="' . sysUrl("updateCustomer/$1") . '"><i class="fa fa-edit"></i></a>';
		$extra .= '<button type="button" class="btn btn-link p-0 px-1" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="' . $dlt . '"><i class="fa fa-trash"></i></button>';
		$action = "<div class = \"text-center\">"
			. $extra
			. "</div>";
		$this->datatables->select('id, name, email, contact, address, (select name from `users` where users.id = customers.addedBy) as addedBy, addedTime, deleted')
			->from(TABLE_CUSTOMERS)
			->addColumn('actions', $action, 'id')
			->where(['id !=' => 1, 'deleted' => 0])
			->generate();
		return true;
	}

	public function addCustomer() {
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run()) {
			$array = ["name", "email", "contact", "address"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['addedBy'] = currentUserID();
			$data['addedTime'] = getCurrentTime();
			if ($this->sysModel->insertData(TABLE_CUSTOMERS, $data)) {
				return $this->goToUrl(sysUrl('customers'), $data["name"] . "[" . $data[contact] . "] is being registered as customer", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->modalPath("people/customers/modal/" . __FUNCTION__);
	}

	public function checkContactAvalibility() {
		$checkContactName = $this->input->post('contact');
		if ($this->sysModel->is_available(TABLE_CUSTOMERS, ['contact' => $checkContactName, 'deleted' => 0])) {
			echo '<label class="text-danger"><span class="glyphicon glyphicon-ok"></span>Contact taken. Choose another</label>';
		} else {
			echo '<label class="text-success"><span class="glyphicon glyphicon-remove"></span>Available</label>';
		}
	}

	public function updateCustomer($id) {
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run()) {
			$array = ["name", "email", "contact", "address"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['addedBy'] = currentUserID();
			if ($this->sysModel->updateData(TABLE_CUSTOMERS, $data, ["id" => $id])) {
				return $this->goToUrl(sysUrl('customers'), $data["name"] . " is being updated!", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->data["updateCustomer"] = $this->sysModel->getById(TABLE_CUSTOMERS, ["id" => $id]);
		$this->modalPath("people/customers/modal/" . __FUNCTION__);
	}

	public function removeCustomer($id) {
		$data['deleted'] = 1;
		if ($this->sysModel->softRemoveData(TABLE_CUSTOMERS, $data, ["id" => $id])) {
			return $this->goToUrl(sysUrl("customers"), "Successfully deleted !!!", SUCCESS);
		} else {
			return $this->goToReference("Failed to delete!!!", DANGER);
		}
	}

	/*
	 * Customer end
	 *
	 * Vendors start
	 */

	public function vendors() {
		$this->ifNotOwner();
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Vendors", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];
		$this->viewPath("people/vendors/" . __FUNCTION__);
	}

	public function getVendors() {
		$this->ifNotOwner();
		$dlt = "<p>Are you sure?</p><a class='btn btn-danger po-delete btn-sm p-1 rounded-0' href='" . sysUrl('removeVendor/$1') . "'>I am sure</a> <button class='btn pop-close btn-sm rounded-0 p-1'>No</button>";
		$extra = '<a class = "btn btn-link p-0 px-1" modal-toggler="true" data-target="#remoteModal1" data-remote="' . sysUrl("updateVendor/$1") . '"><i class="fa fa-edit"></i></a>';
		$extra .= '<button type="button" class="btn btn-link p-0 px-1" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="' . $dlt . '"><i class="fa fa-trash"></i></button>';
		$action = "<div class = \"text-center\">"
			. $extra
			. "</div>";
		$this->datatables->select('id, companyName, name, email, contact, address, (select name from `users` where users.id = vendors.addedBy) as addedBy, addedTime, deleted')
			->from(TABLE_VENDORS)
			->addColumn('actions', $action, 'id')
			->where(withOutDeleted())
			->generate();
		return true;
	}

	public function addVendor() {
		$this->ifNotOwner();
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Vendors", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => "vendors"], ["url" => "", "page" => "ADD"]
		)];

		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run()) {
			$array = ["name", "companyName", "email", "contact", "address"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['addedBy'] = currentUserID();
			$data['addedTime'] = getCurrentTime();
			if ($this->sysModel->insertData(TABLE_VENDORS, $data)) {
				return $this->goToUrl(sysUrl('vendors'), $data["name"] . " is being registered as vendor provider!", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->viewPath("people/vendors/" . __FUNCTION__);
	}

	public function updateVendor($id) {
		$this->ifNotOwner();
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run()) {
			$array = ["name", "companyName", "email", "contact", "address"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['addedBy'] = currentUserID();
			if ($this->sysModel->updateData(TABLE_VENDORS, $data, ["id" => $id])) {
				return $this->goToUrl(sysUrl('vendors'), $data["name"] . " is being updated as vendor provider!", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}

		$this->data["updateVendor"] = $this->sysModel->getById(TABLE_VENDORS, ["id" => $id]);
		$this->modalPath("people/vendors/modal/" . __FUNCTION__);
	}

	public function checkVendorContactAvalibility() {
		$checkContactName = $this->input->post('contact');
		if ($this->sysModel->is_available(TABLE_VENDORS, ['contact' => $checkContactName, 'deleted' => 0])) {
			echo '<label class="text-danger"><span class="glyphicon glyphicon-ok"></span>Contact taken. Choose another</label>';
		} else {
			echo '<label class="text-success"><span class="glyphicon glyphicon-remove"></span>Available</label>';
		}
	}

	public function removeVendor($id) {
		$this->ifNotOwner();
		$data['deleted'] = 1;
		if ($this->sysModel->softRemoveData(TABLE_VENDORS, $data, ["id" => $id])) {
			return $this->goToUrl(sysUrl("vendors"), "Successfully deleted !!!", SUCCESS);
		} else {
			return $this->goToReference("Failed to delete!!!", DANGER);
		}
	}

	/*
	 * Vendors end
	 *
	 * Categories start
	 */

	public function categories() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Categories", "bc" => array(
			["url" => sysUrl("index"), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];
		$this->viewPath("categories/" . __FUNCTION__);
	}

	public function getCategories() {
		$dlt = "<p>Are you sure?</p><a class='btn btn-danger po-delete btn-sm p-1 rounded-0' href='" . sysUrl('removeCategory/$1') . "'>I am sure</a> <button class='btn pop-close btn-sm rounded-0 p-1'>No</button>";
		$extra = '<a class = "btn btn-link p-0 px-1" modal-toggler="true" data-target="#remoteModal1" data-remote="' . sysUrl("updateCategory/$1") . '"><i class="fa fa-edit"></i></a>';
		$extra .= '<button type="button" class="btn btn-link p-0 px-1" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="' . $dlt . '"><i class="fa fa-trash"></i></button>';
		$action = "<div class = \"text-center\">"
			. $extra
			. "</div>";
		if (isOwner()) {
			$this->datatables->select('id, image, code, name, (select name from users where users.id = categories.addedBy) as addedBy, addedTime, deleted')
				->from(TABLE_CATEGORIES)
				->addColumn('actions', $action, 'id')
				->where(withOutDeleted())
				->generate();
		} else {
			$this->datatables->select('id, image, code, name, (select name from users where users.id = categories.addedBy) as addedBy, addedTime, deleted')
				->from(TABLE_CATEGORIES)
				->where(withOutDeleted())
				->generate();
		}
		return true;
	}

	public function addCategory() {
		$this->ifNotOwner();
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Categories", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => "Categories"], ["url" => "", "page" => "ADD"]
		)];

		$this->form_validation->set_rules('code', 'Code', 'required');
		if ($this->form_validation->run()) {
			$array = ["code", "name"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['addedBy'] = currentUserID();
			$data['addedTime'] = getCurrentTime();
			if ($this->upload->do_upload('image') != null) {
				$img = $this->upload->data();
				$data["image"] = $img["file_name"];
			}
			if ($this->sysModel->insertData(TABLE_CATEGORIES, $data)) {
				return $this->goToUrl(sysUrl('categories'), "[" . $data["code"] . "] is being registered as category", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->viewPath("categories/" . __FUNCTION__);
	}

	public function checkCodeAvalibility() {
		$checkCode = $this->input->post('code');
		if ($this->sysModel->is_available(TABLE_CATEGORIES, ['code' => $checkCode, 'deleted' => 0])) {
			echo '<label class="text-danger"><span class="glyphicon glyphicon-ok"></span>Code taken. Choose another</label>';
		} else {
			echo '<label class="text-success"><span class="glyphicon glyphicon-remove"></span>Available</label>';
		}
	}

	public function updateCategory($id) {
		$this->ifNotOwner();
		$this->form_validation->set_rules('code', 'Code', 'required');

		$this->data["updateCategory"] = $this->sysModel->getById(TABLE_CATEGORIES, ["id" => $id]);

		if ($this->form_validation->run()) {
			$array = ["code", "name"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			if ($this->upload->do_upload('image') != null) {
				$img = $this->upload->data();
				$data["image"] = $img["file_name"];
				if ($this->data["updateCategory"]->image) {
					unlink($img["file_path"] . $this->data["updateCategory"]->image);
				}
			}
			if ($this->sysModel->updateData(TABLE_CATEGORIES, $data, ["id" => $id])) {
				return $this->goToUrl(sysUrl('categories'), "Category [" . $data["code"] . "] is being updated!!", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->modalPath("categories/modal/" . __FUNCTION__);
	}

	public function removeCategory($id) {
		$this->ifNotOwner();
		$data['deleted'] = 1;
		if ($this->sysModel->softRemoveData(TABLE_CATEGORIES, $data, ["id" => $id])) {
			return $this->goToUrl(sysUrl("categories"), "Successfully deleted !!!", SUCCESS);
		} else {
			return $this->goToReference("Failed to delete!!!", DANGER);
		}
	}

	/*
	 * Categories end
	 *
	 * Products start
	 */

	public function products() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Products", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];

		$category = [];
		$c = $this->sysModel->getData(TABLE_CATEGORIES, withOutDeleted(), 0, 0, "id,code");
		if ($c) {
			foreach ($c as $array) {
				array_push($category, (object)["value" => $array->id, "label" => $array->code]);
			}
		}
		$this->data['category'] = $category;
		$this->viewPath("products/" . __FUNCTION__);
	}

	public function getProducts() {
		$dlt = "<p>Are you sure?</p><a class='btn btn-danger po-delete btn-sm p-1 rounded-0' href='" . sysUrl('removeProduct/$1') . "'>I am sure</a> <button class='btn pop-close btn-sm rounded-0 p-1'>No</button>";
		$extra = '<a class = "btn btn-link p-0 px-1" href="' . sysUrl("addPurchase/$1") . '"><i class="fa fa-plus"></i></a>';
		$extra .= '<a class = "btn btn-link p-0 px-1" href="' . sysUrl("barcode/$1") . '" target="_blank"><i class="fa fa-barcode"></i></a>';
		$extra .= '<a class = "btn btn-link p-0 px-1" modal-toggler="true" data-target="#remoteModal1" data-remote="' . sysUrl("updateProduct/$1") . '"><i class="fa fa-edit"></i></a>';
		$extra .= '<button type="button" class="btn btn-link p-0 px-1" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="' . $dlt . '"><i class="fa fa-trash"></i></button>';
		$action = "<div class = \"text-center\">"
			. $extra
			. "</div>";

		$extra = '<a class = "btn btn-link p-0 px-1" href="' . sysUrl("barcode/$1") . '" target="_blank"><i class="fa fa-barcode"></i></a>';
		$actionStaff = "<div class = \"text-center\">"
			. $extra
			. "</div>";

		if (isOwner()) {
			$this->datatables->select('id, image, code, name, type, (select code from categories where categories.id = products.category) as category, quantity, cost, price, (select name from `users` where users.id = products.addedBy) as addedBy, addedTime, deleted')
				->from(TABLE_PRODUCTS)
				->addColumn('actions', $action, 'id')
				->where(withOutDeleted())
				->generate();
		} else {
			$this->datatables->select('id, image, code, name, type, (select code from categories where categories.id = products.category) as category, quantity, cost, price, (select name from `users` where users.id = products.addedBy) as addedBy, addedTime, deleted')
				->from(TABLE_PRODUCTS)
				->addColumn('actions', $actionStaff, 'id')
				->where(withOutDeleted())
				->generate();
		}
		return true;
	}

	public function barcode($id) {
		$this->navBarSettings(0, 0, 0, 0);
		$this->data['genBarcode'] = $this->sysModel->getById(TABLE_PRODUCTS, ['deleted' => 0, 'id' => $id]);
		$this->viewPath("products/" . __FUNCTION__);
	}

	public function bc($code) {
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$barcodeOptions = array(
			'text' => $code,
			'drawText' => true,
			'barHeight' => 40,
			'factor' => 3.8,
		);
		$rendererOptions = array();
		Zend_Barcode::factory(
			'Code128', 'image', $barcodeOptions, $rendererOptions
		)->render();
	}

	public function addProduct() {
		$this->ifNotOwner();
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Products", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => "Products"], ["url" => "", "page" => "ADD"]
		)];

		$this->form_validation->set_rules('code', 'Code', 'required');
		if ($this->form_validation->run()) {
			$array = ["code", "name", "type", "category", "quantity", "cost", "price"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['addedBy'] = currentUserID();
			$data['addedTime'] = getCurrentTime();
			if ($this->upload->do_upload('image') != null) {
				$img = $this->upload->data();
				$data["image"] = $img["file_name"];
			}
			if ($this->sysModel->insertData(TABLE_PRODUCTS, $data)) {
				return $this->goToUrl(sysUrl('products'), "[" . $data["name"] . "] is being registered as a product!! ", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->viewPath("products/" . __FUNCTION__);
	}

	public function selectCategory() {
		$json = [];
		$data = $this->input->get("q");
		$json = $this->sysModel->getBySelect2('code', $data, TABLE_CATEGORIES);
		echo json_encode($json);
	}

	public function updateProduct($id) {
		$this->ifNotOwner();
		$this->form_validation->set_rules('code', 'Code', 'required');

		$this->data["updateProduct"] = $this->sysModel->getById(TABLE_PRODUCTS, ["id" => $id]);
		$this->data['category'] = $this->sysModel->getSingleData(TABLE_CATEGORIES, ['id' => $this->data['updateProduct']->category]);

		if ($this->form_validation->run()) {
			$array = ["code", "name", "type", "category", "quantity", "cost", "price"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			if ($this->upload->do_upload('image') != null) {
				$img = $this->upload->data();
				$data["image"] = $img["file_name"];
				if ($this->data["updateProduct"]->image) {
					unlink($img["file_path"] . $this->data["updateProduct"]->image);
				}
			}
			if ($this->sysModel->updateData(TABLE_PRODUCTS, $data, ["id" => $id])) {
				return $this->goToUrl(sysUrl('products'), "[" . $data["name"] . "] is being updated!! ", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->modalPath("products/modal/" . __FUNCTION__);
	}

	public function checkProductCodeAvalibility() {
		$checkCode = $this->input->post('code');
		if ($this->sysModel->is_available(TABLE_PRODUCTS, ['code' => $checkCode, 'deleted' => 0])) {
			echo '<label class="text-danger"><span class="glyphicon glyphicon-ok"></span>Code taken. Choose another</label>';
		} else {
			echo '<label class="text-success"><span class="glyphicon glyphicon-remove"></span>Available</label>';
		}
	}

	public function removeProduct($id) {
		$this->ifNotOwner();
		$data['deleted'] = 1;
		if ($this->sysModel->softRemoveData(TABLE_PRODUCTS, $data, ["id" => $id])) {
			return $this->goToUrl(sysUrl("products"), "Successfully deleted !!!", SUCCESS);
		} else {
			return $this->goToReference("Failed to delete!!!", DANGER);
		}
	}

	/*
	 * Products end
	 *
	 * Settings start
	 */

	public function settings() {
		$this->ifNotOwner();
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Settings", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => "", "page" => __FUNCTION__]
		)];
		$se = $this->sysModel->getById(TABLE_SETTINGS, ["id" => "1"]);
		if ($se) {
			$this->data["settings"] = $se;
		} else {
			$this->data["settings"] = (object)['name' => 'Shop', 'address' => 'New', 'image' => 'test', 'favicon' => 'fav'];
		}
		//dnp(uploadUrl($this->data["settings"]->image));

		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run()) {
			$array = ["name", "address"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['updateBy'] = currentUserID();
			$data['addedTime'] = getCurrentTime();

			if ($this->upload->do_upload('image') != null) {
				$img = $this->upload->data();
				$data["image"] = $img["file_name"];
				if ($this->data["settings"]->image) {
					unlink($img["file_path"] . $this->data["settings"]->image);
				}
			}
			if ($this->upload->do_upload('favicon') != null) {
				$img2 = $this->upload->data();
				$data["favicon"] = $img2["file_name"];
				if ($this->data["settings"]->favicon) {
					unlink($img2["file_path"] . $this->data["settings"]->favicon);
				}
			}
			if ($this->sysModel->updateData(TABLE_SETTINGS, $data, ["id" => "1"])) {
				return $this->goToUrl(sysUrl('settings'), "Store settings is being updated", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->viewPath("settings/" . __FUNCTION__);
	}

	/*
	 * Settings end
	 *
	 * Purchase start
	 */

	public function purchases() {
		$this->ifNotOwner();
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Purchases", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];

		$product = [];
		$p = $this->sysModel->getData(TABLE_PRODUCTS, withOutDeleted(), 0, 0, "id,name");
		if ($p) {
			foreach ($p as $array) {
				array_push($product, (object)["value" => $array->id, "label" => $array->name]);
			}
		}
		$this->data['product'] = $product;

		$vendor = [];
		$v = $this->sysModel->getData(TABLE_VENDORS, withOutDeleted(), 0, 0, "id,companyName");
		if ($v) {
			foreach ($v as $array) {
				array_push($vendor, (object)["value" => $array->id, "label" => $array->companyName]);
			}
		}
		$this->data['vendor'] = $vendor;

		$this->viewPath("purchases/" . __FUNCTION__);
	}

	public function getPurchases() {
		$this->ifNotOwner();
		$dlt = "<p>Are you sure?</p><a class='btn btn-danger po-delete btn-sm p-1 rounded-0' href='" . sysUrl('removePurchase/$1') . "'>I am sure</a> <button class='btn pop-close btn-sm rounded-0 p-1'>No</button>";
		$extra = '<a class = "btn btn-link p-0 px-1" modal-toggler="true" data-target="#remoteModal1" data-remote="' . sysUrl("updatePurchase/$1") . '"><i class="fa fa-edit"></i></a>';
		$extra .= '<button type="button" class="btn btn-link p-0 px-1" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="' . $dlt . '"><i class="fa fa-trash"></i></button>';
		$action = "<div class = \"text-center\">"
			. $extra
			. "</div>";
		$this->datatables->select('id, date, reference, (select name from `products` where products.id = purchases.product) as product, total, totalAmount, (select companyName from vendors where vendors.id = purchases.vendor) as vendor, received, (select name from `users` where users.id = purchases.addedBy) as addedBy, addedTime, deleted')
			->from(TABLE_PURCHASES)
			->addColumn('actions', $action, 'id')
			->where(withOutDeleted())
			->generate();
		return true;
	}

	public function addPurchase($id = null) {
		$this->ifNotOwner();
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Purchases", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl("purchases"), "page" => "Purchases"], ["url" => "", "page" => "ADD"]
		)];
		if (isset($id)) {
			if (is_numeric($id)) {
				$this->data["products"] = $this->sysModel->getById(TABLE_PRODUCTS, ["id" => $id, 'deleted' => 0]);
			} else {
				$this->data["products"] = $this->sysModel->getById(TABLE_PRODUCTS, ["id" => urlDecrypt($id), 'deleted' => 0]);
			}
			$this->form_validation->set_rules('date', 'date', 'required');
			$this->form_validation->set_rules('reference', 'reference', 'required');
			if ($this->form_validation->run()) {
				$array = ["date", "reference", "product", "total", "vendor", "received"];
				$data = [];
				foreach ($array as $a) {
					$data[$a] = $this->input->post($a);
				}
				$data['date'] = changeDateFormat($data['date']);
				$data['addedBy'] = currentUserID();
				$data['addedTime'] = getCurrentTime();

				//handle 2nd table
				$getSecondData = $this->sysModel->getById(TABLE_PRODUCTS, ['id' => $data['product']]);
				if ($getSecondData) {
					$secondData['quantity'] = $data['total'] + $getSecondData->quantity;
					$data['totalAmount'] = $data['total'] * $getSecondData->cost;
					$secondData['addedTime'] = getCurrentTime();
				}
				if ($this->sysModel->insertData(TABLE_PURCHASES, $data)) {
					if ($getSecondData) {
						$this->sysModel->updateData(TABLE_PRODUCTS, $secondData, ['id' => $data['product']]);
					}
					return $this->goToUrl(sysUrl('purchases'), "Purchase is being registered and product warehouse is being updated!! ", SUCCESS);
				} else {
					return $this->goToReference("Failed to add to server!!!", DANGER);
				}
			}
			$this->viewPath("purchases/" . __FUNCTION__);
		} else {
			$this->form_validation->set_rules('date', 'date', 'required');
			$this->form_validation->set_rules('reference', 'reference', 'required');
			if ($this->form_validation->run()) {
				$array = ["date", "reference", "product", "total", "vendor", "received"];
				$data = [];
				foreach ($array as $a) {
					$data[$a] = $this->input->post($a);
				}
				$data['date'] = changeDateFormat($data['date']);
				$data['addedBy'] = currentUserID();
				$data['addedTime'] = getCurrentTime();

				//handle 2nd table
				$getSecondData = $this->sysModel->getById(TABLE_PRODUCTS, ['id' => $data['product']]);
				if ($getSecondData) {
					$secondData['quantity'] = $data['total'] + $getSecondData->quantity;
					$data['totalAmount'] = $data['total'] * $getSecondData->cost;
					$secondData['addedTime'] = getCurrentTime();
				}
				if ($this->sysModel->insertData(TABLE_PURCHASES, $data)) {
					if ($getSecondData) {
						$this->sysModel->updateData(TABLE_PRODUCTS, $secondData, ['id' => $data['product']]);
					}
					return $this->goToUrl(sysUrl('purchases'), "Purchase is being registered and product warehouse is being updated!! ", SUCCESS);
				} else {
					return $this->goToReference("Failed to add to server!!!", DANGER);
				}
			}
			$this->viewPath("purchases/apiPurchase");
		}
	}

	public function selectProductForPurchase() {
		$json = [];
		$data = $this->input->get("q");
		$json = $this->sysModel->getBySelect2('name', $data, TABLE_PRODUCTS);
		echo json_encode($json);
	}

	public function selectVendorForPurchase() {
		$json = [];
		$data = $this->input->get("q");
		$json = $this->sysModel->getBySelect2('companyName', $data, TABLE_VENDORS);
		echo json_encode($json);
	}

	public function updatePurchase($id) {
		$this->ifNotOwner();
		$this->data["updatePurchase"] = $this->sysModel->getById(TABLE_PURCHASES, ["id" => $id]);
		$this->data['chVendor'] = $this->sysModel->getSingleData(TABLE_VENDORS, ['id' => $this->data['updatePurchase']->vendor]);
		$this->data['chProduct'] = $this->sysModel->getSingleData(TABLE_PRODUCTS, ['id' => $this->data['updatePurchase']->product]);

		$this->form_validation->set_rules('date', 'date', 'required');
		if ($this->form_validation->run()) {
			$array = ["date", "reference", "product", "total", "vendor", "received"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['date'] = changeDateFormat($data['date']);
			$data['addedBy'] = currentUserID();
			$data['addedTime'] = getCurrentTime();

			//handle 2nd table
			$getSecondData = $this->sysModel->getById(TABLE_PRODUCTS, ['id' => $this->data['updatePurchase']->product]);
			$secondData['quantity'] = $getSecondData->quantity - $data['total'];
			//handle new update table
			$getThirdData = $this->sysModel->getById(TABLE_PRODUCTS, ['id' => $data['product']]);
			$thirdData['quantity'] = $data['total'] + $getThirdData->quantity;
			$thirdData['addedTime'] = getCurrentTime();
			if ($this->sysModel->updateData(TABLE_PURCHASES, $data, ['id' => $id])) {
				$this->sysModel->updateData(TABLE_PRODUCTS, $secondData, ['id' => $this->data['updatePurchase']->product]);
				$this->sysModel->updateData(TABLE_PRODUCTS, $thirdData, ['id' => $data['product']]);
				return $this->goToUrl(sysUrl('purchases'), "Purchase is being updated and product warehouse is being refactored!! ", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->modalPath("purchases/modal/" . __FUNCTION__);
	}

	public function removePurchase($id) {
		$this->ifNotOwner();
		//handle current table
		$getData = $this->sysModel->getById(TABLE_PURCHASES, ['id' => $id]);
		//handle 2nd table
		$getSecondData = $this->sysModel->getById(TABLE_PRODUCTS, ['id' => $getData->product]);
		$secondData['quantity'] = $getSecondData->quantity - $getData->total;
		$data['deleted'] = 1;
		if ($this->sysModel->softRemoveData(TABLE_PURCHASES, $data, ["id" => $id])) {
			$this->sysModel->updateData(TABLE_PRODUCTS, $secondData, ["id" => $getData->product]);
			return $this->goToUrl(sysUrl("purchases"), "Successfully deleted and refactor products!!!", SUCCESS);
		} else {
			return $this->goToReference("Failed to delete!!!", DANGER);
		}
	}

	/*
	 * Purchases end
	 *
	 * Expenses start
	 */

	public function expenses() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Expenses", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => sysUrl(__FUNCTION__), "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];
		$this->viewPath("expenses/" . __FUNCTION__);
	}

	public function getExpenses() {
		$dlt = "<p>Are you sure?</p><a class='btn btn-danger po-delete btn-sm p-1 rounded-0' href='" . sysUrl('removeExpense/$1') . "'>I am sure</a> <button class='btn pop-close btn-sm rounded-0 p-1'>No</button>";
		$extra = '<a class = "btn btn-link p-0 px-1" modal-toggler="true" data-target="#remoteModal1" data-remote="' . sysUrl("updateExpense/$1") . '"><i class="fa fa-edit"></i></a>';
		$extra .= '<button type="button" class="btn btn-link p-0 px-1" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="' . $dlt . '"><i class="fa fa-trash"></i></button>';
		$action = "<div class = \"text-center\">"
			. $extra
			. "</div>";
		$this->datatables->select('id, date, reference, amount, note, (select name from `users` where users.id = expenses.addedBy) as addedBy, addedTime, deleted')
			->from(TABLE_EXPENSES)
			->addColumn('actions', $action, 'id')
			->where(withOutDeleted())
			->generate();
		return true;
	}

	public function addExpense() {
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('reference', 'Reference', 'required');
		if ($this->form_validation->run()) {
			$array = ["date", "reference", "amount", "note"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['date'] = changeDateFormat($data['date']);
			$data['addedBy'] = currentUserID();
			$data['addedTime'] = getCurrentTime();
			if ($this->sysModel->insertData(TABLE_EXPENSES, $data)) {
				return $this->goToUrl(sysUrl('expenses'), $data["reference"] . " is being added as expense!", SUCCESS);
			} else {
				return $this->goToReference("Failed to add to server!!!", DANGER);
			}
		}
		$this->modalPath("expenses/modal/" . __FUNCTION__);
	}

	public function updateExpense($id) {
		$this->data["updateExpense"] = $this->sysModel->getById(TABLE_EXPENSES, ["id" => $id]);

		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('reference', 'Reference', 'required');
		if ($this->form_validation->run()) {
			$array = ["date", "reference", "amount", "note"];
			$data = [];
			foreach ($array as $a) {
				$data[$a] = $this->input->post($a);
			}
			$data['addedBy'] = currentUserID();
			$data['addedTime'] = getCurrentTime();
			if ($this->sysModel->updateData(TABLE_EXPENSES, $data, ["id" => $id])) {
				return $this->goToUrl(sysUrl('expenses'), $data["reference"] . " is being updated as expense!", SUCCESS);
			} else {
				return $this->goToReference("Failed to update to server!!!", DANGER);
			}
		}
		$this->modalPath("expenses/modal/" . __FUNCTION__);
	}

	public function removeExpense($id) {
		$data['deleted'] = 1;
		if ($this->sysModel->softRemoveData(TABLE_EXPENSES, $data, ["id" => $id])) {
			return $this->goToUrl(sysUrl("expenses"), "Successfully deleted !!!", SUCCESS);
		} else {
			return $this->goToReference("Failed to delete!!!", DANGER);
		}
	}

	public function signout() {
		$this->logout();
	}

}