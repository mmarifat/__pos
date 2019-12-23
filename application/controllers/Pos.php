<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 11/8/2019 3:29 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property SysModel $sysModel Description
 * @property \CI_Upload $upload Description
 */
class Pos extends TQ_Controller {

	public $viewPath = "pos/", $modalPath = "pos/modal/";

	public function __construct() {
		parent::__construct();
		$this->load->library("pagination");
		$this->ifNotLogin();
	}

	public function index() {
		$this->pos();
	}

	public function pos() {
		$this->navBarSettings(1, 1, 1, 0);
		$this->data["posCus"] = $this->sysModel->getById(TABLE_CUSTOMERS, ["id" => 1, 'deleted' => 0]);
		$this->viewPath(__FUNCTION__);
	}

	public function selectProduct() {
		$json = [];
		$data = $this->input->get("q");
		$json = $this->sysModel->getBySelect2('name', $data, TABLE_PRODUCTS);
		echo json_encode($json);
	}

	public function getProducts() {
		$selectCategory = $this->input->post('selectCategory');
		$searchProduct = $this->input->post('searchProduct');
		$displayHeight = $this->input->post('displayHeight');

		$config = array();
		$config["base_url"] = "#";
		$config["total_rows"] = $this->sysModel->countTotalRows(TABLE_PRODUCTS, $selectCategory, $searchProduct);
		if ($displayHeight > 768) {
			$config["per_page"] = 20;
		} else {
			$config["per_page"] = 16;
		}
		$config["uri_segment"] = 3;
		$config["use_page_numbers"] = TRUE;
		$config["full_tag_open"] = '<ul class="pagination justify-content-center">';
		$config["full_tag_close"] = '</ul>';
		$config["first_tag_open"] = '<li>';
		$config["first_tag_close"] = '</li>';
		$config["last_tag_open"] = '<li>';
		$config["last_tag_close"] = '</li>';
		$config['next_link'] = 'Next';
		$config["next_tag_open"] = '<li>';
		$config["next_tag_close"] = '</li>';
		$config["prev_link"] = "Prev";
		$config["prev_tag_open"] = "<li>";
		$config["prev_tag_close"] = "</li>";
		$config["cur_tag_open"] = "<li class='active'><a href='#'>";
		$config["cur_tag_close"] = "</a></li>";
		$config["num_tag_open"] = "<li>";
		$config["num_tag_close"] = "</li>";
		$config["num_links"] = 1;
		$this->pagination->initialize($config);
		$page = $this->uri->segment(3);
		$start = ($page - 1) * $config["per_page"];

		$output = array(
			'paginationLink' => $this->pagination->create_links(),
			'productList' => $this->sysModel->getProducts(TABLE_PRODUCTS, $config["per_page"], $start, $selectCategory, $searchProduct)
		);
		echo json_encode($output);
	}

	public function selectCustomer() {
		$json = [];
		$data = $this->input->get("q");
		$json = $this->sysModel->getBySelect2('name', $data, TABLE_CUSTOMERS);
		echo json_encode($json);
	}

	public function selectCategory() {
		$json = [];
		$data = $this->input->get("q");
		$json = $this->sysModel->getBySelect2('code', $data, TABLE_CATEGORIES);
		echo json_encode($json);
	}

