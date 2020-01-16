<?php


echo $this->Form->create('newPost',array('enctype' => 'multipart/form-data'));
echo $this->Form->input('title');
echo $this->Form->input('description');
echo $this->Form->input('tags');
echo $this->Form->input('image.', array('type' => 'file', 'multiple'));
echo $this->Form->end();
?>
<input name="submitbtn" type="submit" value="Post" class="postUpload" />
<?php
//echo "Cancel";
//echo $this->Html->link('users', '/login');
echo $this->Html->link('Cancel', '/dashboard', array('class' => 'button'));


?>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
<script>
    $('.postUpload').on('click',function(){
       var form = $('#newPostCreateForm')[0];
       var fd = new FormData(form);

       $('#ajax-loader-full').show();
        $.ajax({
            url: 'http://localhost/cakephp/dashboards/post',
            processData: false,
            contentType: false,
//            data: $("#newPostCreateForm").serialize(),
            data: fd,
            type: "POST",
            dataType: 'json',
            success: function(response){
                if(response.status=== 0){
                  alert("Please select maximum 5 images!!!");
                  
                }else{
                alert('Post created successfully.');
                window.location.href = "http://localhost/cakephp/dashboard";
                }
            },
            error: function(){
                alert('Something went wrong!');
            }
        });
    });

</script>

