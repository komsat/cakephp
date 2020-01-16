<style>
    .imageDimension{
        width: 200px;
        height: 150px;
    }
    .button{
        /*text-align: right;*/
        border: 2px solid black;
        line-height: 25px;
        padding: 0 10px;
        background: #006cba;
        color: #fff;
        display: inline-block;
        font-family: roboto;
        text-decoration: none;
        font-size: 12px;
        border: 2px solid black;
    }
    .editButton{
        /*text-align: right;*/
        border: 2px solid black;
        line-height: 25px;
        padding: 0 10px;
        background: #009b80;
        color: #fff;
        display: inline-block;
        font-family: roboto;
        text-decoration: none;
        font-size: 10px;
        border: 2px solid black;
    }
    
    .button:hover,
    .button:visited, .editButton:hover {
        background: #006cba;
        color: #fff;
        opacity: 0.8;
    }
    h3{
        font-size: 18px;
    }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo $this->Html->link('↰ Dashboard', '/dashboard', array('class' => 'button'));
echo '<br>';
echo '<br>';
?>
<fieldset>
        <legend><?php echo __('Profile');?></legend>
    <!--<h3>Edit<i class="fa fa-edit"></i></h3>-->
        <?php echo $this->Html->link('Edit Profile', '/editProfile', array('class' => 'editButton'));?>
        <br><br>
        
<?php
echo "Name: ".$user['User']['name'];//$this->Session->read('Auth.User.name');
echo '<br>';
echo "Username: ".$user['User']['username'];//.$this->Session->read('Auth.User.username');
echo '<br>';
echo "Mobile ✆: ".$user['User']['mobile'];//$this->Session->read('Auth.User.mobile');
echo '<br>';
echo "Email ✉: ".$user['User']['email'];//$this->Session->read('Auth.User.email');
?>
</fieldset>
<div id="button-logout">
<?php
//echo '<br>';
//echo '<br>';
//echo '<br>';
echo $this->Html->link('Logout', array('controller' => 'users', 'action'=>'logout'), array('class' => 'button'));
?>
</div>
<div id="content-part">
        <table>
        <tr>
            <td>User</td>
            <td>Date created</td>
            <td>Title</td>
            <td>Description</td>
            <td>Tags</td>
            <td>Images</td>
            <td>Action</td>
        </tr>
        <?php
//        echo '<pre>';print_r($posts);exit;
            foreach ($posts as $row):
//                echo "<td>".$row->title."</td>";
                echo "<tr><td>".$row["userid"]."</td>";
                echo "<td>".$row["created"]."</td>";
                echo "<td>".$row["title"]."</td>";
                echo "<td>".$row["description"]."</td>";
                echo "<td>".$row["tags"]."</td>";
                echo "<td><table><tr>";
                foreach ($row['img']['name'] as $img):
//                    echo "<td>".$img."</td>";
                
                    echo "<td>".$this->Html->image('upload/'.$img,array('alt' => 'CakePHP','class'=> 'imageDimension', 'escape' => false))."</td>";
                endforeach;
                echo "</tr></table></td>";
                ?><td>
                <?php echo $this->Html->link('Edit', array('controller' => 'dashboards', 'action'=>'edit/'.$row["id"]), array('class' => 'button', 'id' => 'editBtn'));?><br>
                <?php
                    if($row["disabled"] == 0){ 
                        echo $this->Html->link('Disable', array('controller' => 'dashboards', 'action'=>'disable/'.$row["id"]), array('class' => 'button'));
                    }else{
                        echo $this->Html->link('Enable', array('controller' => 'dashboards', 'action'=>'enable/'.$row["id"]), array('class' => 'button'));
                    }
                ?><br>
                <?php echo $this->Html->link('Delete', array('controller' => 'dashboards', 'action'=>'delete/'.$row["id"]), array('class' => 'button'));
//                print_r($row);
            endforeach;
            ?>

        </td></tr>
        </table>

        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
        <?php echo $this->Paginator->numbers(array(   'class' => 'numbers'     ));?>
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>

        </div>