	public function savePos() {
		//echo json_encode($_POST);

		$this->form_validation->set_rules('customerID', 'Customer ID', 'required');
		$this->form_validation->set_rules('itemCount', 'At least one item', 'required');
		$this->form_validation->set_rules('paymentAmount', 'Payment', 'required');
		if ($this->form_validation->run()) {
			$sales = [];
			$saleItems = [];
			$payment = [];

			//costTotal for sales table
			$orgCostTotal = 0;
			foreach ($_POST['items'] as $id => $item) {
				$oItem = $this->sysModel->getSingleData(TABLE_PRODUCTS, ["id" => $item['id'], "deleted" => 0], ["name" => "ASC"]);
				$orgCostTotal += $oItem->cost * $item['qty'];
			}

			//sales table
			$sales['date'] = getCurrentTime();
			$sales['customerID'] = $_POST['customerID'];
			$sales['reference'] = $_POST['saleReference'];
			$sales['saleNote'] = $_POST['saleNote'];
			$sales['total'] = $_POST['total'];
			$sales['orderedDiscount'] = $_POST['discount'];
			$sales['grandTotal'] = $_POST['grandTotal'];
			$sales['orgCostTotal'] = $orgCostTotal;
			$sales['item'] = $_POST['itemCount'];
			$sales['itemType'] = $_POST['itemType'];
			$sales['staffNote'] = $_POST['staffNote'];
			$sales['addedBy'] = currentUserID();
			$sales['paymentStatus'] = $_POST['paymentAmount'] < $_POST['grandTotal'] ? "Due" : "Paid";
			$saleID = $this->sysModel->insertData(TABLE_SALES, $sales);

			//payment table
			$payment["saleID"] = $saleID;
			$payment["customerID"] = $_POST['customerID'];
			$payment["addedDate"] = getCurrentTime();
			$payment["amount"] = $_POST['paymentAmount'];
			if ($_POST['paymentAmount'] < $_POST['grandTotal']) {
				$payment["due"] = ($_POST['grandTotal'] - $_POST['paymentAmount']);
			}
			$payment["note"] = $_POST['paymentNote'];
			$payment["adBy"] = currentUserID();
			$paymentID = $this->sysModel->insertData(TABLE_PAYMENTS, $payment);

			//saleItems table
			foreach ($_POST['items'] as $id => $item) {
				$saleItems['saleID'] = $saleID;
				$saleItems['saleDate'] = getCurrentTime();
				$saleItems['productID'] = $item['id'];
				$orgItem = $this->sysModel->getSingleData(TABLE_PRODUCTS, ["id" => $item['id'], "deleted" => 0], ["name" => "ASC"]);
				$saleItems['qty'] = $item['qty'];
				$saleItems['cost'] = $orgItem->cost;
				$saleItems['orgSubtotal'] = $orgItem->cost * $item['qty'];
				$saleItems['salePrice'] = $item['price'];
				$saleItems['subTotal'] = $item['subTotal'];
				$saleItems['discount'] = ($orgItem->price * $item['qty']) - $item['subTotal'];
				$saleItems['addBy'] = currentUserID();
				$this->sysModel->insertData(TABLE_SALEITEMS, $saleItems);

				//product table update
				$product['quantity'] = $orgItem->quantity - $item['qty'];
				$this->sysModel->updateData(TABLE_PRODUCTS, $product, ["id" => $item['id']]);
			}
		}
		//invoice handle
		$output = ["saleID" => urlEncrypt($saleID), "paymentID" => urlEncrypt($paymentID)];
		echo json_encode($output);
	}

