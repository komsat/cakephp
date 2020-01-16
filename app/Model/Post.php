<?php


App::uses('Model', 'Model');
class Post extends Model{
//    public function getAllPosts(){
//        return $this->find('all');
//    }

    
    public function dashboard(){
        $posts = $this->find('all');//, array('order'=>'id desc')); //, 'limit'=>'6'
        return $posts;
    }
    
    public function postUpload($userid ,$title, $description, $tags, $images){
        $data = array();
        $data['userid'] = $userid;
        $data['title'] = $title;
        $data['description'] = $description;
        $data['tags'] = $tags;
        $data['images'] = $images;
        
//        print_r($data);
        
        $postDetails = $this->save($data);      //userDetails
        if(!empty($postDetails)){
            return true;
        }else{
            return false;
        }
    }
    
    public function postEdit($title, $description, $tags, $images, $id){
        $data = array();
        $data['title'] = $title;
        $data['description'] = $description;
        $data['tags'] = $tags;
        $data['images'] = $images;
        $data['id'] = $id;
        
        $editDetails = $this->save($data);
        
        if(!empty($editDetails)){
            return true;
        }else{
            return false;
        }
    }
}