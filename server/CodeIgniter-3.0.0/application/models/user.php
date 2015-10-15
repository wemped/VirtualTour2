<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function login(){
        $query = "SELECT id, username, password, admin
                        FROM users
                        WHERE username = ?";
        $value = array($this->input->post('username'));
        $user = $this->db->query($query,$value) -> row_array();
        if ($user){
            $encryptedPassword = md5($this->input->post('password'));
            if ($user['password'] == $encryptedPassword){
                $this->session->set_userdata(array(
                    'username'=>$user['username'],
                    'user_id'=>$user['id'],
                    'admin'=>$user['admin']
                ));
                return true;
            }else{
                $this->session->set_flashdata('login_error', 'Incorrect password');
                return false;
            }
        }
        $this->session->set_flashdata('login_error', 'Username not found');
        return false;
    }

    public function all(){
        $query = "SELECT id, username, admin
                        FROM users";
        return $this->db->query($query)->result_array();
    }

    public function add(){
        $username = $this->input->post('username');
        $pass = $this->input->post('password');
        $pass_conf = $this->input->post('confirm_password');
        $admin = $this->input->post('admin');
        if ($admin == null){
            $admin = 0;
        }
        if ($this->input->post('admin')){
            $admin = 1;
        }
        if ($pass === $pass_conf){
            if ($this->is_username_unique($username)){
                $query = "INSERT INTO users (username, password, admin, created_at)
                                VALUES (?,?,?,NOW())";
                $values = array($username, md5($pass),$admin);
                $this->db->query($query,$values);
                $this->session->set_flashdata('new_user_succ', "{$username} added succesfully");
                return;
            }else{
                $this->session->set_flashdata('new_user_err', "Username taken");
                return;
            }
        }else{
            $this->session->set_flashdata('new_user_err', "Passwords did not match");
            return;
        }
    }

    public function delete($id){
        $query = "DELETE FROM users
                        WHERE id=?";
        $this->db->query($query,array($id));
    }

    public function change_password(){
        $pass = $this->input->post('new_password');
        $pass_conf = $this->input->post('confirm_password');
        if ($pass_conf === $pass){
            $query = "UPDATE users
                            SET password=?
                            WHERE id=?;";
            $values = array(md5($pass),$this->session->userdata('user_id'));
            $this->db->query($query,$values);
            $this->session->set_flashdata('change_pass_succ', 'Password succesfully changed');
        }else{
            $this->session->set_flashdata('change_pass_err', 'Passwords do not match');
            return;
        }
    }
    function is_username_unique($username){
        $query = "SELECT id FROM users WHERE username =?";
        $users = $this->db->query($query,array($username))->result_array();
        if (sizeof($users) > 0){
            return false;
        }else{
            return true;
        }
    }
}
 ?>