<?php

App::uses('AppController', 'Controller');

class DashboardsController extends AppController {
            public $components = array('Paginator');
            var $name = 'Dashboard';
            var $uses = array('Post');
            public $paginate = array(
              'limit' => 25,
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
                $search = null;
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
                    $this->set('search', $this->request['url']['search']);     //search keyword is set in search
                    
                    $postsUser = $this->Post->find('all', $options);
                    $postsUser = Hash::extract($postsUser, '{n}.Post.userid');
//                    echo "<pre>";
//                    print_r($postsUser);
                      
                    $this->paginate = array(
                        'conditions' => array('Post.disabled' => 0, 'OR'=>array(array('Post.title LIKE' => '%'.$this->request['url']['search'].'%'),array('Post.description LIKE' => '%'.$this->request['url']['search'].'%'),array('Post.tags LIKE' => '%'.$this->request['url']['search'].'%'), array('Post.userid' => $postsUser))),
                        'limit' => 6,
                        'order' => array('OR'=>array('Post.id' => $order1, 'Post.created' => $order2))
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
            
          
          
            public function create($param=null){
                $formData = $param;
//                print_r($data);
                $count = 0;
                $response['status']=0;
                $this->loadModel('Image');
                if(!empty($formData)){

//  Check whether form has more than 5  elments!
                        if(count($formData) > 5){
                            return 0;//$response;
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
                $response['status'] = 0;

                if(!empty($data)){
                    
                    $imageResponse = $this->create($data['newPost']['image']);
                    
                    $this->loadModel('Post');
                    if($imageResponse['status']==0){
                       
                        return json_encode($response);
                    }
                    $data['newPost']['images'] = json_encode($imageResponse['imageId']);
                    $data['newPost']['userid'] = $this->Auth->user('id'); //$this->Session->read('Auth.User.name');

                    $success = $this->Post->postUpload($data['newPost']['userid'], $data['newPost']['title'], $data['newPost']['description'], $data['newPost']['tags'], $data['newPost']['images']);
                    if($success){
                        
                        $response["status"] = 1;
//                        $response["message"] = "Posted Sucessfully";

                    }

                    }
//                    print_r($response);
                    return json_encode($response);
            }
            

            
            public function profile(){
                $this->loadModel('User');
                 $id = $this->Auth->user('id');
                $user = $this->User->findById($id);
                $this->set('user', $user);
                
                
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
                  $this->loadModel('Post');
                  $id = $this->request->params['pass'];

                $posts = $this->Post->findById($id);
                
                //for fetching images
                
                  $this->loadModel('Image');
                  
                  $imageIds= json_decode($posts['Post']['images']);
                  
                  $imgCount = 0;
                  $imgId = 0;
                  foreach ($imageIds as $index=>$value){
                      $imgData =  $this->Image->findById($value);
                      $posts['Post']['img']['name'][$imgCount++]['imgName'] = $imgData['Image']['name'];
                      $posts['Post']['img']['name'][$imgId++]['imgId'] = $imgData['Image']['id'];
                  }
    
                //image fetch ends here
                  
                $this->set('posts', $posts);
               
                if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {  //alternatively use: is(array('post', 'put'))
                    $data = $this->request->data;

                    $response= array('status'=>0);

                    if(!empty($data)){
                    
                    $data['editPost']['id']=$id[0];

                    //image delete starts
                    
                    $imgId = $data['imageId'];
                    $this->loadModel('Post');
                    $posts = $this->Post->findById($id);
                    $imageIds = json_decode($posts['Post']['images']);
                    $imageIds = \array_diff($imageIds, [$imgId]);
                    $imageIds = array_values($imageIds);
//                    print_r($imageIds);
                    $data['editPost']['images'] = json_encode($imageIds);
                    
                    $this->loadModel('Image');
                    $this->Image->id = $imgId;

                    //image delete ends
                    
                    $success = ($this->Post->postEdit($data['editPost']['title'], $data['editPost']['description'], $data['editPost']['tags'], $data['editPost']['images'],$data['editPost']['id']) && $this->Image->delete());
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
            
            public function editProfile(){
//                $this->autoRender = false;
                 $this->loadModel('User');
                 $id = $this->Auth->user('id');
//                  print_r($id);
                $user = $this->User->findById($id);
//                print_r($user);
                $this->set('user', $user);
                
                if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {  //alternatively use: is(array('post', 'put'))
                    if($this->request->data){
                        $data = $this->request->data;
//                        print_r($data);
                        $response= array('status'=>0);
    //                    $this->Post->id = $id;
                        if(!empty($data)){

                        $data['editProfile']['id']=$id;
                        print_r($data);
                        $success = $this->User->profileEdit($data['editProfile']['name'], $data['editProfile']['email'], $data['editProfile']['mobile'], $data['editProfile']['username'], $data['editProfile']['id']);
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
                
            }    
            
}