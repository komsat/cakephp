<?php


App::uses('AppController', 'Controller');

class UsersController extends AppController{
//    public $helpers = array('Html', 'Form', 'Session');
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
    
    public function profile(){

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
                    $this->Flash->success('Please click on password reset link, sent in your email address to reset password.');
                }else
                {
                    $this->Flash->error('Sorry! Email address is not available here.');
                }
            }
        }
    }
}
