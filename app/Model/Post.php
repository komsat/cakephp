<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('Model', 'Model');
class Post extends Model{
//    public function getAllPosts(){
//        return $this->find('all');
//    }
    public function dashboard(){
        $posts = $this->find('all');
        return $posts;
    }
    
    
//    public function postUpload($imgName, $path, $postId){
//        $data = array();
//        $data['imgname'] = $imgName;
//        $data['path'] = $path;
//        $data['postid'] = $postId;
//        
//        $postDetails = $this->save($data);
//        if(!empty($postDetails)){
//            return true;
//        }else{
//            return false;
//        }
//    }
    
    public function postUpload($title, $description, $tags, $images){
        $data = array();
        $data['title'] = $title;
        $data['description'] = $description;
        $data['tags'] = $tags;
        $data['images'] = $images;
        
        print_r($data);
        
        $userDetails = $this->save($data);
        if(!empty($userDetails)){
            return true;
        }else{
            return false;
        }
    }
}