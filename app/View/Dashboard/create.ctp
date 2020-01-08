<img src="localhost/cakephp/app/webroot/img/upload/imagesLogin.png" alt="pic1.jpeg" height="300" width="300">
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo $this->Form->create(array('url'=>'/create','enctype' => 'multipart/form-data'));
//echo $this->Html->image('upload/pic1.jpeg', array('width' => '200px','alt'=>'asdf','pathPrefix' => '/'));
echo $this->Form->input('title');
echo $this->Form->input('description');
echo $this->Form->input('tags');
echo $this->Form->input('upload', array('type' => 'file'));
echo $this->Form->end('upload');
?>
