<!DOCTYPE html>
<html>
    <head> 
        <title></title>
        <style>
            h2 {
                text-align: center;
            }
            .button {
              line-height: 35px;
              padding: 0 10px;
              background: #006cba;
              color: #fff;
              display: inline-block;
              font-family: roboto;
              text-decoration: none;
              font-size: 18px;
            }

            .button:hover,
            .button:visited {
              background: #006cba;
              color: #fff;
              opacity: 0.8;
            }
            table, th, td {
              border: 1px solid black;
            }
            .imageDimension{
                width: 200px;
                height: 150px;
            }
            #right-side{
                text-align: right;
            }
            .postSearch {
              line-height: 35px;
              padding: 0 10px;
              background: #006cba;
              color: #fff;
              display: inline-block;
              font-family: roboto;
              text-decoration: none;
              font-size: 18px;
            }

            .postSearch:hover,
            .postSearch:visited {
              background: #006cba;
              color: #fff;
              opacity: 0.8;
            }
        </style>
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
       
    </head>
    <body>
        <h2><a href="http://localhost/cakephp/dashboard">Bulletin Board</a></h2>
        <div id = 'right-side'>
            <?php
            echo 'User: ';
            echo $this->Html->link($this->Session->read('Auth.User.name'), '/profile', array('class' => 'button'));//array('controller' => 'dashboards', 'action'=>'profile'));    //get name of currently logged in user form session
            ?>
        </div>
        <div id = "control">
           <?php
//                $this->Session->check('Auth.User');
//                echo $this->Auth->user('name');
//                echo $this->Html->link('$this->User->user("name")', '/profile', array('class' => 'button'));
                echo $this->Html->link('Create Post', '/create', array('class' => 'button'));
                
                ?>
                <div id='right-side'>
                    <?php
                        echo $this->Html->link('Logout', array('controller' => 'users', 'action'=>'logout'), array('class' => 'button'));
                    ?>
                    <input name="searchBox" type="text" id="searchBox" placeholder="Type keyword to search posts " value="<?php if(!empty($search)){ echo $search;}else{ echo "";} ?>">
                    <input name="searchbtn" type="submit" value="Search" class="postSearch" />
                    <?php
//                        echo $this->Form->create('searchPost');
//                        echo $this->Form->input('searchBox');
//                        echo $this->Html->link('Search', array('controller' => 'dashboards', 'action'=>'dashboard'), array('class' => 'postSearch'));
//                        echo $this->Form->end();   
                    ?>

                </div>
        </div>
        <div id="content-part">
        <table>
        <tr>
            <td><?php echo $this->Html->link('User', array('controller' => 'dashboards', 'action'=>'/dashboard/1')); //?sort=user?></td>
            <td><?php echo $this->Html->link('Date created', array('controller' => 'dashboards', 'action'=>'/dashboard/0'));?></td>
            <td>Title</td>
            <td>Description</td>
            <td>Tags</td>
            <td>Images</td>
        </tr>
        <?php
//        echo '<pre>';print_r($posts);exit;
            foreach ($posts as $row):
//                echo "<td>".$row->title."</td>";
                echo "<tr><td>".$row["username"]."</td>";
                echo "<td>".$row["created"]."</td>";
                echo "<td>".$row["title"]."</td>";
                echo "<td>".$row["description"]."</td>";
                echo "<td>".$row["tags"]."</td>";
                echo "<td><table><tr>";
                foreach ($row['img']['name'] as $img):
//                    echo "<td>".$img."</td>";
                
                    echo "<td>".$this->Html->image('upload/'.$img,array('alt' => 'CakePHP','class'=> 'imageDimension', 'escape' => false))."</td>";
                endforeach;
                echo "</tr></table></td></tr>";
            endforeach;
        ?>
        </table>
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
        <?php echo $this->Paginator->numbers(array(   'class' => 'numbers'     ));?>
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>

        </div>
    </body>
</html>
 
        <script>
            $('.postSearch').on("click", function(){
//                alert(document.getElementById("searchBox").value);
                var a = document.getElementById("searchBox").value;
                
//                alert("http://localhost/cakephp/dashboard/" + a);
                window.location.href = "http://localhost/cakephp/dashboard?search=" + a;
            });
        </script>

        