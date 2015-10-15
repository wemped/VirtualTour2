<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Model{
    public function __construct(){
        parent::__construct();
        // $this->load->library('form_validation');
    }

    public function all(){
        $query = "SELECT * FROM maps ORDER BY position ASC";
        return $this->db->query($query)->result_array();
    }


    public function get_by_id($id){
         $query = "SELECT * FROM maps WHERE id = ?";
         return $this->db->query($query, array($id))->row_array();
    }

    public function update($id){
        $title = $this->input->post('title');
        $position = $this->input->post('order');
        $query = "UPDATE maps
                        SET title = ?,position = ?
                        WHERE id = ?";
        return $this->db->query($query, array($title,$position,$id));
    }

    public function update_image($id){
        $filename = $this->upload();
        if ($filename){
            $query = "UPDATE maps
                            SET src = ?
                            WHERE id = ?";
            return $this->db->query($query,array($filename,$id));
        }else{
            return false;
        }
    }

    public function create(){
        $title = $this->input->post('title');
        $order = $this->input->post('order');
        $filename = $this->upload();
        if ($filename){
            $query = "INSERT INTO maps (src, title, position)
                            VALUES (?,?,?)";
            return $this->db->query($query, array($filename,$title,$order));
        }else{
            return false;
        }
    }

    public function delete($id){
        $query = "DELETE FROM maps
                        WHERE id = ?";
        return $this->db->query($query, array($id));
    }

    public function upload(){
        $target_dir = "./uploads/maps/";
        $filename = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $filename;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // var_dump("the fuck");
        if (isset($_POST["submit"])){
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
                            $this->session->set_flashdata('upload_error', "Upload succesful");
                            return $filename;
                        }else{
                            $this->session->set_flashdata('upload_error', "Error uploading the image");
                            return false;
                        }
                    }
                }
            }else{
                //File is not an image..
                // var_dump("here2");
                $this->session->set_flashdata('upload_error', "File must be an image");
                return false;
            }
        }
    }
}
 ?>