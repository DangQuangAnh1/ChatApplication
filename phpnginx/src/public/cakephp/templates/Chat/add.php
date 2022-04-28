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
    .addchat {
        width: 40%;
        margin: auto;
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        border: 2px solid lightblue;
        box-shadow: 2px;
        text-align: left;
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
        margin: 20px 0 1.5rem;
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
        justify-content: space-between;
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
</style>
<center>
    <h1>Add Chat</h1>
</center>
<div class="addchat">
    <?= $this->Form->create(NULL, array('url' => 'chat/add', 'type' => 'file')) ?>
    <?= $this->Form->control('id', ['type' => 'hidden']) ?>
    <?= $this->Form->control('name', ['value' => $session->read('name'), 'disabled' => 'disabled']) ?>
    <?= $this->Form->control('message', ['rows' => '3']) ?>
    <div class='img-md-form'>
        <label class='custom-file-upload'>
            <?= $this->Form->control('Upload_file', ['type' => 'file', 'disabled' => $is_disable_class, 'onchange' => 'readURL(this);']) ?>
        </label>
    </div>
    <div class='emoj_box'>
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