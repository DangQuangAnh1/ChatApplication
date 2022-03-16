<!-- File: templates/Articles/add.php -->

<h1>Add Chat</h1>
<?php
    echo $this->Form->create($t_feed);
    // Hard code the user for now.
    echo $this->Form->control('id', ['type' => 'hidden']);
    echo $this->Form->control('name');
    echo $this->Form->control('message', ['rows' => '3']);
    // echo $this->Form->control('create_at',['value'=> getdate()],['type' => 'hidden']);
    echo $this->Form->button(__('Send Chat'));
    echo $this->Form->end();
?>