<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Model{

    public function maps(){
        $file_names = scandir("uploads/maps");
        $results = array();
        foreach ($file_names as $file) {
            if ($file != "." && $file != ".." && $file != ".DS_Store"){
                $image = array();
                $image['filename'] = $file;
                $query = "SELECT * FROM maps WHERE src=?";
                $connected = $this->db->query($query,array($image['filename'])) -> row_array();
                // var_dump($connected);
                if ($connected == null){
                    $image['deletable'] = true;
                    $image['connected'] = null;
                }else{
                    $image['deletable'] = false;
                    $image['connected'] = $connected['title'];
                    // $image['id'] = $connected['id'];
                }
                $image['src'] = "uploads/maps/" . $file;
                array_push($results, $image);
            }
        }
        return $results;
    }

    public function stop_images(){
        $file_names = scandir("uploads/stops/images");
        $images = array();
        foreach ($file_names as $image) {
            if ($image != "." && $image != ".." && $image != ".DS_Store"){
                $images[$image] = null;
            }
        }
        $results = array();
        $query = "SELECT id,title,content FROM stops";
        $stops = $this->db->query($query) -> result_array();
        foreach ($stops as $stop) {
            $contents = json_decode($stop['content'],true);
            foreach ($contents as $content) {
                if ($content['type'] == 'img'){
                    $src = str_replace("/uploads/stops/images/", "", $content['src']);
                    foreach ($images as $key => $value) {
                        if ($key == $src){
                            $images[$key] = array();
                            $images[$key]["title"] = $stop['title'];
                            $images[$key]["stop_id"] = $stop['id'];
                            // $images[$key] = $stop['title'];
                        }
                    }
                }
            }
            foreach ($images as $file => $connected) {
                $image = array();
                $image['src'] = "uploads/stops/images/" . $file;
                $image['filename'] = $file;
                if ($connected == null){
                    $image['deletable'] = true;
                    $image['connected'] = null;
                }else{
                    $image['deletable'] = false;
                    $image['connected'] = $connected['title'];
                    $image['stop_id'] = $connected['stop_id'];
                }
                array_push($results,$image);
            }

        }
        return $results;
    }

    public function stop_videos(){
        $file_names = scandir("uploads/stops/videos");
        $images = array();
        foreach ($file_names as $image) {
            if ($image != "." && $image != ".." && $image != ".DS_Store"){
                $images[$image] = null;
            }
        }
        $results = array();
        $query = "SELECT id,title,content FROM stops";
        $stops = $this->db->query($query) -> result_array();
        foreach ($stops as $stop) {
            $contents = json_decode($stop['content'],true);
            foreach ($contents as $content) {
                if ($content['type'] == 'vid'){
                    $src = str_replace("/uploads/stops/videos/", "", $content['src']);
                    foreach ($images as $key => $value) {
                        if ($key == $src){
                            $images[$key] = array();
                            $images[$key]["title"] = $stop['title'];
                            $images[$key]["stop_id"] = $stop['id'];
                            // $images[$key] = $stop['title'];
                        }
                    }
                }
            }
            foreach ($images as $file => $connected) {
                $image = array();
                $image['src'] = "uploads/stops/videos/" . $file;
                $image['filename'] = $file;
                if ($connected == null){
                    $image['deletable'] = true;
                    $image['connected'] = null;
                }else{
                    $image['deletable'] = false;
                    $image['connected'] = $connected['title'];
                    $image['stop_id'] = $connected['stop_id'];
                }
                array_push($results,$image);
            }
        }
        return $results;
    }

    public function delete_map($filename){
        return unlink("uploads/maps/" . $filename);
    }

    public function delete_stop_image($filename){
        return unlink("uploads/stops/images/" . $filename);
    }

    public function delete_stop_video($filename){
        return unlink("uploads/stops/videos/" . $filename);
    }

}