	public function sales() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Sales", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => __FUNCTION__, "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];
		$this->viewPath("sales");
	}

	public function getSales() {
		$extra = '<a class = "btn btn-link p-0 px-1" href="' . posUrl("invoice/$1") . '" target="_blank"><i class="fa fa-file-invoice"></i></a>';
		$extra .= '<a class = "btn btn-link p-0 px-1" modal-toggler="true" data-target="#remoteModal1" data-remote="' . posUrl("payment/$1") . '"><i class="fa fa-question-circle"></i></a>';
		$action = "<div class = \"text-center\">"
			. $extra
			. "</div>";
		if (isOwner()) {
			$this->datatables->select('sales.id as id, sales.date, customers.name, sales.paymentStatus, sales.reference,
		sales.saleNote, sales.total, sales.orderedDiscount, sales.grandTotal, sales.orgCostTotal, sales.item, sales.staffNote, 
		sales.addedBy, payments.amount, payments.due')
				->from(TABLE_SALES)
				->join(TABLE_CUSTOMERS, 'customers.id = sales.customerID', 'LEFT')
				->join(TABLE_PAYMENTS, 'payments.saleID = sales.id', 'LEFT')
				->addColumn('actions', $action, 'id')
				->where(['sales.deleted' => 0])
				->generate();
		} else {
			$this->datatables->select('sales.id as id, sales.date, customers.name, sales.paymentStatus, sales.reference,
		sales.saleNote, sales.total, sales.orderedDiscount, sales.grandTotal, sales.item, sales.staffNote, 
		sales.addedBy, payments.amount, payments.due')
				->from(TABLE_SALES)
				->join(TABLE_CUSTOMERS, 'customers.id = sales.customerID', 'LEFT')
				->join(TABLE_PAYMENTS, 'payments.saleID = sales.id', 'LEFT')
				->addColumn('actions', $action, 'id')
				->where(['sales.deleted' => 0])
				->generate();
		}
		return true;
	}

	public function invoice($saleID) {
		$this->navBarSettings(0, 0, 1, 0);
		if (is_numeric($saleID)) {
			$sd = $saleID;
		} else {
			$sd = urlDecrypt($saleID);
		}

		$this->data['company'] = $this->sysModel->getById(TABLE_SETTINGS, ["id" => 1]);
		$this->data['sales'] = $this->sysModel->getById(TABLE_SALES, ["id" => $sd, "deleted" => 0]);
		$this->data['customer'] = $this->sysModel->getById(TABLE_CUSTOMERS, ["id" => $this->data['sales']->customerID, "deleted" => 0]);
		$this->data['salesman'] = $this->sysModel->getById(TABLE_USERS, ["id" => $this->data['sales']->addedBy, "deleted" => 0]);
		$this->data['payments'] = $this->sysModel->getById(TABLE_PAYMENTS, ["saleID" => $sd, "deleted" => 0]);
		$this->data["salesItems"] = $this->sysModel->getDataJoin(TABLE_SALEITEMS, ["saleitems.saleID" => $sd, "saleitems.deleted" => 0], TABLE_PRODUCTS, ('saleitems.productID = products.id'));

		$this->data['uriSegment'] = $sd;
		$this->viewPath(__FUNCTION__);
	}

	public function payment($saleID = null) {
		if ($saleID) {
			$duePayment = $this->sysModel->executeCustom("SELECT customers.name , sales.id, sales.date, sales.reference, sales.grandTotal, 
sales.addedBy, sales.itemType,sales.item,sales.total, sales.orderedDiscount,
payments.amount,payments.id as paymentID, payments.due,
customers.address, customers.contact
FROM sales LEFT JOIN customers on customers.id = sales.customerID
LEFT JOIN payments on payments.saleID = sales.id WHERE sales.id = " . $saleID);

			$this->data['duePayment'] = $duePayment[0];
		}

		$this->form_validation->set_rules('due', 'Due amount is required', 'required');
		if ($this->form_validation->run()) {
			$preAmount = $this->input->post('preAmount');
			$preDue = $this->input->post('preDue');
			$sID = $this->input->post('sID');
			$paymentID = $this->input->post('paymentID');
			$due = $this->input->post('due');

			$salesData = [];
			$paymentData = [];

			if ($due > $preDue) {
				$this->goToReference("Due amount can't be excced", WARNING);
			} else {
				$paymentData['amount'] = $preAmount + $due;
				$paymentData['due'] = $preDue - $due;
				$due < $preDue ? $salesData['paymentStatus'] = 'Due' : $salesData['paymentStatus'] = 'Paid';
				if ($this->sysModel->updateData(TABLE_PAYMENTS, $paymentData, ['id' => $paymentID])) {
					$this->sysModel->updateData(TABLE_SALES, $salesData, ['id' => $sID]);
					$this->goToReference("Successfully update due payment", SUCCESS);
				}
			}
		}
		$this->modalPath(__FUNCTION__);
	}

	public function productsSales() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Products Sales", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => __FUNCTION__, "page" => __FUNCTION__], ["url" => "", "page" => "LIST"]
		)];
		$this->viewPath(__FUNCTION__);
	}

	public function getProductsSales() {
		if (isOwner()) {
			$this->datatables->select('saleitems.id as id, saleitems.saleDate, sales.reference, products.name,
		saleitems.qty, saleitems.salePrice, saleitems.subTotal, saleitems.orgSubTotal, saleitems.discount,
		users.name as addBy')
				->from(TABLE_SALEITEMS)
				->join(TABLE_SALES, 'sales.id = saleitems.saleID', 'LEFT')
				->join(TABLE_PRODUCTS, 'products.id = saleitems.productID', 'LEFT')
				->join(TABLE_USERS, 'users.id = saleitems.addBy', 'LEFT')
				->where(['saleitems.deleted' => 0])
				->generate();
		} else {
			$this->datatables->select('saleitems.id as id, saleitems.saleDate, sales.reference, products.name,
		saleitems.qty, saleitems.salePrice, saleitems.subTotal, saleitems.discount,
		users.name as addBy')
				->from(TABLE_SALEITEMS)
				->join(TABLE_SALES, 'sales.id = saleitems.saleID', 'LEFT')
				->join(TABLE_PRODUCTS, 'products.id = saleitems.productID', 'LEFT')
				->join(TABLE_USERS, 'users.id = saleitems.addBy', 'LEFT')
				->where(['saleitems.deleted' => 0])
				->generate();
		}
		return true;
	}
}