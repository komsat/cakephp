<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DashboardsController extends AppController {
            public $components = array('Paginator');
            var $name = 'Dashboard';
            var $uses = array('Post');
            public $paginate = array(
              'limit' => 25,
//              'conditions' => array('status' => '1'),
              'order' => array('Post.id' => 'desc') 
            );

            
            public function dashboard(){
//                  $uid = $this->Session->read('Auth.User.id');//$this->Auth->user('id');
//                  print_r(gettype($uid));
                  $this->paginate = array(
                    'conditions' => array('Post.disabled' => 0),
                    'limit' => 6,
                    'order' => array('Post.id' => 'desc' )
                  );
                  $this->Paginator->settings = $this->paginate;
//                  $this->loadModel ('Post');
//                  $posts = $this->Post->dashboard();
                  $data = $this->Paginator->paginate('Post');
//                
//                  $this->autoLayout = false;
//                  $this->loadModel ('Post');
//                  $posts = $this->Post->dashboard();  // query all posts
                  $imgCount=0;
                  $this->loadModel('Image');

                  $posts = Hash::extract($data,'{n}.Post');
                  
                  foreach($posts as $key=>$value){
                                  $imageIds= json_decode($value['images']);
                                  foreach ($imageIds as $index=>$value){
                                     $imgData =  $this->Image->findById($value);
                                     $posts[$key]['img']['name'][$imgCount++] = $imgData['Image']['name'];

                                  }

                  }
                  
                  $this->set('posts', $posts);   // save posts inside view
            }
          
          
            public function create($param=null){
                $formData = $param;
//                print_r($data);
                $count = 0;
                $response= array('status'=>0);
                $this->loadModel('Image');
                if(!empty($formData)){

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
                                $path = WWW_ROOT . 'img/upload/' . $file['name'];

                                $postId = "";
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
                $response= array('status'=>0);
                print_r($response);
                if(!empty($data)){
                    
                    $imageResponse = $this->create($data['newPost']['image']);
                    $this->loadModel('Post');
                    if($imageResponse['status'] == 0){
                       
                        return json_encode($response);
                    }
                    $data['newPost']['images'] = json_encode($imageResponse['imageId']);
                    $data['newPost']['userid'] = $this->Auth->user('id'); //$this->Session->read('Auth.User.name');
//                    print_r($data['newPost']['userid']);
                    $success = $this->Post->postUpload($data['newPost']['userid'], $data['newPost']['title'], $data['newPost']['description'], $data['newPost']['tags'], $data['newPost']['images']);
                    if($success){
                        
                        $response["status"] = 1;
//                        $response["message"] = "Posted Sucessfully";

                    }

                    }
                    print_r($response);
                    return json_encode($response);
            }
            
            public function search(){
                $data = $this->request->data;
                $response= array();
                $response['status'] = 1;
                $response['message'] = "Hitting search func!";
                                 
                return json_encode($response);
            }
            
            public function profile(){
                $uid = $this->Session->read('Auth.User.id');//$this->Auth->user('id');//
                  $this->paginate = array(
                    'conditions' => array('Post.userid' => $uid),
                    'limit' => 5,
                    'order' => array('Post.id' => 'desc' )
                  );
                  $this->Paginator->settings = $this->paginate;
                  $data = $this->Paginator->paginate('Post');
                  $imgCount=0;
                  $this->loadModel('Image');

                  $posts = Hash::extract($data,'{n}.Post');
                  
                  foreach($posts as $key=>$value){
                                  $imageIds= json_decode($value['images']);
                                  foreach ($imageIds as $index=>$value){
                                     $imgData =  $this->Image->findById($value);
                                     $posts[$key]['img']['name'][$imgCount++] = $imgData['Image']['name'];

                                  }

                  }
                  
                  $this->set('posts', $posts);   // save posts inside view
            }
    
            public function edit(){
                $this->autoRender = false;
            }        

            public function disable(){
                $this->autoRender = false;  //if ctp is not needed for the function
                $this->loadModel('Post');
                $post = $this->Post->findById($id);
            }

            public function delete(){
                $this->autoRender = false;
            }
}