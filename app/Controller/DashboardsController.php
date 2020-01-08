<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DashboardsController extends AppController {

          var $name = 'Dashboard';
          var $uses = array();

//          function index () {
//               $this->set('topPosts', ClassRegistry::init('Post')->getTop());
//               $this->set('recentNews', ClassRegistry::init('News')->getRecent());
//          }
          public function dashboard(){
//                $this->theme = false;
                $this->autoLayout =false;
                $this->loadModel ('Post');
                $posts = $this->Post->dashboard();  // query all posts
                $posts = Hash::extract($posts,'{n}.Post');
                $this->set('posts', $posts); // save posts inside view
          }
          
          
          public function create(){
                $data = $this->request->data;
                
                $response= array('status'=>0);
                $this->autoLayout = false;
                $this->loadModel('Image');
                if(!empty($data)){
                    echo 'sdvdbb<pre>';
                print_r($data);
                    if(!empty($data['Image']['upload']['name'])){
                        
                        $file = $data['Image']['upload'];
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                        $this->autoRender = false;
                                                    echo 'dfvdfbdfbdbsdbdfbdf';

                        if(in_array($ext, $arr_ext)){
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/upload/' . $file['name']);
                            $data['Image']['imgName'] = $file['name'];
                            $path = WWW_ROOT . 'img/upload/' . $file['name'];

                            $postId = "";

                            $success = $this->Image->postUpload($data['Image']['imgName'], $path, $postId);
                            if($success){
                             $response['status'] = 1;
                             $response['message'] = "Upload successfull!";
                            
                            }
                        }
                    }
                    return json_encode($response);
                }
    
    }
}