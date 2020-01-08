<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppController', 'Controller');

class UsersController extends AppController{
    
    public function userTasks(){
        $this->autoLayout =false;
//        $this->loadModel('User');
//        $users = $this->User->getAllUsers();
//        echo 'All Users Fetched<pre>';
//        print_r($users);
    }
    
    public function login(){
        $data = $this->request->data;
        echo '<pre>';
        print_r($data);
        $this->theme = false;
//        $this->autoLayout =false;
        $this->autoRender =false;   //if ctp is not required for the function
        $this->loadModel('User');
        $users = $this->User->validateUser($data['User']['username'],$data['User']['password']);
        if($users){
        echo 'Welcome';
//        create session for logged-in user.
        CakeSession::write('Message', $data['User']['username']);
        $this->Session->setFlash('Your stuff has been saved.');
//        $this->Session->write('user', $data['User']['username']);
//        $this->redirect(array('controller' => 'dashboards', 'action' => 'dashboard'));
        $this->redirect('http://localhost/cakephp/index.php/dashboards/dashboard');
        
        Configure::write('Session', array(
            'defaults' => 'php',
            'timeout' => 2160, // 36 hours
            'ini' => array(
                'session.gc_maxlifetime' => 129600 // 36 hours
            )
        ));
        }else{
            echo 'invalid user or password';
        }
        
    }
    
//    public function userRegister(){
//        $this->autoLayout =false;
////        $this->loadModel('User');
////        $users = $this->User->getAllUsers();
////        echo 'All Users Fetched<pre>';
////        print_r($users);
//    }
    
    public function register(){
//        $data = $this->request->data;
//        $this->theme = false;
////        echo '<pre>';
////        print_r($data);
//        if(!empty($data)){
        $this->autoLayout =false;
//        $this->loadModel('User');
//        $success = $this->User->register($data['User']['name'], $data['User']['email'], $data['User']['mobile'], $data['User']['password']);
//        if($success){
//        echo 'Registration Successful!';
//        }else{
//            echo 'Please try again!!!';
//        }
//        }
    }
    
    public function registerUser(){
        $data = $this->request->data;
        $response= array('status'=>0);
        if(!empty($data)){
        $this->autoRender = false;
        $this->loadModel('User');
        $success = $this->User->userRegister($data['User']['name'], $data['User']['email'], $data['User']['mobile'], $data['User']['password']);
        if($success){
            $response['status'] = 1;
            $response['message'] = "Registered successfully";
        }
        
        }
        return json_encode($response);
    }
}
