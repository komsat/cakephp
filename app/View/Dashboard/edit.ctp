<?php
echo $this->Form->create('editPost',array('enctype' => 'multipart/form-data'));
echo $this->Form->input('title', array('value' => $posts["Post"]["title"]));
echo $this->Form->input('description', array('value' => $posts["Post"]["description"]));
echo $this->Form->input('tags', array('value' => $posts["Post"]["tags"]));
//echo $this->Form->input('id', array('type' => 'hidden'));
//echo $this->Form->input('image.', array('type' => 'file', 'multiple'));
echo $this->Form->end();
?>
<input name="submitbtn" type="submit" value="Done" class="editDone" />
<?php
echo $this->Html->link('Cancel', '/profile', array('class' => 'button'));

?>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
<script>
    $('.editDone').on('click',function(){
//        alert('fbvdfnnd');
       var form = $('#editPostEditForm')[0];
       var fd = new FormData(form);

       $('#ajax-loader-full').show();
        $.ajax({
//            url: 'http://localhost/cakephp/edit',
            processData: false,
            contentType: false,
//            data: $("#newPostCreateForm").serialize(),
            data: fd,
            type: "POST",
            dataType: 'text',
            success: function(response){
//                var res = $.parseJSON(response);
//                if(res.status == 0){
////                alert(response['message']);
//                  alert("Please select maximum 5 images!!!");
//                  
//                }else{
//                alert(response);
                alert('Edit Done');
                window.location.href = "http://localhost/cakephp/profile";
//            }
//            }else{
//                alert('Post failed!!!');
//            }
            },
            error: function(){
                alert('Something went wrong!');
            }
        });
    });

</script>

