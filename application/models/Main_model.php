<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model {
    function insertRecord($record){
        if(count($record) > 0){
            // Check user
            $newuser = array(
                "First" => 0,
                "month" => trim($record[0]),
                "year" => trim($record[1]),
                "Mid" => trim($record[2]),
                "Merchant" => trim($record[3]),
                "Transaction" => trim($record[4]),
                "Payment_Volume" => trim($record[5]),
                "Revenue" => trim($record[6]),
                "InterchangeDuesFee" => trim($record[7]),
                "GrossProfit" => trim($record[8]),
                "buy_rate" => '0.00',
                "gateway_fee" => '0.00',
                "buy_rate_valume" => '0.00',
                "merchant_id" => trim($record[9]),

            );

            if($this->db->insert('csv_details', $newuser)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function all() {
        return $users = $this->db->get('csv_details')->result_array();
    }

}