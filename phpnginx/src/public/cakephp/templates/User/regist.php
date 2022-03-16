<center><h1>Regist</h1></center>
<style >
    .box_rs{
        width: 100%;
        text-align: center;
    }
    .box_regist{
        width: 40%;
        margin: auto;
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        border: 2px solid lightblue;
        box-shadow: 2px ;
        text-align: left;
    }
    button{
        min-width: 300px;
        margin: 20px auto;
    }
</style>
<div class="box_rs">
    <div class="box_regist">
        <?php
            echo $this->Form->create($t_user);
            echo $this->Form->control('user_id', ['type' => 'hidden']);
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('name');
            echo "<center>".$this->Form->button(__('Regist'))."</center>";
            echo $this->Form->end();
        ?>
        <center>
        You already have an account,
        <?= $this->Html->link('Login', ['action' => 'login']) ?>
        </center>
    </div>
</div>