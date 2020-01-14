<?php


App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component/Auth');
class User extends Model{
    
    public $validate = array(
        'username' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required',
                'allowEmpty' => false
            ),
            'between' => array( 
                'rule' => array('lengthBetween', 5, 15), 
                'required' => true, 
                'message' => 'Usernames must be between 5 to 15 characters'
            ),
             'unique' => array(
                'rule'    => 'isUnique',
                'message' => 'This username is already in use'
            ),
            'alphaNumeric' => array(
                'rule'    => 'alphaNumeric',
                'message' => 'Username can only be letters, numbers'
            ),
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'),  
                'message' => 'Password must have a mimimum of 6 characters'
            )
        ),
         
        'email' => array(
            'required' => array(
                'rule' => array('email', true),    
                'message' => 'Please provide a valid email address.'   
            ),
             'unique' => array(
                'rule'    => 'isUnique',
                'message' => 'This email is already in use',
            ),
            'between' => array( 
                'rule' => array('lengthBetween', 6, 60), 
                'message' => 'Usernames must be between 6 to 60 characters'
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
                array(
                    'conditions'=>array(
                    'username' => $username,
                    'password' =>$password),
                )
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