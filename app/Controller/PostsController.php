<?php

App::uses('AppController', 'Controller');
class PostsController extends AppController{
    public function upload(){
        $data = $this->request->data;
        $response= array('status'=>0);
        $this->autoLayout = false;
        $this->loadModel('Post');
        if(!empty($data)){
            if(!empty($this->request->data['Post']['upload']['name'])){
                $file = $this->request->data['Post']['upload'];
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                $this->autoRender = false;
                if(in_array($ext, $arr_ext)){
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/upload/' . $file['name']);
                    $data['Post']['imgName'] = $file['name'];
                    $path = WWW_ROOT . 'img/upload/' . $file['name'];
                    
                    $postId = "";
                    
                    
                    $success = $this->Post->postUpload($data['Post']['imgName'], $path, $postId);
                    if($success){
                     $response['status'] = 1;
                     $response['message'] = "Upload successfull!";
                     $this->html->image('/var/www/html/cakephp/app/webroot/img/upload/pic1.jpeg');
                    }
                }
            }
            return json_encode($response);
        }
    
    }
}
