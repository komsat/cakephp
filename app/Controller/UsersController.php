<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController{
    
    var $components=array("Email","Session");
    var $helpers=array("Html","Form","Session");
    
//    public $helpers = array('Html', 'Form', 'Session');
    public $paginate = array(
        'limit' => 25,
        'conditions' => array('status' => '1'),
        'order' => array('User.name' => 'asc' ) 
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'register', 'forgotPassword', 'reset');
    }
    
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
//        $this->User->recursive=-1;
        if ($this->request->is('post')) 
        {
            if (!empty($this->request->data))
            {
                $email = $this->request->data['User']['email'];
//                print_r($email);
                $this->loadModel('User');
                $user = $this->User->findByEmail($email);
//                print_r($user);
                if (!empty($user))
                {
                        $password = sha1(String::uuid());
                        $password_token = Security::hash($password,'sha256',true);
                        $hashval=sha1($user['User']['username'].rand(0,100));
			$reset_token_link = Router::url( array('controller'=>'users','action'=>'reset'), true ).'/'.$password_token.'/'.$hashval;
			
                        $emaildata = [$user['User']['email'], $reset_token_link];

			
			$user['User']['password_reset_token'] = $password_token;
                        $user['User']['hashval'] = $hashval;
//                        print_r($user);
                        
                        $user = Hash::extract($user,'User');
//                        print_r($user);
                        
//                        $this->User->id=$user['id'];
                        
                        $result = $this->User->save($user);
//                        print_r($result);
			if($result){
                            $this->redirect($reset_token_link);
                            
                            //============Email================//
                                /* SMTP Options */
        //			$this->Email->smtpOptions = array(
        //                            'port'=>'25',
        //                            'timeout'=>'30',
        //                            'host' => 'mail.example.com',
        //                            'username'=>'accounts@example.com',
        //                            'password'=>'your password'
        //			);
        //			$this->Email->template = 'resetpw';
        //			$this->Email->from    = 'Your Email <accounts@example.com>';
        //			$this->Email->to      = $user['name'].'<'.$user['email'].'>';
        //			$this->Email->subject = 'Reset Your Example.com Password';
        //			$this->Email->sendAs = 'both';
        // 
        //			$this->Email->delivery = 'smtp';
        //			$this->set('ms', $emaildata);
        //			$this->Email->send();
        //			$this->set('smtp_errors', $this->Email->smtpError);
        //			$this->Session->setFlash(__('Check Your Email To Reset your password', true));
                        //============EndEmail=============//
			}
			else{
                            $this->Session->setFlash("Error Generating Reset link");
			}
		}
		else
		{
			$this->Session->setFlash('This Account with Provided Email does not Exist!');
                }
                    
            }else
            {   
                
                $this->Session->setFlash('Please Provide Your Email Adress that You used to Register with Us');
            }
        }
    }
    
    public function reset(){
        if(!empty($this->request->pass)){
            
            $token = $this->request->pass[0];
            $hash = $this->request->pass[1];
            $this->loadModel('User');
            
			$user=$this->User->findByPasswordResetToken($token);
//                        print_r($user);
			if($user){
				$this->User->id=$user['User']['id'];
				if(!empty($this->request->data)){
					$new_hash=sha1($user['User']['username'].rand(0,100));//created token
					$user['User']['password_reset_token']=$new_hash;
                                        $new_password = $this->request->data['User']['new_password'];
                                        $confirm_password = $this->request->data['User']['confirm_password'];
                                        $user['User']['password'] = $new_password;
                                        $user = Hash::extract($user,'User');
//                                        print_r($user);
                                        
					if($this->User->validates(array('fieldList'=>array($new_password,$confirm_password)))){
						if($this->User->save($user))
						{
							$this->Session->setFlash('Password Has been Updated');
							$this->redirect(array('controller'=>'users','action'=>'login'));
						}
 
					}
					else{
 
						$this->set('errors',$this->User->invalidFields());
					}
				}
			}
			else
			{
				$this->Session->setFlash(__('Token Corrupted,,Please Retry. The reset link work only for once.'));
			}
		}
 
		else{
			$this->redirect('localhost/cakephp/forgotPassword');
		}
        
        
        
    }
}
