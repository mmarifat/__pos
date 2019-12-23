<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Ignited Datatables
 *
 * This is a wrapper class/library based on the native Datatables server-side implementation by Allan Jardine
 * found at http://datatables.net/examples/data_sources/server_side.html for CodeIgniter
 *
 * @package    CodeIgniter
 * @subpackage libraries
 * @category   library
 * @version    1.15
 * @author     Vincent Bambico <metal.conspiracy@gmail.com>
 *             Yusuf Ozdemir <yusuf@ozdemir.be>
 * @link       http://ellislab.com/forums/viewthread/160896/
 */
class Datatables {

	private $table;
	private $ci;
	private $columns = [];
	private $limit = 25;
	private $joins = [];
	private $add_columns = [];
	private $edit_columns = [];
	private $extra = [];
	private $where = [];
	private $select = array();
	private $unset_columns = array();

	public function __construct() {
		$this->ci = &get_instance();
	}

	public function select($columns) {
		foreach ($this->explode(',', $columns) as $val) {
			$column = trim(preg_replace('/(.*)\s+as\s+(\w*)/i', '$2', $val));
			$this->columns[] = $column;
			$this->select[$column] = trim(preg_replace('/(.*)\s+as\s+(\w*)/i', '$1', $val));
		}
		$this->ci->db->select($columns);
		$this->limit = isset($_POST["iDisplayLength"]) ? ($_POST["iDisplayLength"] < 0) ? [] : [$_POST["iDisplayLength"], $_POST["iDisplayStart"]] : $this->limit;
		$columns = [];
		foreach ($this->columns as $column) {
			$ex = explode(".", $column);
			$columns[] = sizeof($ex) == 2 ? $ex[1] : $column;
		}

		$mDataProp = [];
		for ($i = 0; $i < intval($_POST["iColumns"]); $i++) {
			if (in_array($_POST["mDataProp_$i"], $columns)) {
				$tempColumn = $_POST["mDataProp_$i"];
				$col = 0;
				foreach ($this->columns as $column) {
					$tmp = explode(".", $column);
					if (sizeof($tmp) > 1) {
						$compare = $tmp[1];
					} else {
						$compare = $tmp[0];
					}
					if ($compare == $tempColumn) {
						$col = $column;
					}
				}
				// $this->extra["hghj"][] = $col;
				//  $this->extra["io"][$i] = $_POST["mDataProp_$i"];
				array_push($mDataProp, $col ? $col : $tempColumn);
			}
		}
		// $this->extra["hello"] = $columns;
		$where = [];
		for ($i = 0; $i < intval($_POST["iColumns"]); $i++) {
			if ($_POST["sSearch_$i"]) {
				if (strpos($_POST["sSearch_$i"], "-yadcf_delim-") !== FALSE) {
					$explode = explode("-yadcf_delim-", $_POST["sSearch_$i"]);
					if ($explode[0]) {
						$this->ci->db->where($mDataProp[$i] . ">='" . changeDateFormat($explode[0]) . "'");
					}
					if ($explode[1]) {
						$this->ci->db->where($mDataProp[$i] . "<='" . changeDateFormat($explode[1]) . "'");
					}
					$this->extra["f"] = changeDateFormat($explode[0]);
					$this->extra["t"] = changeDateFormat($explode[1]);
				} else {
					$where[$mDataProp[$i]] = $_POST["sSearch_$i"];
				}
			}
		}
		$this->ci->db->like($where);
		if ($_POST["sSearch"]) {
			foreach ($mDataProp as $col) {
				$whereOr[$col] = $_POST["sSearch"];
			}
			$this->ci->db->or_like($whereOr);
		}


		$orders = [];

		for ($i = 0; $i < intval($_POST["iSortingCols"]); $i++) {
			if (isset($mDataProp[$_POST["iSortCol_$i"]])) {
				$orders[$mDataProp[$_POST["iSortCol_$i"]]] = $_POST["sSortDir_$i"];
			}
		}
		$this->extra["columns"] = $this->columns;
		$this->extra["mdata"] = $mDataProp;
		$this->extra["limit"] = $this->limit;
		foreach ($orders as $key => $sort) {
			$this->ci->db->order_by($key, $sort);
		}
		if ($this->limit) {
			$this->ci->db->limit($this->limit[0], $this->limit[1]);
		}
		return $this;
	}

	public function join($table, $fk, $type = NULL) {
		$this->joins[] = array($table, $fk, $type);
		$this->ci->db->join($table, $fk, $type);
		return $this;
	}

	function where($where) {
		$this->where = $where;
		$this->ci->db->where($where);
		return $this;
	}

	function from($table) {
		$this->table = $table;
		$this->ci->db->from($table);
		return $this;
	}

