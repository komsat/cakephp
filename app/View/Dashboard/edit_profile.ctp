<?php
    echo $this->Form->create('editProfile',array('enctype' => 'multipart/form-data'));
    echo $this->Form->input('name', array('value' => $user["User"]["name"]));
    echo $this->Form->input('email', array('value' => $user["User"]["email"]));
    echo $this->Form->input('mobile', array('value' => $user["User"]["mobile"]));
    echo $this->Form->input('username', array('value' => $user["User"]["username"]));
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
       var form = $('#editProfileEditProfileForm')[0];
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
                alert('Profile Edited.');
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
