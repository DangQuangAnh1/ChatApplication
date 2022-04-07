<!-- File: templates/Articles/edit.php -->
<?php
$session = $this->request->getSession();
if($session->read('email') != "" && $session->read('name') != ""){
    $dis='enabled';
}
else{
    $dis='disabled';
}
$user_id=$session->read('user_id');
?>
<style>
    .addchat{
        width: 40%;
        margin: auto;
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        border: 2px solid lightblue;
        box-shadow: 2px ;
        text-align: left;
    }
    input[type=file]{
        display: none;
    }
    .custom-file-upload {
        background-color: #5B7DB1;
        border-radius: .4rem;
        color: #fff;
        display: inline-block;
        font-size: 1.1rem;
        font-weight: 700;
        height: 3.8rem;
        letter-spacing: .1rem;
        line-height: 3.8rem;
        margin: 20px 0 1.5rem;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap;
        min-width: 40%;
    }
    .custom-file-upload :hover{
        border-radius: .4rem;
        background-color: rgb(133,133,133);
    }
    input[type=submit]{
        margin-top: 20px;
        min-width: 50%;
    }
    .custom-file-upload label{
        font-size: 12px;
    }
    .img-md-form{
        display: flex;
        justify-content: space-between;
    }
    .emoj_box{
        display: flex;
        overflow-x: scroll;
    }
    .emoj_box button{ 
        min-width: 40%;
        min-height: 81px;
        background-color: #eeeeee;
        border: none;
    }
    .emoj_box button img{
        height: 75px;
    }
    .preview{
        text-align: left;
        margin-bottom: 20px;
    }
    .anh img{
        height: 100px;
        }
    .anh{
        padding: 5px 0px;
    }
</style>
<center>
    <h1>Edit Chat</h1>
</center>
<div class="addchat">
    <?php
        echo $this->Form->create($t_feed,array('type' => 'file'));
        // Hard code the user for now.
        echo $this->Form->control('id', ['type' => 'hidden']);
        echo $this->Form->control('name', ['value' => $session->read('name'),'disabled'=>'disabled']);
        echo $this->Form->control('message', ['rows' => '3']);
        echo "<label>Current file</label>";
        if($t_feed->image_file_name!=""){
            $file=$t_feed->image_file_name;
            if(substr($file,-3,4)=="mp4" || substr($file,-3,4)=="ogg"){
                echo "<div class='anh'>";
                echo "<video height='100px' controls autoplay preload>
                    <source src='/video/$file' type='video/mp4'>
                    <source src='/video/$file' type='video/ogg'>
                Your browser does not support the video tag.
                </video>
                ";
                // echo $this->Html->media($file, [
                //     'fullBase' => true,
                //     'text' => 'Fallback text'
                // ]);
                echo "</div>";
            }
            else {
                echo "<div class='anh'>";
                echo $this->Html->image($file);
                echo "</div>";
            }
        }
        echo "<div class='img-md-form'>";
        echo "<label class='custom-file-upload'>";
        echo $this->Form->control('Upload_file',['type' => 'file','disabled'=>$dis,'onchange'=>'readURL(this);']);
        echo "</label>";
        echo "</div>";
        echo "<div class='preview'>";
            echo "<img id='blah' src='#' alt=''/>";
            echo "<video id='blah2' height='0px' controls autoplay preload>
                    <source src='#' type='video/mp4'>
                    <source src='#' type='video/ogg'>
                    Your browser does not support the video tag.
                  </video>";
            echo "</div>";
        echo "<div class='emoj_box'>";
        for($count=1;$count<=24;$count++){
            $filename=$count.".png";
            echo"
            <button name= 'stamp_id' value=$count >
                <img src='/img/$filename' alt=''>
            </button>
            ";
        }
        echo"</div>";
        echo "<center>".$this->Form->control('Save Update',['type' => 'submit','disabled'=>$dis])."</center>";
        echo $this->Form->end();
    ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if(ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"){
            reader.onload = function (e) {
            $('#blah').attr('src', e.target.result).height(100);
            $('#blah2').height(0);
        };
        }
        else if(ext == "ogg" || ext == "mp4"){
            reader.onload = function (e) {
            $('#blah2').attr('src', e.target.result).height(100);
            $('#blah').height(0);
        };
        }
    }
    reader.readAsDataURL(input.files[0]);
    }
</script>