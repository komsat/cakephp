<?php

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
echo $this->Form->input('username');
echo $this->Form->input('password'); 
echo $this->Form->end();
?>
<input name="submitbtn" type="submit" value="Register" class="registerUser movedownbtn" />
<?php 

if($this->Session->check('Auth.User')){
    echo $this->Html->link( "Return to Dashboard",   array('controller' => 'dashboards','action'=>'dashboard') ); 
    echo "&#09";
    echo $this->Html->link( "Logout",   array('action'=>'logout') ); 
}else{
    echo "Already a user?";
    echo $this->Html->link( "Login",   array('action'=>'login') ); 
}
?>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
<script>
    

    $('.registerUser').on('click',function(){
//        alert('fbvdfnnd');
       $('#ajax-loader-full').show();
        $.ajax({
            url: 'http://localhost/cakephp/users/register',
            data: $("#UserRegisterForm").serialize(),
            type: "POST",
            dataType: 'json',
            success: function(response){
                if(response['status'] == 1){
//                alert(response['message']);
                alert('Registered Successfully.');
                window.location.href = "http://localhost/cakephp/dashboard";
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