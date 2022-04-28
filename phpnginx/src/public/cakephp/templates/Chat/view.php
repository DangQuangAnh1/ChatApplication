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
    .disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6;
    }

    p {
        margin: 5px 0px;
    }

    .anh {
        height: 100px;
    }
</style>
<h1>View Chat</h1>
<h2>User name: <?= h($session->read('name')) ?></h2>
<p>Emoji: </p>
<img src="<?php echo "/img/$t_feed->stamp_id.png"; ?>" class="anh">
<p>Message: <?= h($t_feed->message) ?></p>
<p>File upload: </p>
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
<p><small>Create_at: <?= $t_feed->create_at->format(DATE_RFC850) ?></small></p>
<p><small>Update_at: <?= $t_feed->update_at->format(DATE_RFC850) ?></small></p>
<p class="<?php echo $is_disable_class; ?>"><?= $this->Html->link('Edit', ['action' => 'edit', $t_feed->id]) ?></p>