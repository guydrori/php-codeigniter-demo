<?php
    class Admin_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function create_user()
        {
            $data = array(
                "USERNAME"=>$this->input->post("username"),
                "PASSWORD"=> password_hash($this->input->post("password"),PASSWORD_DEFAULT),
                "EMAIL"=>$this->input->post("email")
            );
            return $this->db->insert("Admin",$data);
        }

        public function email_check($email) {
            $query = $this->db->get_where("Admin",array("EMAIL"=>$email));

            if ($query->num_rows() == 0) {
                return false;
            } else return true;
        }

        public function username_check($username) {
            $query = $this->db->get_where("Admin",array("USERNAME"=>$username));

            if ($query->num_rows() == 0) {
                return false;
            } else return true;
        }

        //Authenticating users based either on their username, e-mail address, or password
        public function authenticate_username($username,$password) {
            $query = $this->db->get_where("Admin",array("USERNAME"=>$username));
            $row = $query->row();
            return password_verify($password,$row->PASSWORD);
        }

        public function authenticate_email($email,$password) {
            $query = $this->db->get_where("Admin",array("EMAIL"=>$email));
            $row = $query->row();
            return password_verify($password,$row->PASSWORD);
        }

        public function authenticate_id($id,$password) {
            $query = $this->db->get_where("Admin",array("ID"=>$id));
            $row = $query->row();
            return password_verify($password,$row->PASSWORD);
        }

        //Obtaining a user's ID using either his/her username or e-mail address
        public function get_user_id($login) {
            $query = null;
            if (preg_match('/^[\w-.]+@[\w-.]+.[a-zA-Z]+$/',$login)) {
                $query = $this->db->get_where("Admin",array("EMAIL"=>$login));
            } else {
                $query = $this->db->get_where("Admin",array("USERNAME"=>$login));
            }
            $row = $query->row();
            return $row->ID;
        }

        //Random password generator for password reset
        private function randomPassword() {
            $symbols="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $symbols_length = strlen($symbols);
            $password = '';
            for ($i=0; $i<15;$i++) {
                $j = rand(0,$symbols_length);
                $password.=$symbols[$j];
            }
            return $password;
        }

        public function change_password() {
            $this->db->set("PASSWORD",password_hash($this->input->post("newPass"),PASSWORD_DEFAULT)); //Password hashing using PHP API
            $this->db->where("ID",$this->session->userdata("userid"));
            $this->db->update("Admin");
        }

        //Performing password reset and returning new password for the new user. 
        public function reset_password() {
            $password = $this->randomPassword();
            $login = $this->input->post("login");
            $this->db->set("PASSWORD",password_hash($password,PASSWORD_DEFAULT));
            if (preg_match('/^[\w-.]+@[\w-.]+.[a-zA-Z]+$/',$login)) {
                $this->db->where("EMAIL",$login);
            } else {
                $this->db->where("USERNAME",$login);
            }
            $this->db->update("Admin");
            $email = '';
            if (preg_match('/^[\w-.]+@[\w-.]+.[a-zA-Z]+$/',$login)) {
                $email = $login;
            } else {
                $query = $this->db->get_where("Admin",array("USERNAME"=>$login));
                $row = $query->row();
                $email = $row->EMAIL;
            }
            return array("email"=>$email,"password"=>$password);
        }

        public function get_accounts() {
            $query = $this->db->get("Admin");
            $resultArr = array(); 
            foreach($query->result() as $row) {
                $result = ["ID"=>$row->ID,"Username"=>$row->USERNAME,"Email"=>$row->EMAIL];
                array_push($resultArr,$result);
            }
            return $resultArr;
        }

        public function get_user($userId) {
            $query= $this->db->get_where("Admin",array("ID"=>$userId));
            $row = $query->row();
            return ["ID"=>$row->ID,"Username"=>$row->USERNAME,"Email"=>$row->EMAIL];
        }

        public function delete_user() {
            $this->db->where("ID",$this->input->post("userId"));
            return $this->db->delete("Admin");
        }
    }
