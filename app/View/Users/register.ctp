<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo $this->Form->create('User');
//echo $this->Form->create('User', array('url' => array('action' => 'registerUser')));

//echo $this->Form->input(
//    'username',
//    array('label' => 'id')
//);
echo $this->Form->input('name'); // No div, no label
// has a label element
echo $this->Form->input('email'); 
echo $this->Form->input('mobile'); 
echo $this->Form->input('password');
//echo $this->Form->button('save',array('id'=>'save')); 
echo $this->Form->end();
?>
<input name="submitbtn" type="submit" value="Register" class="registerUser movedownbtn" />
<?php 
echo "Already a user?";
//echo $this->Html->link('users', '/login');
echo $this->Html->link('Login', '/users/login', array('class' => 'button'));

//$this->redire
//    'controller' => 'myController',
//    'action' => 'myAction'
//]);

?>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
<script>
    

    $('.registerUser').on('click',function(){
//        alert('fbvdfnnd');
       $('#ajax-loader-full').show();
        $.ajax({
            url: 'http://localhost/cakephp/index.php/users/registerUser',
            data: $("#UserRegisterForm").serialize(),
            type: "POST",
            dataType: 'json',
            success: function(response){
                if(response['status'] == 1){
                alert(response['message']);
                window.location.href = "http://localhost/cakephp/index.php/login"
            }else{
                alert('Failed to register');
            }
            },
            error: function(){
                alert('Something went wrong!');
            }
        });
    });

</script>