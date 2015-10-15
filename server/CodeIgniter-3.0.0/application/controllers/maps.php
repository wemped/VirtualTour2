<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maps extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Map');
    }

    public function index(){
        if ($this->session->userdata('user_id')){
            $viewdata['maps'] = $this->Map->all();
            $viewdata['map_image_path'] = "../../uploads/maps/";
            $this->load->view('maps',$viewdata);
        }else{
            redirect('/');
        }
    }

    public function create(){
        if ($this->session->userdata('user_id')){
            $this->Map->create();
                // var_dump("we did it");

                // var_dump($this->session->flashdata());
            unset($_POST);
            redirect('/maps');
        }else{
            redirect('/');
        }
    }

    public function edit($id){
        if ($this->session->userdata('user_id')){
            if ($this->input->post()){
                if($this->Map->update($id)){
                    $this->session->set_flashdata('edit_info', "Succesfully saved");
                }
                unset($_POST);
                redirect("/maps/edit/{$id}");
            }else{
                $viewdata['map'] = $this->Map->get_by_id($id);
                $this->load->view('edit_map',$viewdata);
            }
        }else{
            redirect('/');
        }
    }

    public function edit_image($id){
        if ($this->session->userdata('user_id')){
            if ($this->Map->update_image($id)){
                $this->session->set_flashdata('edit_info', "Succesfully saved");
            }
            unset($_POST);
            redirect("maps/edit/{$id}");
        }else{
            redirect('/');
        }
    }

    public function delete($id){
        if ($this->session->userdata('user_id')){
            $this->Map->delete($id);
            redirect('/maps');
        }else{
            redirect('/');
        }
    }
}