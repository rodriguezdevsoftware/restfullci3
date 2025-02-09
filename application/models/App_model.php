<?php defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_model {

    public function get_app($authorization)
    {
        $qr_sql = "
            SELECT * 
              FROM app  
             WHERE authorization = '".trim($authorization)."'
               AND date_expiration >= NOW();";

        return $this->db->query($qr_sql)->row_array();
    }
}