	function generate() {
		$query = $this->ci->db->get();
		$qs = $this->ci->db->last_query();
		$aaData = [];
		foreach ($query->result_array() as $row_key => $row_val) {
			$aaData[$row_key] = ($this->check_mDataprop()) ? $row_val : array_values($row_val);

			foreach ($this->add_columns as $field => $val) {
				if ($this->check_mDataprop()) {
					$aaData[$row_key][$field] = $this->exec_replace($val, $aaData[$row_key]);
				} else {
					$aaData[$row_key][] = $this->exec_replace($val, $aaData[$row_key]);
				}
			}
			foreach ($this->edit_columns as $modkey => $modval) {
				foreach ($modval as $val) {
					$aaData[$row_key][($this->check_mDataprop()) ? $modkey : array_search($modkey, $this->columns)] = $this->exec_replace($val, $aaData[$row_key]);
				}
			}
			$aaData[$row_key] = array_diff_key($aaData[$row_key], ($this->check_mDataprop()) ? $this->unset_columns : array_intersect($this->columns, $this->unset_columns));

			if (!$this->check_mDataprop()) {
				$aaData[$row_key] = array_values($aaData[$row_key]);
			}
		}


		$output = array(
			'sEcho' => intval($this->ci->input->post('sEcho')),
			"iTotalRecords" => intval($this->countData()),
			"iTotalDisplayRecords" => intval($this->displayRecordsCount($qs)),
			"aaData" => $aaData,
			'sColumns' => $this->columns,
			"post" => $_POST,
			"extra" => $this->extra,
			"query" => $qs
		);
		echo json_encode($output);
	}

	function displayRecordsCount($query) {


		$qry = "";
		if ($this->limit) {
			$length = $this->limit[0];
			$offset = $this->limit[1];
			if ($offset) {
				$qry = preg_replace("/LIMIT\s$offset,\s$length/", "", $query);
				return $this->ci->db->query($qry)->num_rows();
			} else {
				$qry = preg_replace("/LIMIT\s$length/", "", $query);
				return $this->ci->db->query($qry)->num_rows();
			}
		} else {
			return $this->ci->db->query($query)->num_rows();
		}
	}

	function addColumn($column, $content, $match_replacement) {
		$this->add_columns[$column] = array('content' => $content, 'replacement' => $this->explode(',', $match_replacement));
		return $this;
	}

	/* function getCulmnValue($match_replacement) {
	  $column = "val";
	  $content = "$1";
	  $data[$column] = array('content' => $content, 'replacement' => $this->explode(',', $match_replacement));
	  foreach ($data as $field => $val) {
	  $aaData[$row_key][$field] = $this->exec_replace($val, $aaData[$row_key]);
	  }
	  return $aaData;
	  } */

	public function editColumn($column, $content, $match_replacement) {
		$this->edit_columns[$column][] = array('content' => $content, 'replacement' => $this->explode(',', $match_replacement));
		return $this;
	}

	private function countData() {
		$this->ci->db->select('*');
		$this->ci->db->from($this->table);
		$this->ci->db->where($this->where);
		foreach ($this->joins as $val) {
			$this->ci->db->join($val[0], $val[1], $val[2]);
		}
		return $this->ci->db->get()->num_rows();
	}

	private function check_mDataprop() {
		if (!$this->ci->input->post('mDataProp_0')) {
			return FALSE;
		}

		for ($i = 0; $i < intval($this->ci->input->post('iColumns')); $i++) {
			if (!is_numeric($this->ci->input->post('mDataProp_' . $i))) {
				return TRUE;
			}
		}

		return FALSE;
	}

	private function exec_replace($custom_val, $row_data) {
		$replace_string = '';

		if (isset($custom_val['replacement']) && is_array($custom_val['replacement'])) {
			foreach ($custom_val['replacement'] as $key => $val) {
				$sval = preg_replace("/(?<!\w)([\'\"])(.*)\\1(?!\w)/i", '$2', trim($val));

				if (preg_match('/(\w+::\w+|\w+)\((.*)\)/i', $val, $matches) && is_callable($matches[1])) {
					$func = $matches[1];
					$args = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[,]+/", $matches[2], 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

					foreach ($args as $args_key => $args_val) {
						$args_val = preg_replace("/(?<!\w)([\'\"])(.*)\\1(?!\w)/i", '$2', trim($args_val));
						$args[$args_key] = (in_array($args_val, $this->columns)) ? ($row_data[($this->check_mDataprop()) ? $args_val : array_search($args_val, $this->columns)]) : $args_val;
					}

					$replace_string = call_user_func_array($func, $args);
				} elseif (in_array($sval, $this->columns)) {
					$replace_string = $row_data[($this->check_mDataprop()) ? $sval : array_search($sval, $this->columns)];
				} else {
					$replace_string = $sval;
				}

				$custom_val['content'] = str_ireplace('$' . ($key + 1), $replace_string, $custom_val['content']);
			}
		}

		return $custom_val['content'];
	}

	private function explode($delimiter, $str, $open = '(', $close = ')') {
		$retval = array();
		$hold = array();
		$balance = 0;
		$parts = explode($delimiter, $str);

		foreach ($parts as $part) {
			$hold[] = $part;
			$balance += $this->balanceChars($part, $open, $close);

			if ($balance < 1) {
				$retval[] = implode($delimiter, $hold);
				$hold = array();
				$balance = 0;
			}
		}

		if (count($hold) > 0) {
			$retval[] = implode($delimiter, $hold);
		}

		return $retval;
	}

	private function balanceChars($str, $open, $close) {
		$openCount = substr_count($str, $open);
		$closeCount = substr_count($str, $close);
		$retval = $openCount - $closeCount;
		return $retval;
	}

	public function unsetColumn($column) {
		$column = explode(',', $column);
		$this->unset_columns = array_merge($this->unset_columns, $column);
		return $this;
	}

}
