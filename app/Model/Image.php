<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Model', 'Model');
class Image extends Model{
public function postUpload($imgName, $path, $postId){
        echo 'postid             '.$postId;
        $data = array();
        $data['imgname'] = $imgName;
        $data['path'] = $path;
        $data['postid'] = $postId;
        
        $postDetails = $this->save($data);
        if(!empty($postDetails)){
            return true;
        }else{
            return false;
        }
    }
}