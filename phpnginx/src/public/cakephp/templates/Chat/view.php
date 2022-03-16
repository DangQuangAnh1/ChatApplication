<?php
$session = $this->request->getSession();
if($session->read('email') != "" && $session->read('name') != ""){
    $dis='enabled';
}
else{
    $dis='disabled';
}
?>
<style>
    .disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6;
    }
</style>
<h1>View Chat</h1>
<h1><?= h($t_feed->name) ?></h1>
<p><?= h($t_feed->message) ?></p>
<p><small>Create_at: <?= $t_feed->create_at->format(DATE_RFC850) ?></small></p>
<p><small>Update_at: <?= $t_feed->update_at->format(DATE_RFC850) ?></small></p>
<p class="<?php echo $dis;?>"><?= $this->Html->link('Edit', ['action' => 'edit', $t_feed->id]) ?></p>