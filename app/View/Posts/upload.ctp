<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo file_get_contents('/var/www/html/cakephp/app/webroot/img/upload/pic1.jpeg',FILE_BINARY);
//echo $this->Form->create('Post');
echo $this->Form->create('Post', array('url' => array('action' => 'upload'), 'enctype' => 'multipart/form-data'));
 echo $this->Html->image('upload/pic1.jpeg', array('width' => '200px','alt'=>'aswq','pathPrefix' => '/'));

//echo $this->Form->input('imgName'); // No div, no label has a label element
echo $this->Form->input('upload', array('type' => 'file'));
//echo $this->Form->input('path'); 
//echo $this->Form->input('dateCreated'); 
//echo $this->Form->input('postId');
//echo $this->Form->button('save',array('id'=>'save')); 
echo $this->Form->end('upload');
