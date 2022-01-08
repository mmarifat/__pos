<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property SysModel $sysModel Description
 * @property \CI_Upload $upload Description *
 */
class Report extends TQ_Controller {

	public $viewPath = "reports/", $modalPath = "reports/";

	public function __construct() {
		parent::__construct();
		$this->ifNotLogin();
		$this->ifNotOwner();
	}

	public function index() {
		$this->salesReport();
	}

	public function salesReport() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Sales Report", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => reportUrl(), "page" => "Sales"], ["url" => "", "page" => "Report"]
		)];

		$tS = [];

		$fromDate = changeDateFormat("now");
		$toDate = changeDateFormat("now");

		$this->form_validation->set_rules('dateRange', 'Date range needs', 'required');
		if ($this->form_validation->run()) {
			$dateRange = explode('-', $_POST['dateRange']);
			$fromDate = changeDateFormat($dateRange[0]);
			$toDate = changeDateFormat($dateRange[1]);
		}
		$report = $this->sysModel->getDataJoin(TABLE_SALEITEMS, ('DATE(saleitems.saleDate) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND saleitems.deleted = 0'),
			TABLE_PRODUCTS, ('products.id = saleitems.productID'), (['sum(saleitems.qty)' => 'DESC']), 0,
			('sum(saleitems.orgSubTotal) as orgSubTotal, sum(saleitems.subTotal) as subTotal, sum(saleitems.qty) as qty, products.name as name'),
			0, ('saleitems.productID'));

		if ($report) {
			foreach ($report as $it) {
				array_push($tS, ["label" => $it->name, "qty" => $it->qty, "sale" => $it->subTotal, "profit" => ($it->subTotal - $it->orgSubTotal)]);
			}
		} else {
			$this->setAlertMsg("No history for this daterange!!", WARNING);
		}
		$this->data['sales'] = $this->sysModel->getTotalSum(TABLE_SALES, "total", ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$this->data['discount'] = $this->sysModel->getTotalSum(TABLE_SALES, "orderedDiscount", ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$this->data['due'] = $this->sysModel->getTotalSum(TABLE_PAYMENTS, "due", ('DATE(addedDate) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$this->data['purchase'] = $this->sysModel->getTotalSum(TABLE_PURCHASES, "totalAmount", ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$this->data['expense'] = $this->sysModel->getTotalSum(TABLE_EXPENSES, "amount", ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$d = $this->sysModel->getData(TABLE_SALES, ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'), 0, 0, 'sum(grandTotal) as saleTotal, sum(orgCostTotal) as costTotal');
		$this->data['revenue'] = $d[0]->saleTotal - ($d[0]->costTotal + $this->data["due"]);
		$this->data['salesChart'] = $tS;
		$this->viewPath(__FUNCTION__);
	}

	public function cr() {
		$this->customerReport();
	}

	public function customerReport() {
		$this->navMeta = ["active" => __FUNCTION__, "pageTitle" => "Customer Sales Report", "bc" => array(
			["url" => sysUrl(), "page" => currentUserName()], ["url" => reportUrl("cr"), "page" => "Customer"], ["url" => "", "page" => "Sales"]
		)];

		$tS = [];

		$fromDate = changeDateFormat("now");
		$toDate = changeDateFormat("now");

		$this->form_validation->set_rules('dateRange', 'Date range needs', 'required');
		if ($this->form_validation->run()) {
			$dateRange = explode('-', $_POST['dateRange']);
			$fromDate = changeDateFormat($dateRange[0]);
			$toDate = changeDateFormat($dateRange[1]);
		}

		$report = $this->sysModel->getDataJoin(TABLE_SALES, ('DATE(sales.date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND sales.deleted = 0'),
			TABLE_CUSTOMERS, ('customers.id = sales.customerID'), (['sum(sales.grandTotal)' => 'DESC']), 0,
			('sum(sales.grandTotal) as grandTotal, sum(sales.orgCostTotal) as orgCostTotal, sum(sales.item) as item, customers.name as name'),
			0, ('sales.customerID'));
		if ($report) {
			foreach ($report as $it) {
				array_push($tS, ["label" => $it->name, "item" => $it->item, "sale" => $it->grandTotal, "profit" => ($it->grandTotal - $it->orgCostTotal)]);
			}
		} else {
			$this->setAlertMsg("No history for this daterange!!", WARNING);
		}
		$this->data['sales'] = $this->sysModel->getTotalSum(TABLE_SALES, "total", ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$this->data['discount'] = $this->sysModel->getTotalSum(TABLE_SALES, "orderedDiscount", ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$this->data['due'] = $this->sysModel->getTotalSum(TABLE_PAYMENTS, "due", ('DATE(addedDate) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$this->data['purchase'] = $this->sysModel->getTotalSum(TABLE_PURCHASES, "totalAmount", ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$this->data['expense'] = $this->sysModel->getTotalSum(TABLE_EXPENSES, "amount", ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'));
		$d = $this->sysModel->getData(TABLE_SALES, ('DATE(date) BETWEEN "' . date('Y-m-d', strtotime($fromDate)) . '" and "' . date('Y-m-d', strtotime($toDate)) . '" AND deleted = 0'), 0, 0, 'sum(grandTotal) as saleTotal, sum(orgCostTotal) as costTotal');
		$this->data['revenue'] = $d[0]->saleTotal - ($d[0]->costTotal + $this->data["due"]);
		$this->data['customerChart'] = $tS;
		$this->viewPath(__FUNCTION__);
	}
}