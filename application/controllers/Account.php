<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("admin_model");
        $this->load->library('session');
        $this->load->database();
    }
    
    public function login()
	{
        $this->load->helper('url');
        if ($this->session->has_userdata("userid")) {
            redirect('/products/');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $data["title"] = "Login";
            $this->form_validation->set_rules("login","Username/E-mail address","required|callback_login_check");
            $this->form_validation->set_rules("password","Password","required|callback_password_check");
            $this->form_validation->set_message("required",'{field} is required');
            if ($this->form_validation->run() === FALSE) {
                $this->load->view("templates/header",$data);
                $this->load->view("account/login",$data);
                $this->load->view("templates/footer",$data);       
            } else {
                $this->session->set_userdata("userid",$this->admin_model->get_user_id($this->input->post("login"))); //Information about the currently logged in user is stored inside the session
                redirect("/products/");
            }
        }
    }
    
    public function index() {
        $this->load->helper('url');
        redirect('/account/login');
    }

    //Method to identify a user for both types of accepted input (username and email)
    public function login_check($login) {
        if (preg_match('/^[\w-.]+@[\w-.]+.[a-zA-Z]+$/',$login)) {
            if (strlen($login) > 512) {
                $this->form_validation->set_message("login_check",'The e-mail address can\'t contain more than 512 characters');
                return false;
            }
            if(!$this->admin_model->email_check($login)) {
                $this->form_validation->set_message("login_check",'No account exists with the given e-mail address');
                return false;
            } else return true;
        } else {
            if (strlen($login) > 255) {
                $this->form_validation->set_message("login_check",'The username can\'t contain more than 255 characters');
                return false;
            }
            if(!$this->admin_model->username_check($login)) {
                $this->form_validation->set_message("login_check",'No account exists with the given username');
                return false;
            } else return true;
        }
    }

    //Method to validate password input
    public function password_check($password) {
        if ($this->login_check($this->input->post("login"))) {
            if (preg_match('/^[\w-.]+@[\w-.]+.[a-zA-Z]+$/',$this->input->post("login"))) {
                if (!$this->admin_model->authenticate_email($this->input->post("login"),$password)) {
                    $this->form_validation->set_message("password_check",'Incorrect password');
                    return false;
                } else return true;
            } else {
                if (!$this->admin_model->authenticate_username($this->input->post("login"),$password)) {
                    $this->form_validation->set_message("password_check",'Incorrect password');
                    return false;
                } else return true;
            }
        } else return true;
    }

    //Method for verifying the current password before changing to a new one
    public function password_change_check($password) {
        if (!$this->admin_model->authenticate_id($this->session->userdata("userid"),$password)) {
            $this->form_validation->set_message("password_change_check",'Current password is incorrect');
            return false;
        } else return true;
    }

    public function register() 
    {
        $this->load->helper('url');
        if ($this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $data["title"] = "Registration";
            $this->form_validation->set_rules('username', 'Username', 'required|max_length[255]|is_unique[Admin.USERNAME]');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('email', 'E-mail address', 'required|max_length[512]|regex_match[/^[\w-.]+@[\w-.]+.[a-zA-Z]+$/]|is_unique[Admin.EMAIL]');
            $this->form_validation->set_message("required",'{field} is required');
            $this->form_validation->set_message("max_length",'{field} can\'t have more than {param} characters');
            $this->form_validation->set_message("is_unique",'An account with the given value exists already');
            if ($this->form_validation->run() === FALSE) {
                $this->load->view("templates/header",$data);
                $this->load->view("account/register",$data);
                $this->load->view("templates/footer",$data);            
            } else {
                $this->admin_model->create_user();
                $this->session->set_flashdata('newAccountSuccess', 'true');
                redirect('/account/login');
            }
        }
    }

    public function change_pass() {
        $this->load->helper('url');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $data["title"] = "Change password";
            $this->form_validation->set_rules('currentPass', 'Current password', 'required|callback_password_change_check');
            $this->form_validation->set_rules('newPass', 'New password', 'required');
            $this->form_validation->set_message("required",'{field} is required');
            if ($this->form_validation->run() === FALSE) {
                $this->load->view("templates/header",$data);
                $this->load->view("account/edit_password",$data);
                $this->load->view("templates/footer",$data);            
            } else {
                $this->admin_model->change_password();
                $data["success"] = true;
                $this->load->view("templates/header",$data);
                $this->load->view("account/edit_password",$data);
                $this->load->view("templates/footer",$data);
            }
        }
    }

    public function reset_pass() {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data["title"] = "Password reset";
        $this->form_validation->set_rules("login","Username/E-mail address","required|callback_login_check");
        $this->form_validation->set_message("required",'{field} is required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view("templates/header",$data);
            $this->load->view("account/forgot_password",$data);
            $this->load->view("templates/footer",$data);            
        } else {
            $this->load->library('email');
            $passResetData = $this->admin_model->reset_password();
            $this->email->set_newline("\r\n");
            $this->email->from("test@test","Guy's CodeIgniter Sample");
            $this->email->to($passResetData["email"]);
            $this->email->subject("Password reset");
            $this->email->message("New password: ".$passResetData["password"]);
            if (!$this->email->send()) {
                $this->email->print_debugger();
            }
            $data["success"] = true;
            $this->load->view("templates/header",$data);
            $this->load->view("account/forgot_password",$data);
            $this->load->view("templates/footer",$data);
        }
    }

    public function logout() {
        $this->load->helper('url');
        if ($this->session->has_userdata("userid")) {
            $this->session->unset_userdata("userid");
        }
        redirect('/account/login');
    }

    public function list() {
        $this->load->helper('url');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            $data["title"] = "Administrator accounts";
            $data["users"] = $this->admin_model->get_accounts();
            $data["currentId"] = $this->session->userdata("userid");
            $this->load->view("templates/header",$data);
            $this->load->view("account/list",$data);
            $this->load->view("templates/footer",$data);
        }
    }

    public function delete_user($userId) {
        $this->load->helper('url');
        $this->load->helper('form');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            $data["title"] = "Account deletion";
            $data["user"] = $this->admin_model->get_user($userId);
            $this->load->view("templates/header",$data);
            $this->load->view("account/delete_user",$data);
            $this->load->view("templates/footer",$data);
        }
    }

    //Post method to be invoked by submit form after confirmation
    public function delete_user_post() {
        $this->load->helper('url');
        $this->load->helper('form');
        if (!$this->session->has_userdata("userid")) {
            redirect('/account/login');
        } else {
            if (!$this->input->post("userId")) {
                redirect("/account/list");         
            } else {
                $this->admin_model->delete_user();
                $this->session->set_flashdata('deleteAccountSuccess', 'true');
                redirect('/account/list');
            }
        }
    }
}