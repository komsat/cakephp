<?php

App::uses('AppController', 'Controller');

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
//                print_r($this->request->data);  
                
                $this->Session->write('orderName', '0');
                $this->Session->write('orderDate', '0');
                $this->loadModel('Post');
                $id = $this->request->pass;
                $order1 = 'desc';
                $order2 = 'desc';
                if($id){
//                    print_r($id);
                    if($id[0]==1){  //1 for sort by userid
                        if($this->Session->read('orderName') == 0){
                            $order1 = 'asc';
                            $this->Session->write('orderName', '1');
                        }else{
                            $order1 = 'desc';
                            $this->Session->write('orderName', '0');
                        }
                    }elseif($id[0]==0){
                        if($this->Session->read('orderDate') == 0){
                            $order2 = 'asc';
                            $this->Session->write('orderDate', '1');
                        }else{
                            $order2 = 'desc';
                            $this->Session->write('orderDate', '0');
                        }
                    }
                }
                  
//                  print_r($this->request['url']);
                  if(isset($this->request['url']['search'])){ //$this->request->is("ajax")
                    
                    $options['joins'] = array(
                        array('table' => 'users',
                            'alias' => 'User',
                            'type' => 'inner',
                            'conditions' => array(
                                'Post.userid = User.id'
                            )
                        )
                    );
                    $options['conditions'] = array(
                        'User.email LIKE' => '%'.$this->request['url']['search'].'%'
                    );
                    $postsUser = $this->Post->find('all', $options);
                    $postsUser = Hash::extract($postsUser, '{n}.Post.userid');
//                    echo "<pre>";
//                    print_r($postsUser);
                      
                    $this->paginate = array(
                        'conditions' => array('Post.disabled' => 0, 'OR'=>array(array('Post.title LIKE' => '%'.$this->request['url']['search'].'%'),array('Post.description LIKE' => '%'.$this->request['url']['search'].'%'),array('Post.tags LIKE' => '%'.$this->request['url']['search'].'%'), array('Post.userid' => $postsUser))),
                        'limit' => 6,
                        'order' => array('Post.id' => $order1, 'Post.created' => $order2)
                    );
                      
                  }else{
                      $this->paginate = array(
                        'conditions' => array('Post.disabled' => 0),
                        'limit' => 6,
                        'order' => array('Post.id' => $order1, 'Post.created' => $order2)
                      );
                  }
                  
                  $this->Paginator->settings = $this->paginate;
                  
                  $data = $this->Paginator->paginate('Post');
//                
//                  $this->autoLayout = false;
//                  $this->loadModel ('Post');
//                  $posts = $this->Post->dashboard();  // query all posts
//                  echo "<pre>";
//                  print_r($data);
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
                  
                  $this->loadModel('User');
                  
                  foreach($posts as $key=>$value){
                      $data = $this->User->findById($value["userid"]);
                      $posts[$key]["username"] = $data['User']['name']; //set value of users name, after fetching from users table
                  } 
                  $this->set('posts', $posts);   // save posts inside view
            }
            
            
            
//            public function sort(){

//            }
          
          
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
//                print_r($response);
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
//                    print_r($response);
                    return json_encode($response);
            }
            
//            public function search(){
//                $data = $this->request->data;
//                $response= array();
//                $response['status'] = 1;
//                $response['message'] = "Hitting search func!";
//                                 
//                return json_encode($response);
//            }
            
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
//                $this->autoRender = false;
                  $this->loadModel('Post');
                  $id = $this->request->params['pass'];
//                  print_r($id);
                $posts = $this->Post->findById($id);
                $this->set('posts', $posts);
               
                if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {  //alternatively use: is(array('post', 'put'))
                    $data = $this->request->data;
                    $response= array('status'=>0);
//                    $this->Post->id = $id;
                    if(!empty($data)){
                    
                    $data['editPost']['id']=$id[0];//$posts['Post']["id"];
//                    print_r($data);
                    $success = $this->Post->postEdit($data['editPost']['title'], $data['editPost']['description'], $data['editPost']['tags'], $data['editPost']['id']);
                    if($success){
                        $this->Session->setFlash(__('The Post has been edited.'));
                        $response['status'] = 1;
                        $response['message'] = "Registered successfully";
                    }else {
                        $this->Session->setFlash(__('The Post could not be edited. Please, try again.'));
                    }

                    }
                    return json_encode($response);
                }
                
                
            }        

            public function disable(){
                $this->autoRender = false;  //if ctp is not needed for the function
                $this->loadModel('Post');
                $id = $this->request->pass;     //can be fetched using $_GET as well
//                $post = $this->Post->findById($id);
//                echo "<pre>";
//                print_r($post);
                $this->Post->id = $id;
                $this->Post->saveField('disabled', 1);
                $this->Session->setFlash(__('The post has been disabled.'));
                $this->redirect(array('controller' => 'dashboards','action' => 'profile'));      
                
            }
            
            public function enable(){
                $this->autoRender = false;  //if ctp is not needed for the function
                $this->loadModel('Post');
                $id = $this->request->pass;
                $this->Post->id = $id;
                $this->Post->saveField('disabled', 0);
                $this->Session->setFlash(__('The post has been enabled.'));
                $this->redirect(array('controller' => 'dashboards','action' => 'profile'));
            }

            public function delete(){
                $this->autoRender = false;
                $this->loadModel('Post');
//                print_r($this->request->pass);
                $id = $this->request->pass;
                $this->Post->id = $id;
                
                $this->Post->delete();
                $this->Session->setFlash(__('The post has been deleted.'));
                $this->redirect(array('controller' => 'dashboards','action' => 'profile'));      
            }
}