<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User');
    }

    public function index(){
        $this->load->view('login');
    }

    public function login(){
        if ($this->input->post()){
            if ($this->User->login()){
                redirect('/home');
            }
        }
        $this->load->view('login');
        return;
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('/');
    }

    public function home(){
        if ($this->session->userdata('user_id')){
            $this->load->view('home');
            return;
        }
        redirect('/');
    }

    public function change_password(){
        if ($this->session->userdata('user_id')){
            if ($this->input->post()){
                $this->User->change_password();
                unset($_POST);
                $this->load->view('change_password');
                return;
            }else{
                $this->load->view('change_password');
                return;
            }
        }else{
            redirect('/');
        }
    }

    public function staff(){
        if ($this->session->userdata('user_id')){
            $viewdata["staff"] = $this->User->all();
            $this->load->view('staff',$viewdata);
            return;
        }else{
            redirect('/');
        }
    }

    public function add(){
        if ($this->session->userdata('user_id')){
            $this->User->add();
            $viewdata["staff"] = $this->User->all();
            redirect('staff');
            return;
        }else{
            redirect('/');
        }
    }

    public function delete($id){
        if ($this->session->userdata('admin') == 1){
            $this->User->delete($id);
            redirect('staff');
            return;
        }else{
            redirect('/');
        }
    }
}