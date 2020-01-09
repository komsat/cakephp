<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Bulletin Board
	</title>
	<?php
		echo $this->Html->meta('icon');
//		echo $this->Html->css('style');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<head>
    <style>
        body {font-family: Arial, Helvetica, sans-serif;
/*              background-image: url('http://localhost/cakephp/app/webroot/img/backgroundImage.jpg');
              background-repeat: no-repeat;
              background-attachment: fixed;  
              background-size: cover;*/
              backgroung-color: #efefef;
        }
        form {border: 3px solid #f1f1f1; 
              padding: 25px 33px;
              margin: 18px 0;}

        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        input[type=submit]:hover {
            opacity: 0.8;
        }
        .imgcontainer {
            text-align: center;
            /*margin: 24px 0 12px 0;*/
            width: 40%;
            border-radius: 50%;
            /*height: 400px;*/
        }
        .avatar {
            width: 40%;
            border-radius: 50%;
        }
        #content {
            padding: 16px;
        }
        #header {
            text-align: center;
            margin: 24px 0 12px 0;
        }
        #UserUserTasksForm{
            align: center;
            /*margin: 24px 0 12px 0;*/
            width: 40%;
        }
    </style>
</head>
<body>
	<div id="container">
		<div id="header">
			<h2>Bulletin Board</h2>
		</div>
		<div id="content">
                    <div class="imgcontainer">
                        <img src="http://localhost/cakephp/app/webroot/img/imagesLogin.png" alt="Avatar" class="avatar">
                    </div>
                    <?php
                        echo $this->Form->create('User',array('url' => array('action' => 'login')));
                        echo $this->Form->input('username', array('label' => 'Username'));
                        echo $this->Form->input('password'); // No div, no label has a label element
                        echo $this->Form->end('Login');
                        echo "New User?";
//                        echo $this->Html->link('users', '/register');
                        echo $this->Html->link('Register', '/register', array('class' => 'button'));
                    ?>
		</div>
	</div>
</body>
</html>












<!--echo $this->Form->create('User',array('url' => array('action' => 'login')));

echo $this->Form->input(
    'username',
    array('label' => 'Username')
);
echo $this->Form->input('password'); // No div, no label
// has a label element
echo $this->Form->end('search');

echo "New User?";
echo $this->Html->link('users', '/register');   
?>-->
