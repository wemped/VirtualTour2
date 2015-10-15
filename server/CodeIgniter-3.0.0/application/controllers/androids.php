<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Androids extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Map');
        $this->load->model('Stop');
    }

    public function maps(){
            $maps = $this->Map->all();
            // var_dump($maps);
            $mask = [
                "success" => true,
                "error" => ""
            ];

            $array = array();
            foreach ($maps as $map) {
                // $map['url'] = "sw.cs.blahblah/csvirtualtour/maps/" .$map['url'] ;
                // $escaped_url = str_replace("/", "\/", $map['url']);
                // $escaped_url = addslashes("sw.cs.blahblah/csvirtualtour/maps/" . $map['src']);
                $map_mask = [
                    "id" => $map['id'],
                    "url" => "http://140.160.162.254/uploads/maps/" . $map['src'],
                    "desc" => $map['title'],
                    "ordering" => $map['position']
                ];
                array_push($array, $map_mask);
            }
            $mask["result"] = $array;
            header('Content-Type: application/json');
            echo json_encode($mask);
    }

    public function stops(){
        $stops = $this->Stop->all_active();
        // var_dump($stops);
        $mask = [
            "success" => true,
            "error" => ""
        ];

        $array = array();
        foreach ($stops as $stop) {
            if ($stop['map_x'] == null){
                $map_x = 0;
                $map_y = 0;
            }else{
                $map_x = $stop['map_x'];
                $map_y = $stop['map_y'];
            }

            $stop_mask = [
                "StopID" => $stop['id'],
                "StopName" => $stop['title'],
                "RoomNumber" => $stop['room'],
                // "StopContent" => $stop['content'],
                "StopX" => $map_x,
                "StopY" => $map_y,
                "StopQRIdentifier" => $stop['qr_id'],
                "StopOrder" => $stop['position'],
                "MapID" => $stop['map_id']
                // "Active" => $stop['active']
            ];
            array_push($array,$stop_mask);
        }
        $stopList = [
            "StopList" => $array
        ];
        $mask["result"] = $stopList;
        // $mask["result"] = $array;
        header('Content-Type: application/json');
        echo json_encode($mask);
    }

    public function stop($id){
        $stop = $this->Stop->get_by_id($id);
        // var_dump($stop);
        $mask = [
            "success" => true,
            "error" => ""
        ];

        $clean_json_content = json_decode($stop['content'],true);
        foreach ($clean_json_content as $key => $val) {
            if ($clean_json_content[$key]['type'] == "img"){
                $clean_json_content[$key]['type'] = "image";
                $clean_json_content[$key]['url'] =  "http://140.160.162.254/uploads/stops/images/" . $val['src'];
                unset($clean_json_content[$key]['src']);
            }elseif ($clean_json_content[$key]['type'] == "vid") {
                $clean_json_content[$key]['type'] = "video";
                $clean_json_content[$key]['url'] = "http://140.160.162.254/uploads/stops/videos/" . $val['src'];
                unset($clean_json_content[$key]['src']);
            }
        }

        if ($stop['active'] == 1){
            $stop['active'] = "yes";
        }else{
            $stop['active'] = "no";
        }

        $stop_mask = [
            "StopID" => $stop['id'],
            "StopName" => $stop['title'],
            "RoomNumber" => $stop['room'],
            "StopContent" => $clean_json_content,
            "StopX" => $stop['map_x'],
            "StopY" => $stop['map_y'],
            "StopQRIdentifier" => $stop['qr_id'],
            "StopOrder" => $stop['position'],
            "MapID" => $stop['map_id'],
            "Active" => $stop['active']
        ];
        $mask['result'] = $stop_mask;
        header('Content-Type: application/json');
        echo json_encode($mask);
    }
}
?>