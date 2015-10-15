<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class iPhones extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Map');
        $this->load->model('Stop');
    }

    public function maps(){
        $maps = $this->Map->all();
        $response = [
            "maps" => $maps,
            "map_img_path" => "http://localhost/uploads/maps/"
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function stops(){
        $stops = $this->Stop->all_active();
        header('Content-Type: application/json');
        echo json_encode($stops);
    }

    public function stops_for_map($map_id){
        $stops = $this->Stop->all_active_for_map();
        header('Content-Type: application/json');
        echo json_encode($stops);
    }

    public function stop($id){
        $stop = $this->Stop->get_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($stop);
    }
}

?>