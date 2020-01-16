<style>
    .imageDimension{
        width: 200px;
        height: 150px;
    }
</style>
<?php
echo $this->Form->create('editPost',array('enctype' => 'multipart/form-data'));
echo $this->Form->input('title', array('value' => $posts["Post"]["title"]));
echo $this->Form->input('description', array('value' => $posts["Post"]["description"]));
echo $this->Form->input('tags', array('value' => $posts["Post"]["tags"]));

//echo $this->Form->input('image.', array('type' => 'file', 'multiple'));

//images part
$count = 0;
echo "<table><tr>";
foreach($posts['Post']['img']['name'] as $img){
    echo "<td>".$this->Html->image('upload/'.$img['imgName'],array('alt' => 'CakePHP','class'=> 'imageDimension','id' => $img['imgId'],'escape' => false))."</td>";
}
echo "</tr></table>";
//images part ends

echo $this->Form->end();
?>
<input name="submitbtn" type="submit" value="Done" class="editDone"/>
<?php
echo $this->Html->link('Cancel', '/profile', array('class' => 'button'));

?>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>

<script>
        $("img").click(function(){
            alert("Are you sure, you want to delete?");
            window.imageId = $(this).attr('id');
            $(this).hide();
        });

    $('.editDone').on('click',function(){
       var form = $('#editPostEditForm')[0];
       var fd = new FormData(form);
       fd.set('imageId', window.imageId);
       $('#ajax-loader-full').show();
        $.ajax({
//            url: 'http://localhost/cakephp/edit',
            processData: false,
            contentType: false,
            data: fd,
            type: "POST",
            dataType: 'text',
            success: function(response){
                
                alert('Edit Done');
                window.location.href = "http://localhost/cakephp/profile";

            },
            error: function(){
                alert('Something went wrong!');
            }
        });
    });

</script>

