<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Model', 'Model');
class Image extends Model{
    public function postUpload($imgName, $path, $postId){
//        echo 'postid'.$postId;
        $data = array();
        $data['name'] = $imgName;
        $data['path'] = $path;
        $data['postid'] = $postId;
        
        $postDetails = $this->create($data);
        $this->save();
        if(!empty($postDetails)){
            return $this->getLastInsertId();
        }else{
            return false;
        }
    }
    public function getImage($img){
        $res = $this->findById($img);
        return $res['name'];
    }
}