<!DOCTYPEhtml>
<html>
    <head> 
        <title></title>
<!--        <script>
            $(document).ready(function(){
//                document.getElementById('message').innerText = 'Welcome!';
                setTimeout(function(){ document.getElementById('message').innerHTML = ''; }, 3000);
            }
        </script>-->
        <style>
             
            .button {
              line-height: 55px;
              padding: 0 30px;
              background: #004a80;
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
        </style>
    </head>
    <body>
        <h2>Bulletin Board</h2>
        <div id = "message">Welcome</div>
        <div id = "control">
           <?php
                echo $this->Html->link('My Dashboard', '/create', array('class' => 'button'));
                echo $this->Html->link('Create Post', '/create', array('class' => 'button'));
//                echo $this->Html->link('Delete Post', '/delete', array('class' => 'button'));
//                echo $this->Html->link('Hide Post', '/create', array('class' => 'button'));
           ?>
        </div>
        
        <table>
        <tr>
            <td>User</td>
            <td>Title</td>
            <td>Description</td>
            <td>Tags</td>
            <td>Images</td>
        </tr>
        <?php
//        echo '<pre>';print_r($posts);
            foreach ($posts as $row):
//                echo "<td>".$row->title."</td>";
                echo "<tr><td>".$row["userid"]."</td>";
                echo "<td>".$row["title"]."</td>";
                echo "<td>".$row["description"]."</td>";
                echo "<td>".$row["tags"]."</td>";
                echo "<td><table><tr><td>".$row["images"]."</td>";
                echo "<td>".$row["images"]."</td>";
                echo "<td>".$row["images"]."</td>";
                echo "<td>".$row["images"]."</td>";
                echo "<td>".$row["images"]."</td></tr></table></td></tr>";
            endforeach;
        ?>
        </table>
    </body>
</html>