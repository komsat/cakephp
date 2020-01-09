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
//                echo "<pre>";
//                print_r($posts);
                $posts = Hash::extract($posts,'{n}.Post');
                $this->set('posts', $posts); // save posts inside view
          }
          
          
            public function create($param=null){
                $formData = $param;
//                print_r($data);
                $count = 0;
                $response= array('status'=>0);
//                $this->autoLayout = false;
                $this->loadModel('Image');
                if(!empty($formData)){
                    echo 'In create method: <pre>';
                print_r($formData);
//  Check whether form has more than 5  elments!
                        if(count($formData) > 5){
                            return $response;
                        }
                        
                        foreach($formData as $data){
                            $file = $data;
                            $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                            $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                            $this->autoRender = false;

                            if(in_array($ext, $arr_ext)){
                                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/upload/' . $file['name']);
    //                            $data['Image']['imgName'] = $file['name'];
                                $path = WWW_ROOT . 'img/upload/' . $file['name'];

                                $postId = "";
                                print_r($data);
                                $success[$count++]=($this->Image->postUpload($file['name'], $path, $postId));
                                if($success){
                                 $response['status'] = 1;
                                 $response['imageId'] = $success;

                                }
                            }
                        
                        }
                    return $response;
                }
    
            }
            public function post(){
                $this->autoRender = false;
                $data = $this->request->data;
//                echo "In post: 1st print<pre>";
//                print_r($data);
        
                $response= array('status'=>0);
                if(!empty($data)){
                    
                    $imageResponse = $this->create($data['newPost']['image']);
                    $this->loadModel('Post');
                    echo "In post: 2nd print: imageResponse from create method<pre>";
//                    print_r($imageResponse);
                    if($imageResponse['status'] == 0){
                        $response['status'] = 1;
                        return json_encode($response);
                    }
                    $data['newPost']['images'] = json_encode($imageResponse['imageId']);
                    $success = $this->Post->postUpload($data['newPost']['title'], $data['newPost']['description'], $data['newPost']['tags'], $data['newPost']['images']);
                    if($success){
                        $response['status'] = 1;
                        $response['message'] = "Post successful";
                    }

                    }
                    return json_encode($response);
            }
}