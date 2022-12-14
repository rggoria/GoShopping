<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_model extends CI_Model {
    // Constructor
    public function __construct() {
        parent::__construct();
        // Database library
        $this->load->database();
    }

    // Get Order Count (Homepage Module [My Order])
    public function get_order_count($username){
        $query = $this->db->from ('table_order')
            ->where(array(
                'user_username' => $username,
                'order_status' => 'PENDING'
            ))
            ->get();
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->num_rows;
        };
    }

    // Check Order (Order Module [Add Order])
    public function check_order($order){
        extract($order);
        $query = $this->db->from ('table_order')
            ->where(array(
                'user_username' => $user_username,
                'product_name' => $product_name,
                'order_status' => 'PENDING',
            ))
            ->get();
        if($query->row() == NULL) {
            return NULL;         
        } else {
            return $query->row();
        };
    }

    // Add Order (Category Module [Add Order])
    public function add_order($order){
        $this->db->insert('table_order', $order);
    }

    // Get Product Detail (Add Order [Update])
    public function get_product_detail($product){
        $query = $this->db->from ('table_order')
            ->where(array(
                'product_name' => $product,
                'order_status' => 'PENDING'
            ))
            ->get();
        if($query->result() == NULL){
            return NULL;
        }
        else{
            return $query->row();
        }    
    }

    // Update Order (Add Order [Add Order])
    public function update_order($order){
        extract($order);
        $this->db->where(array(
            'order_id' => $order_id,
            'user_username' => $user_username,
            'product_name' => $product_name,
        ));
        $this->db->update('table_order', $order);       
    }

    // Get Orders (List Order View Module [My Cart])
    public function get_orders($username){
        $query = $this->db->select("*")
            ->from ('table_order')
            ->where(array(
                'user_username' => $username,
                'order_status' => 'PENDING'
            ))
            ->order_by("order_date", "asc")
            ->get();
        if($query->result() == NULL){
            return NULL;
        }
        else{
            return$query->result();
        }
    }

    // Get Orders (List Order View Module [My Cart])
    public function edit_order($order){
        $query = $this->db->from('table_order')
        ->where(array(
            'order_id' => $order
        ))
        ->get();
        if ($query->result() == 0) {
            return NULL;
        } else {
            return $query->result();
        }
    }

    // Get Orders (List Order View Module [My Cart])
    public function remove_order($order){
        extract($order);
        $this->db->where(array(
            'order_id' => $order_id,
            'user_username' => $user_username
        ));
        $this->db->update('table_order', $order);
        redirect('Order/cart/');
    }

    // Get Count Total Order (Profile Module [Total Order])
    public function get_count_total_order($username){
        $query = $this->db->from ('table_order')
            ->where(array(
                'user_username' => $username
            ))
            ->get();
        if($query->num_rows() == 0) {
            return NULL;
        } else {
            return $query->num_rows;
        };
    }

    // Success Order (Checkout Module [Success Order])
    public function success_order($username){
        $this->db->where(array(            
            'user_username' => $username,
            'order_status' => 'PENDING',
        ));
        $this->db->update('table_order', array('order_status' => 'SUCCESSFULL'));
    }

    // Admin Order Count (Admin Module [Order Count])
    public function admin_order_count(){
        $query = $this->db->from('table_order')->get();
        if($query->num_rows() == 0) {
            return 0;
        } else {
            return $query->num_rows;            
        };
    }

    // Admin Order List (Admin Module [Order List])
    public function admin_order_list(){
        $query = $this->db->from('table_order')->get();
        if($query->result() == NULL) {
            return NULL;
        } else {
            return $query->result();
        };
    }
}
?>