<?php
    class Product_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function get_product_list() {
            $query = $this->db->get("Product");
            $resultArr = array();
            foreach ($query->result() as $row) {
                $result = ["ID" => $row->ID,"Name" => $row->NAME,"Description" => $row->DESCRIPTION];
                array_push($resultArr,$result);
            }
            return $resultArr;
        }

        public function create_product() {
            $data = array("NAME"=>$this->input->post("name"),"DESCRIPTION"=>$this->input->post("description"));
            return $this->db->insert("Product",$data);
        }

        //To enforce the unique constraint on the product's name
        public function name_exists($name) {
            $query = $this->db->get_where("Product",array("NAME"=>$name));
            if ($query->num_rows() == 0) {
                return false;
            } else return true;
        }

        public function get_product($id) {
            $query = $this->db->get_where("Product",array("ID"=>$id));
            $row = $query->row();
            return ["ID"=>$row->ID,"Name"=>$row->NAME,"Description" => $row->DESCRIPTION];
        }

        public function get_product_name($id) {
            $query = $this->db->get_where("Product",array("ID"=>$id));
            $row = $query->row();
            return $row->NAME;
        }

        public function edit_product() {
            $this->db->set("NAME",$this->input->post("name"));
            $this->db->set("DESCRIPTION",$this->input->post("description"));
            $this->db->where("ID",$this->input->post("productId"));
            return $this->db->update("Product");
        }

        public function product_exists($productId) {
            $query = $this->db->get_where("Product",array("ID"=>$productId));
            if ($query->num_rows() == 0) {
                return false;
            } else return true;
        }

        public function delete_product() {
            $this->db->where("ID",$this->input->post("productId"));
            return $this->db->delete("Product");
        }

    }