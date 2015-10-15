<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medias extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Media');
    }

    public function all(){
        if ($this->session->userdata('user_id')){
            $viewdata['maps'] = $this->Media->maps();
            // var_dump($viewdata['maps']);
            $viewdata['stop_images'] = $this->Media->stop_images();
            // var_dump($viewdata['stop_images']);
            $viewdata['stop_videos'] = $this->Media->stop_videos();
            // var_dump($viewdata['stop_videos']);
            // var_dump($viewdata);
            $this->load->view('media.php',$viewdata);
            return;
        }else{
            redirect('/');
        }
    }

    public function map_delete($filename,$filetype){
        // var_dump("made it");
        if ($this->session->userdata('user_id')){
            $this->Media->delete_map($filename . "." . $filetype);
            redirect('/media');
        }else{
            redirect('/');
        }
    }

    public function stop_image_delete($filename,$filetype){
        // var_dump("made it");
        if ($this->session->userdata('user_id')){
            $this->Media->delete_stop_image($filename . "." . $filetype);
            redirect('/media');
        }else{
            redirect('/');
        }
    }

    public function stop_video_delete($filename,$filetype){
        // var_dump("made it");
        if ($this->session->userdata('user_id')){
            $this->Media->delete_stop_video($filename . "." . $filetype);
            redirect('/media');
        }else{
            redirect('/');
        }
    }
}