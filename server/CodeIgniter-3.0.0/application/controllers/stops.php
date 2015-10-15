<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stops extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Stop');
        $this->load->model('Map');
    }

    public function all(){
        // $this->load->model('Stop');
        // $stops = $this->Stop->all();
        // echo json_encode($stops);
        // echo json_encode(array("hello" => "world", "Drake"=>"Wempe"));
    }

    public function add(){
        if ($this->session->userdata('user_id')){
            if ($this->input->post()){
                $id = $this->Stop->create();
                if($id){
                    redirect ('/stops/edit/' . $id);
                }else{
                    $viewdata['maps'] = $this->Map->all();
                    $this->load->view("add_stop",$viewdata);
                    return;
                }
            }else{
                $viewdata['maps'] = $this->Map->all();
                $this->load->view("add_stop",$viewdata);
                return;
            }
        }else{
            redirect('/');
        }
    }

    public function edit($id){
        if ($this->session->userdata('user_id')){
            if ($this->input->post()){
                // var_dump($this->input->post());
                // return;
                $this->session->set_flashdata('upload_error', false);
                // var_dump($this->session->flashdata());
                $this->Stop->edit($id);
                $viewdata['stop'] = $this->Stop->get_by_id($id);
                $viewdata['maps'] = $this->Map->all();
                $viewdata['img_filename'] = false;
                $viewdata['vid_filename'] = false;
                $viewdata['img_dir'] = "/uploads/stops/images/";
                $viewdata['vid_dir'] = "/uploads/stops/videos/";
                unset($_POST);
                $this->load->view("edit_stop", $viewdata);
            }else{
                $viewdata['stop'] = $this->Stop->get_by_id($id);
                $viewdata['maps'] = $this->Map->all();
                $viewdata['img_filename'] = false;
                $viewdata['vid_filename'] = false;
                $viewdata['img_dir'] = "/uploads/stops/images/";
                $viewdata['vid_dir'] = "/uploads/stops/videos/";
                unset($_POST);
                $this->load->view("edit_stop",$viewdata);
                return;
            }
        }else{
            redirect('/');
        }
    }

    public function delete($id){
        if ($this->session->userdata('user_id')){
            $this->Stop->delete($id);
            redirect("/maps");
        }else{
            redirect('/');
        }
    }

    public function for_map($map_id){
        if ($this->session->userdata('user_id')){
            $viewdata['stops'] = $this->Stop->all_for_map($map_id);
            $viewdata['map'] = $this->Map->get_by_id($map_id);
            $viewdata['map_image_path'] = "../../uploads/maps/";
            $this->load->view('stops_for_map',$viewdata);
            return;
        }else{
            redirect('/');
        }


        // echo json_encode($stops);
    }

    public function upload_img($stop_id){
        if ($this->session->userdata('user_id')){
            $img_filename = $this->Stop->upload_img();
            if ($img_filename){
                $viewdata['img_dir'] = "/uploads/stops/images/";
                $viewdata['img_filename'] = $img_filename;
            }else{
               $viewdata['img_filename'] = false;
            }
            $viewdata['vid_dir'] = "/uploads/stops/videos/";
            $viewdata['vid_filename'] = false;
            $viewdata['stop'] = $this->Stop->get_by_id($stop_id);
            $viewdata['maps'] = $this->Map->all();
            unset($_POST);
            $this->load->view("edit_stop",$viewdata);
            return;
        }else{
            redirect('/');
        }
    }

    public function upload_vid($stop_id){
        if ($this->session->userdata('user_id')){
            $vid_filename = $this->Stop->upload_vid();
            if ($vid_filename){
                $viewdata['vid_dir'] = "/uploads/stops/videos/";
                $viewdata['vid_filename'] = $vid_filename;
            }else{
               $viewdata['vid_filename'] = false;
            }
            $viewdata['img_dir'] = "/uploads/stops/images/";
            $viewdata['img_filename'] = false;
            $viewdata['stop'] = $this->Stop->get_by_id($stop_id);
            $viewdata['maps'] = $this->Map->all();
            unset($_POST);
            $this->load->view("edit_stop",$viewdata);
            return;
        }else{
            redirect('/');
        }
    }

    public function stop_by_id($stop_id){
        // $this->load->model('Stop');
        // $stop = $this->Stop->stop_by_id($stop_id);
        // echo json_encode($stops);
    }
}
