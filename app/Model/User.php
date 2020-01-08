<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('Model', 'Model');
class User extends Model{
    
    public function getAllUsers(){
        return $this->find('all');
    }
    
    public function validateUser($email,$password){
        $userDetails = $this->find('first',
                array(
                    'conditions'=>array(
                    'email' => $email,
                    'password' =>$password),
                )
                );
        if(!empty($userDetails)){
            return true;
        }else{
            return false;
        }
    }
    
    public function userRegister($name, $email, $mobile, $password){
        $data = array();
        $data['name'] = $name;
        $data['email'] = $email;
        $data['mobile'] = $mobile;
        $data['password'] = $password;
        
        $userDetails = $this->save($data);
        if(!empty($userDetails)){
            return true;
        }else{
            return false;
        }
    }
}