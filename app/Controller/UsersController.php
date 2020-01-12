<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppController', 'Controller');

class UsersController extends AppController{
    
    public $paginate = array(
        'limit' => 25,
        'conditions' => array('status' => '1'),
        'order' => array('User.name' => 'asc' ) 
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'register', 'forgotPassword');
    }
    
//    public function index() {
//        $this->User->recursive = 0;
//        $this->set('users', $this->paginate());
//    }
    
//    public function view($id = null) {
//        $this->User->id = $id;
//        if (!$this->User->exists()) {
//            throw new NotFoundException(__('Invalid user'));
//        }
//        $this->set('user', $this->User->findById($id));
//    }
    
    public function login(){
        
        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('controller' => 'dashboards','action' => 'dashboard'));      
        }
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('name')));
                $this->redirect($this->Auth->redirect()); //$this->Auth->redirectUrl() to redirect()
            } else {
                $this->Session->setFlash(__('Invalid username or password'));
            }

        }
    }    
        
        
        
//        $data = $this->request->data;
////        echo '<pre>';
////        print_r($data);
//        $this->theme = false;
////        $this->autoLayout =false;
//        $this->autoRender =false;   //if ctp is not required for the function
//        $this->loadModel('User');
//        $users = $this->User->validateUser($data['User']['username'],$data['User']['password']);
//        if($users){
//        echo 'Welcome';
////        create session for logged-in user.
//        CakeSession::write('Message', $data['User']['name']);
////        $this->Session->setFlash('Your stuff has been saved.');
////        $this->Session->write('user', $data['User']['username']);
////        $this->redirect(array('controller' => 'dashboards', 'action' => 'dashboard'));
//        $this->redirect('http://localhost/cakephp/dashboard');
//        
//        Configure::write('Session', array(
//            'defaults' => 'php',
//            'timeout' => 2160, // 36 hours
//            'ini' => array(
//                'session.gc_maxlifetime' => 129600 // 36 hours
//            )
//        ));
//        }else{
//            echo 'invalid user or password';
//        }
        
//    }
    
//    public function userRegister(){
//        $this->autoLayout =false;
////        $this->loadModel('User');
////        $users = $this->User->getAllUsers();
////        echo 'All Users Fetched<pre>';
////        print_r($users);
//    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    
    public function register(){
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $response= array('status'=>0);
            if(!empty($data)){
            $this->autoRender = false;
            $this->loadModel('User');
            $success = $this->User->userRegister($data['User']['name'], $data['User']['email'], $data['User']['mobile'], $data['User']['username'],$data['User']['password']);
            if($success){
                $this->Auth->login();
                $this->Session->setFlash(__('The user has been created'));
                $response['status'] = 1;
                $response['message'] = "Registered successfully";
            }else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }

            }
            return json_encode($response);
        }
    }
    
//    public function registerUser(){
//        $data = $this->request->data;
//        $response= array('status'=>0);
//        if(!empty($data)){
//        $this->autoRender = false;
//        $this->loadModel('User');
//        $success = $this->User->userRegister($data['User']['name'], $data['User']['email'], $data['User']['mobile'], $data['User']['password']);
//        if($success){
//            $response['status'] = 1;
//            $response['message'] = "Registered successfully";
//        }
//        
//        }
//        return json_encode($response);
//    }
    
    public function profile(){
//        $this->loadModel('User');
//        if ($this->Auth->login()) {
//            
//        } else {
//           
//        }
    }
    
    public function forgotPassword(){
        if ($this->request->is('post')) 
        {
            if (!empty($this->request->data))
            {
                $email = $this->request->data['email'];
                print_r($email);
                $user = $this->Users->findByEmail($email)->first();
                print_r($email);
                if (!empty($user))
                {
                    $password = sha1(Text::uuid());
                    $password_token = Security::hash($password, 'sha256', true);
                    $hashval = sha1($user->username . rand(O, 100));

                    $user->password_reset_token = $password_token;
                    $user->hashval = $hashval;
                    
                    $reset_token_link = Router::url(['controller' => 'Users', 'action' => 'resetPassword'], TRUE) . '/' . $password_token . '#' . $hashval;
                    
                    $emaildata = [$user->email, $reset_token_link];
                    $this->getMailer('SendEmail')->send('forgotPasswordEmail', [$emaildata]);
                    
                    $this->Users->save($user);
                    $this->Flash->success('Please click on password reset link, sent in your email address to reset password.');
                }else
                {
                    $this->Flash->error('Sorry! Email address is not available here.');
                }
            }
        }
    }
}
