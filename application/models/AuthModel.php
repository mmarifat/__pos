<?php

/*
 * Author Minhaz Ahamed <mma.rifat66@gmail.com>
 * Dont change without permission
 * All rights reserved @Minhaz Ahamed <mma.rifat66@gmail.com>
 */

/**
 * @property CI_DB $db Description
 */
class AuthModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function loginAuth($email) {
        $this->db->from(TABLE_USERS);
        $this->db->where('email', $email);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return false;
        }
    }
}
