<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/30/2019 9:12 PM
 */


/**
 * @property CI_DB $db Description
 */
class SysModel extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	//universal model
	//getByID
	function getById($table, $where) {
		return $this->db->get_where($table, $where)->row();
	}

	//avalibility check
	function is_available($table, $where) {
		$this->db->where($where);
		$query = $this->db->get($table);
		if ($query->num_rows()) {
			return true;
		} else {
			return false;
		}
	}

	//insert
	function insertData($table, $data) {
		$this->db->insert($table, $data);
		$insertID = $this->db->insert_id();
		return $insertID;
	}

	//update
	function updateData($table, $data, $where) {
		return $this->db->update($table, $data, $where);
	}

	//SoftRemove
	function softRemoveData($table, $data, $where) {
		return $this->db->update($table, $data, $where);
	}

	//remove
	function removeData($table, $where) {
		return $this->db->delete($table, $where);
	}

	//select2
	function getBySelect2($field, $data, $table) {
		$this->db->like($field, $data);
		$this->db->where('deleted', 0);
		$query = $this->db->select('id,' . $field . ' as text')
			->limit(10)
			->get($table);
		return $query->result();
	}

	/**
	 * all mix
	 * @param type $table
	 * @param type $where
	 * @param type $order
	 * @param type $limit
	 * @param type $select
	 * @return boolean
	 */
	function getData($table, $where = 0, $order = 0, $limit = 0, $select = 0, $offSet = 0, $groupBy = 0) {
		if ($select) {
			$this->db->select($select);
		} else {
			$this->db->select('*');
		}
		$this->db->from($table);
		if ($where) {
			$this->db->where($where);
		}
		if ($order) {
			foreach ($order as $key => $sort) {
				$this->db->order_by($key, $sort);
			}
		}
		if ($offSet) {
			$this->db->limit($limit, $offSet);
		} else {
			if ($limit) {
				$this->db->limit($limit);
			}
		}
		if ($groupBy) {
			$this->db->group_by($groupBy);
		}
		$query = $this->db->get();
		if ($limit) {
			if ($query->num_rows()) {
				return $query->result();
			}
			return [];
		}
		if ($query->num_rows()) {
			return $query->result();
		}
	}

	/**
	 * all mix join
	 * @param type $table
	 * @param type $where
	 * @param type $order
	 * @param type $limit
	 * @param type $select
	 * @return boolean
	 */
	function getDataJoin($table, $where = 0, $joinTable = 0, $join = 0, $order = 0, $limit = 0, $select = 0, $offSet = 0, $groupBy = 0) {
		if ($select) {
			$this->db->select($select);
		} else {
			$this->db->select('*');
		}
		$this->db->from($table);
		if ($where) {
			$this->db->where($where);
		}
		if ($order) {
			foreach ($order as $key => $sort) {
				$this->db->order_by($key, $sort);
			}
		}
		if ($offSet) {
			$this->db->limit($limit, $offSet);
		} else {
			if ($limit) {
				$this->db->limit($limit);
			}
		}
		if ($groupBy) {
			$this->db->group_by($groupBy);
		}
		if ($joinTable) {
			$this->db->join($joinTable, $join);
		}
		$query = $this->db->get();
		if ($limit) {
			if ($query->num_rows()) {
				return $query->result();
			}
			return [];
		}
		if ($query->num_rows()) {
			return $query->result();
		}
	}

	/**
	 *
	 * @param type $table
	 * @param type $where
	 * @param type $order
	 * @param type $select
	 * @return boolean
	 */
	function getSingleData($table, $where = 0, $order = 0, $select = 0) {
		if ($select) {
			$this->db->select($select);
		} else {
			$this->db->select('*');
		}
		$this->db->from($table);
		if ($where) {
			$this->db->where($where);
		}
		if ($order) {
			foreach ($order as $key => $sort) {
				$this->db->order_by($key, $sort);
			}
		}

		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->row();
		}
		return false;
	}

	/**
	 *
	 * @param type $table
	 * @param type $where
	 * @param type $order
	 * @param type $limit
	 * @param type $select
	 * @return boolean
	 */
	function getDataLike($table, $where = 0, $order = 0, $limit = 0, $select = 0, $offSet = 0) {
		if ($select) {
			$this->db->select($select);
		} else {
			$this->db->select('*');
		}
		$this->db->from($table);
		if ($where) {
			//foreach ($where as $key => $sort) {
			$this->db->like($where);
			//}
		}
		if ($order) {
			foreach ($order as $key => $sort) {
				$this->db->order_by($key, $sort);
			}
		}
		if ($offSet) {
			$this->db->limit($limit, $offSet);
		} else {
			if ($limit) {
				$this->db->limit($limit);
			}
		}
		$query = $this->db->get();
		if ($limit) {
			if ($query->num_rows()) {
				return $query->result();
			}
			return [];
		}
		if ($query->num_rows()) {
			return $query->result();
		}
		return [];
	}

	/**
	 * total()
	 * @param type $table
	 * @param type $where
	 * @param type $select
	 * @return boolean
	 */
	function countTotal($table, $where = null) {
		if ($where) {
			$this->db->where($where);
		}
		$this->db->from($table);
		return $this->db->count_all_results();
	}

	/**
	 * sum()
	 * @param type $table
	 * @param type $where
	 * @param type $select
	 * @return boolean
	 */
	function getTotalSum($table, $sum, $where) {
		$this->db->select_sum($sum);
		if ($where) {
			$this->db->where($where);
		}
		$result = $this->db->get($table)->row();
		if ($result->$sum == 0) {
			return 0;
		} else {
			return $result->$sum;
		}
	}

	/**
	 * custom
	 * @param type $query
	 * @return std class
	 */
	function executeCustom($query) {
		$quy = $this->db->query($query);
		return $quy->result();
	}

	/*
	 * AjaxLiveSearch
	 */
	function ajaxLiveSearch($query, $table, $field1, $field2) {
		$this->db->select("*");
		$this->db->from($table);
		if ($query != '') {
			$this->db->like($field1, $query);
			$this->db->or_like($field2, $query);
		}
		$this->db->order_by('name', 'DESC');
		return $this->db->get();
	}

	/*
	 * count all rows
	 * @param type $table
	 * @param type $where
	 * @param type $like
	 */
	function countTotalRows($table, $where = null, $like = null) {
		$this->db->select("*");
		$this->db->from($table);
		if ($where) {
			$this->db->where(["category" => $where]);
		}
		if ($like) {
			$this->db->like(["name" => $like]);
		}
		$this->db->where(withOutDeleted());
		$q = $this->db->get();
		return $q->num_rows();
	}

	/*
	 * get products
	 * @param type $table
	 * @param type $limit
	 * @param type $start
	 * @param type $where
	 * @param type $like
	 */
	function getProducts($table, $limit, $start, $where = null, $like = null) {
		$output = '';
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where(["quantity >" => 0]);
		if ($where) {
			$this->db->where(["category" => $where]);
		}
		if ($like) {
			$this->db->like(["name" => $like]);
			$this->db->or_like(["code" => $like]);
		}
		$this->db->where(withOutDeleted());
		$this->db->order_by("name", "ASC");
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if ($query->result()) {
			foreach ($query->result() as $pro) {
				$output .= ' <div onclick="addProduct(' . $pro->id . ',this)"
                         data-name=' . $pro->name . '
                         data-price=' . $pro->price . '
                         data-sqty=' . $pro->quantity . '
                         id="pro' . $pro->id . '"
                         class="col-md-3 px-1 my-1" style="min-height: 120px; max-height: 120px; height:120px;">
                        <div class="card w-100 my-1" style="height: 100%">
                            <div class="card-body p-1 text-center">
                                <div class="img-fluid">
                                    <img src=' . uploadUrl($pro->image ?? "../property/images/no-img.png") . ' alt=' . $pro->code . '
                                         width="70vh" height=50vh">
                                </div>
                                <br> 
                                <span>' . $pro->name . '<br></span>
                                <span class="badge badge-dark">C' . $pro->cost . '</span>
                                <span id="storage" class="' . ($pro->quantity < LOW_STORAGE ? ($pro->quantity < CRITICAL_STORAGE ? "badge badge-danger" : "badge badge-warning") : "badge badge-success") . '">' . $pro->quantity . '</span>
                            </div>
                        </div>
                    </div>';
			}
			return $output;
		} else {
			$output .= '<span class="text-danger text-uppercase">No products found</span>';
			return $output;
		}
	}

}