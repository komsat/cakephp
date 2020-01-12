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
              background: #009b80;
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
        </style>
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
        
        <script>
            $('.postSearch').on('click',function(){

               $('#ajax-loader-full').show();
                $.ajax({
                    url: 'http://localhost/cakephp/dashboards/search',
                    data: $("#searchBox").serialize(),
                    type: "POST",
                    dataType: 'json',
                    success: function(response){
                        
                        alert(response['message']);
                        
                    },
                    error: function(){
                        alert('Something went wrong!');
                    }
                });
            });

        </script>

        
    </head>
    <body>
        <h2>Bulletin Board</h2>
        <!--<div id = "message">Welcome</div>-->
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
                <input name="searchBox" type="text" id="searchBox" placeholder="Type title/email/tag to search posts">
                <input name="searchbtn" type="submit" value="Search" class="postSearch" />
<!--                <div id='right-side'>-->
                    <?php
                    echo $this->Html->link('Logout', array('controller' => 'users', 'action'=>'logout'), array('class' => 'button'));
                    ?>
                </div>
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