<?php

App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component/Auth');
class User extends Model{
    
    public $validate = array(
        'email' => array(
            'rule1' => array(
                'rule' => 'email',
                'required' => true, 
                'message' => 'Please provide a valid email address.'   
            ),
//            'rule2' => array(
//                'rule'    => 'isUnique',
//                'message' => 'This email is already in use',
//            ),
            'rule3' => array( 
                'rule' => array('between', 6, 60), 
                'message' => 'Usernames must be between 6 to 60 characters'
            )
        ),
        'username' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'A username is required',
                'required' => true, 
                'allowEmpty' => false
            ),
            'rule2' => array( 
                'rule' => array('between', 5, 15), 
                'message' => 'Usernames must be between 5 to 15 characters'
            ),
//            'rule3' => array(
//                'rule'    => 'isUnique',
//                'message' => 'This username is already in use'
//            ),
            'rule4' => array(
                'rule'    => 'alphaNumeric',
                'message' => 'Username can only be letters, numbers'
            ),
        ),
         
        'password' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'A password is required'
            ),
            'rule2' => array(
                'rule' => array('minLength', '6'),  
                'message' => 'Password must have a mimimum of 6 characters'
            )
        )
    );
    
    
    public function beforeSave($options = array()) {
		// hash our password
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
	
		// fallback to our parent
		return parent::beforeSave($options);
    }
    
    public function getAllUsers(){
        return $this->find('all');
    }
    
    public function validateUser($username,$password){
        $userDetails = $this->find('first',
                array('conditions'=>array('username' => $username, 'password' =>$password),)
                );
        if(!empty($userDetails)){
            return true;
        }else{
            return false;
        }
    }
    
    public function userRegister($name, $email, $mobile, $username, $password){
        $data = array();
        $data['name'] = $name;
        $data['email'] = $email;
        $data['mobile'] = $mobile;
        $data['username'] = $username;
        $data['password'] = $password;
        
        $userDetails = $this->save($data);
        if(!empty($userDetails)){
            return true;
        }else{
            return false;
        }
    }
}