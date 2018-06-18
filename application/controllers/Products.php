<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("product_model");
        $this->load->library('session');
        $this->load->database();
    }

    public function index() {
        $this->load->helper('url');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            $data["title"] = "Products";
            $data["products"] = $this->product_model->get_product_list();
            $this->load->view("templates/header",$data);
            $this->load->view("products/list",$data);
            $this->load->view("templates/footer",$data);
        }
    }

    public function new() {
        $this->load->helper('url');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $data["title"] = "New product";
            $this->form_validation->set_rules('name','Name','required|callback_name_exists|max_length[255]');
            $this->form_validation->set_rules('description','Description','max_length[2048]');
            $this->form_validation->set_message("required",'{field} is required');
            $this->form_validation->set_message("max_length",'{field} can\'t have more than {param} characters');
            if ($this->form_validation->run() === FALSE) {
                $this->load->view("templates/header",$data);
                $this->load->view("products/new",$data);
                $this->load->view("templates/footer",$data);            
            } else {
                $this->product_model->create_product();
                $this->session->set_flashdata("newProductSuccess",'true');
                redirect('/products/');
            }
        }
    }

    //Callback for ensuring product name uniqueness
    public function name_exists($name) {
        if (!$this->input->post("productId")) {
            if($this->product_model->name_exists($name)) {
                $this->form_validation->set_message("name_exists",'A product with the given name already exists');
                return false;
            } else return true;
        } else {
            if ($name == $this->product_model->get_product_name($this->input->post("productId"))) {
                return true;
            } else {
                if($this->product_model->name_exists($name)) {
                    $this->form_validation->set_message("name_exists",'A product with the given name already exists');
                    return false;
                } else return true;
            }
        }
    }

    public function edit($id) {
        $this->load->helper('url');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else if (!is_numeric($id) || !$this->product_model->product_exists($id)) {
			show_404();
		} else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Name','required|callback_name_exists|max_length[255]');
            $this->form_validation->set_rules('description','Description','max_length[2048]');
            $this->form_validation->set_message("required",'{field} is required');
            $this->form_validation->set_message("max_length",'{field} can\'t have more than {param} characters');
            $data["title"] = "Edit product";
            $data["product"] = $this->product_model->get_product($id);
            $this->load->view("templates/header",$data);
            $this->load->view("products/edit",$data);
            $this->load->view("templates/footer",$data);
        }
    }

    //Edit operation to be invoked only by the form which includes a "hidden" ID parameter
    public function edit_post() {
        $this->load->helper('url');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Name','required|callback_name_exists|max_length[255]');
            $this->form_validation->set_rules('description','Description','max_length[2048]');
            $this->form_validation->set_message("required",'{field} is required');
            $this->form_validation->set_message("max_length",'{field} can\'t have more than {param} characters');
            if ($this->form_validation->run() === FALSE) {
                $data["title"] = "Edit product";
                $data["product"] = $this->product_model->get_product($this->input->post("productId"));
                $this->load->view("templates/header",$data);
                $this->load->view("products/edit",$data);
                $this->load->view("templates/footer",$data);            
            } else {
                $this->product_model->edit_product();
                $this->session->set_flashdata("editProductSuccess",'true');
                redirect('/products/');
            }
        }
    }

    public function delete($id) {
        $this->load->helper('url');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else if (!is_numeric($id) || !$this->product_model->product_exists($id)) {
			show_404();
		} else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $data["title"] = "Delete product";
            $data["product"] = $this->product_model->get_product($id);
            $this->load->view("templates/header",$data);
            $this->load->view("products/delete",$data);
            $this->load->view("templates/footer",$data);  
        }
    }

    //Delete operation to be invoked only by the form which includes a "hidden" ID parameter
    public function delete_post() {
        $this->load->helper('url');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            $this->load->helper('form');
            if (!$this->input->post('productId')) {
                redirect("/products/");
                $this->session->set_flashdata("deleteProductSuccess",'false'); 
            } else {
                $this->product_model->delete_product();
                $this->session->set_flashdata("deleteProductSuccess",'true');
                redirect('/products/');
            }
        }
    }
}