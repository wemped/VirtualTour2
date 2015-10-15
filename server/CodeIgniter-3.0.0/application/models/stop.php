<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stop extends CI_Model{
    // function all(){
    //     return $this->db->query("SELECT StopID,StopName,RoomNumber,StopOrder,StopX,StopY,MapID,StopQRIdentifier
    //                                             FROM Stops WHERE Active='yes'")->result_array();
    // }
    function all_active(){
        $query = "SELECT id,title,room,position,map_x,map_y,map_id,qr_id
                         FROM stops
                         WHERE active=1
                         ORDER BY position";
        return $this->db->query($query)->result_array();
    }

    function all_for_map($map_id){
        $query = "SELECT id,title,room,position,map_x,map_y,active,qr_id
                        FROM stops WHERE map_id = ?";
        return $this->db->query($query,array($map_id))->result_array();
    }

    function all_active_for_map($map_id){
        $query = "SELECT id,title,room,position,map_x,map_y,active,qr_id
                        FROM stops
                        WHERE map_id = ? AND active = 1";
        return $this->db->query($query,array($map_id))->result_array();
    }

    function create(){
        $title = $this->input->post('title');
        $room = $this->input->post('room');
        $position = $this->input->post('position');
        $active = 0;
        $map_id = $this->input->post('map');
        if ($title && $room && $position != null && $map_id){
            $query = "INSERT INTO stops (title,room,position,active,map_id)
                            VALUES (?,?,?,?,?)";
            $this->db->query($query,array($title,$room,$position,$active,$map_id));
            return $this->db->insert_id();
        }else{
            $this->session->set_flashdata("add_stop_err", "Please fill out title, room, order, and which map the stop corresponds to");
            return false;
        }
    }

    function get_by_id($id){
        $query = "SELECT * FROM stops WHERE id = ?";
        return $this->db->query($query,array($id))->row_array();
    }

    function edit($id){
        $title = $this->input->post('title');
        $room = $this->input->post('room');
        $position = $this->input->post('position');
        $active = $this->input->post('active');
        $map_id = $this->input->post('map_id');
        $content = $this->input->post('content');
        $values = array($title,$room,$position,$active,$map_id,$content,$id);
        $query = "UPDATE stops
                       SET title=?,room=?,position=?,active=?,map_id=?,content=?
                       WHERE id=?";
        if ($this->db->query($query,$values)){
            $this->session->set_flashdata('edit_stop_info', "Succesfully updated " . $title);
            return true;
        }else{
            $this->session->set_flashdata('edit_stop_info', "Error updating " . $title . ", no changes were made");
            return false;
        }
    }

    function delete($id){
        $query = "DELETE FROM stops WHERE id = ?";
        return $this->db->query($query,array($id));
    }

    function upload_img(){
        $target_dir = "uploads/stops/images/";
        $filename = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $filename;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check){
            // var_dump("here");
            if (file_exists($target_file)){
                $this->session->set_flashdata('upload_error', "File with that name already exists, could not upload");
                return false;
            }else{
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                    $this->session->set_flashdata('upload_error', "File must be a jpg, jpeg, or png");
                    return false;
                }else{
                    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){
                        $this->session->set_flashdata('upload_error', "Upload succesful, but not saved to the stop, please press 'Save' to keep the image");
                        return $filename;
                    }else{
                        $this->session->set_flashdata('upload_error', "Error uploading the image");
                        return false;
                    }
                }
            }
        }else{
            //File is not an image..
            $this->session->set_flashdata('upload_error', "File must be an image");
            return false;
        }
    }

    function upload_vid(){
        // var_dump($_FILES);
        // return false;
        $target_dir = "uploads/stops/videos/";
        $filename = basename($_FILES["vidToUpload"]["name"]);
        $target_file= $target_dir . $filename;
        $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if ($_FILES["vidToUpload"]["type"] == "video/mp4" && $videoFileType == "mp4"){
            if (file_exists($target_file)){
                $this->session->set_flashdata('upload_error', "File with that name already exists, could not upload");
                return false;
            }else{
                if (move_uploaded_file($_FILES["vidToUpload"]["tmp_name"], $target_file)){
                    $this->session->set_flashdata("upload_error", "Upload succesful, but not saved to the stop, please press 'Save' to keep the video");
                    return $filename;
                }else{
                    $this->session->set_flashdata('upload_error', "Error uploading the video");
                    return false;
                }
            }
        }else{
            $this->session->set_flashdata('upload_error', "File must be an mp4");
            return false;
        }
    }
    // function stop_by_id($stop_id){
    //     $query = "SELECT StopID,StopName,RoomNumber,StopOrder,StopX,StopY,MapID,StopQRIdentifier
    //                     FROM Stops WHERE StopID = ?";
    //     return $this->db->query($query,array($stop_id))->row_array();
    // }
}

 ?>