<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<?php
$session = $this->request->getSession();
if ($session->read('email') != "" && $session->read('name') != "") {
    $is_disable_class = 'enabled';
} else {
    $is_disable_class = 'disabled';
}
$user_id = $session->read('user_id');
?>
<style>
    .box {
        display: flex;
        width: 100%;
        padding: 20px;
    }

    .item {
        border-radius: 10px;
        border: 2px solid lightblue;
        background-color: #fff;
        justify-content: space-around;
        margin: 10px;
        padding: 20px;
    }

    .item_1 {
        flex: 3;
        overflow: hidden;
    }

    .item_2 {
        flex: 7;
        overflow-y: scroll;
        overflow-x: hidden;
        max-height: 74vh;
        overflow: -moz-scrollbars-none;
        -ms-overflow-style: none;
    }
    
    .item_2::-webkit-scrollbar { 
        width: 0 !important;
        display: none; 
    }

    .feature {
        overflow: hidden;
    }

    .headchat {
        width: 100%;
        background-color: lightblue;
        border-radius: 5px 5px 0px 0px;
        margin: 0px 5px 10px 5px;
        padding: 10px;
        box-sizing: border-box;
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .headchat h2 {
        text-align: left;
        flex: 1;
        margin: auto 10px;
    }

    .headchat div {
        text-align: right;
    }

    .disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6.mm;
    }

    input[type=file] {
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
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap;
        min-width: 40%;
    }

    <?php
    if ($is_disable_class != "disabled") {
        echo "
            .custom-file-upload :hover{
                border-radius: .4rem;
                background-color: rgb(133,133,133);
            }";
    }
    ?>
    
    input[type=submit] {
        margin-top: 20px;
        min-width: 50%;
    }

    .custom-file-upload label {
        font-size: 12px;
    }

    .img-md-form {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .preview {
        text-align: right;
        margin-bottom: 20px;
    }

    .frame {
        width: 100%;
        padding: 10px;
        display: flex;
        justify-content: space-around;
        border: 1px solid lightgray;
        border-radius: 5px;
        margin: 5px;
        position: relative;
    }

    .avatar {
        flex: 1;
        padding: 5px;
        border-radius: 50%
    }

    .chatmain {
        flex: 9;
        padding: 5px;
        position: relative;
        overflow: hidden;
    }

    .m_avatar {
        border-radius: 50%;
        width: 50px;
        margin: 0px 2px;
    }

    .a_name {
        display: none;
        margin: 0px 2px;
        padding: 2px 10px;
        text-align: center;
        position: absolute;
        top: -10px;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 2px;
        color: white;
    }

    .user_head:hover .a_name {
        display: block;
    }

    .usname {
        color: #436475;
        font-weight: bold;
        font-size: 18px;
    }

    .crat {
        font-size: 12px;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .mess {
        color: #606c76;
        font-size: 16px;
        max-width: 60%;
    }

    .feature {
        padding-right: 10px;
        font-size: 16px;
    }

    .anh img {
        height: 100px;
    }

    .anh {
        padding: 5px 0px;
    }

    .emoj_box {
        display: flex;
        overflow-x: scroll;
    }

    .emoj_box button {
        min-width: 40%;
        min-height: 81px;
        background-color: #eeeeee;
        border: none;
    }

    .emoj_box button img {
        height: 75px;
    }

    .emoj_box button :hover {
        opacity: 0.5;
    }
</style>
<div style="padding: 0px 33px;" class="<?php echo $is_disable_class; ?>">
    <p><?= $this->Html->link("Add Chat", ['action' => 'add']) ?></p>
</div>
<div class="box">
    <div class="item item_1">
        <?= $this->Form->create(NULL, array('url' => 'chat/add', 'type' => 'file')) ?>
        <?= $this->Form->control('id', ['type' => 'hidden']) ?>
        <?= $this->Form->control('name', ['value' => $session->read('name'), 'disabled' => 'disabled']) ?>
        <?= $this->Form->control('message', ['rows' => '3']) ?>
        <div class='img-md-form'>
            <label class='custom-file-upload'>
                <?= $this->Form->control('Upload_file', ['type' => 'file', 'disabled' => $is_disable_class, 'onchange' => 'readURL(this);']) ?>
            </label>
        </div>
        <div class='preview'>
            <!-- image preview -->
            <img id='blah' src='#' alt='' />
            <!-- video preview -->
            <video id='blah_video' height='0px' controls autoplay preload>
                <source src='#' type='video/mp4'>
                <source src='#' type='video/ogg'>
                Your browser does not support the video tag.
            </video>
        </div>
        <div class='emoj_box <?= $is_disable_class ?>'>
            <?php
            for ($count = 1; $count <= 24; $count++) {
                $filename = $count . ".png";
                echo "
                    <button name= 'stamp_id' value=$count >
                        <img src='/img/$filename' alt=''>
                    </button>
                ";
            }
            ?>
        </div>
        <center>
            <?= $this->Form->control('Send Chat', ['type' => 'submit', 'disabled' => $is_disable_class]) ?>
        </center>
        <?= $this->Form->end() ?>
    </div>
    <div class="item item_2">
        <div class="headchat">
            <h2>Chat box</h2>
            <?php
            foreach ($t_user as $t_user) :
                echo "
                <div class='user_head'>
                    <img class='m_avatar' src='https://24s.vn/anh-dai-dien-cho-facebook-de-thuong/imager_3918.jpg' alt='' />
                    <div class= 'a_name'>$t_user->name</div>
                </div>
                ";
            endforeach;
            ?>
        </div>
        <?php foreach ($t_feed as $t_feed) : ?>
            <div class="frame">
                <div class="dropdown avatar" tabindex="0">
                    <img class="avatar" src="https://24s.vn/anh-dai-dien-cho-facebook-de-thuong/imager_3918.jpg" alt="" />
                </div>
                <div class="chatmain">
                    <div>
                        <div class="usname"><?php echo $t_feed->name ?></div>
                    </div>
                    <div class="mess">
                        <img src="<?php echo "img/" . $t_feed->stamp_id . ".png"; ?>" alt="">
                        <div class="<?php echo $is_disable_class; ?>">
                            <div>
                                <?= $t_feed->message ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($t_feed->image_file_name != "") {
                        $file = $t_feed->image_file_name;
                        if (substr($file, -3, 4) == "mp4" || substr($file, -3, 4) == "ogg") {
                            echo "<div class='anh'>";
                            echo "<video height='100px' controls preload>
                            <source src='/video/$file' type='video/mp4'>
                            <source src='/video/$file' type='video/ogg'>
                        Your browser does not support the video tag.
                        </video>
                        ";
                            echo "</div>";
                        } else {
                            echo "<div class='anh'>";
                            echo $this->Html->image($file);
                            echo "</div>";
                        }
                    }
                    ?>
                    <div class="crat">
                        <div>
                            Create at:
                            <?= $t_feed->create_at->format(DATE_RFC850) ?>
                        </div>
                        <div>
                            Update at:
                            <?= $t_feed->update_at->format(DATE_RFC850) ?>
                        </div>
                    </div>
                    <div class="<?php echo $is_disable_class; ?>" style="margin-top: 10px; padding-top:10px; border-top:1px solid #d3d3d3;">
                        <?php
                        if ($t_feed->user_id == $session->read('user_id')) {
                            echo "<span class='feature'>";
                            echo $this->Html->link('View', ['action' => 'view', $t_feed->id]);
                            echo "</span>";
                            echo "<span class='feature'>";
                            echo $this->Html->link('Edit', ['action' => 'edit', $t_feed->id]);
                            echo "</span>";
                            echo "<span class='feature'>";
                            echo $this->Form->postLink(
                                'Delete',
                                ['action' => 'delete', 'class' => 'feature', $t_feed->id],
                                ['confirm' => 'Are you sure?']
                            );
                            echo "</span>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg") {
                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result).height(100);
                    $('#blah_video').height(0);
                };
            } else if (ext == "ogg" || ext == "mp4") {
                reader.onload = function(e) {
                    $('#blah_video').attr('src', e.target.result).height(100);
                    $('#blah').height(0);
                };
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
</script>