<!-- File: templates/Articles/index.php  (delete links added) -->
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
        .box{
            display: flex;
            width: 100%;
            padding: 20px;
        }
        .item{
            border-radius: 10px;
            border: 2px solid lightblue;
            background-color: #fff;
            justify-content: space-around;
            margin: 10px;
            padding: 20px;
        }
        .item_1{
            flex: 3;
            max-height: 350px;
            overflow: hidden;
        }
        .item_2{
            flex: 7;
            overflow-y: scroll;
            overflow-x: hidden;
            max-height: 74vh;
        }
        .edite{
            overflow: hidden;
        }
        .headchat{
            width: 100%;
            background-color: lightblue;
            border-radius: 5px 5px 0px 0px;
            margin: 0px 5px 10px 5px;
            text-align: center;
            padding: 10px;
            box-sizing: border-box;
        }
        .headchat h2{
            margin: auto;
        }
        .disabled {
            pointer-events: none;
            cursor: default;
            opacity: 0.6;
        }
</style>
<div style="padding: 0px 33px;" class="<?php echo $dis;?>">
    <p><?= $this->Html->link("Add Chat", ['action' => 'add']) ?></p>
</div>
<div class="box">
    <div class="item item_1">
        <?php
            // if($session->read('email') != "" && $session->read('name') != ""){
            //     echo '<script type = "text/javascript">';
            //     echo 'alert("Login Successfull.");';
            //     echo '</script>';
            // }
            echo $this->Form->create(NULL,array('url'=>'chat/add'));
            echo $this->Form->control('id', ['type' => 'hidden']);
            echo $this->Form->control('name');
            echo $this->Form->control('message', ['rows' => '3']);
            //echo $this->Form->control('create_at',['value'=> getdate(),'type' => 'hidden']);
            echo "<center>".$this->Form->control('Send Chat',['type' => 'submit','disabled'=>$dis])."</center>";
            echo $this->Form->end();
        ?>
    </div>
    <div class="item item_2">
        <div class="headchat">
            <h2>Chat box</h2>
        </div>
        <style>
            .khung{
                width:100%;
                padding: 10px;
                display: flex;
                justify-content: space-around;
                border: 1px solid lightgray;
                border-radius: 5px;
                margin: 5px;
                position: relative;
            }
            .anhdd{
                flex: 1;
                padding: 10px;
            }
            .chatmain{
                flex: 9;
                padding: 5px;
            }
            .avatar{
                border-radius: 50%;
                width: 50px;
            }
            .usname{
                color: #436475;
                font-weight: bold;
                font-size: 18px;
            }
            .crat{
                font-size: 12px;
                /* position: absolute;
                top:0;
                right: 0; */
            }
            .mess{
                color: #606c76;
                font-size: 16px;
            }
            .edite{
                padding-right: 10px;
                font-size: 16px;
            }
        </style>
        <!-- Here's where we iterate through our $articles query object, printing out article info -->
        <?php foreach ($t_feed as $t_feed): ?>
            <div class="khung">
            <div class="dropdown anhdd" tabindex="0">
                <img class="avatar" src="https://24s.vn/anh-dai-dien-cho-facebook-de-thuong/imager_3918.jpg" alt="" />
            </div>
            <div class="chatmain">
                <div>
                    <div class="usname"><?php echo $t_feed->name ?></div>
                </div>
                <div class="mess">
                    <?= $this->Html->link($t_feed->message, ['action' => 'view', $t_feed->id]) ?>
                </div>
                <div class="crat">
                    Create at:
                    <?= $t_feed->create_at->format(DATE_RFC850) ?>
                </div>
                <div class="crat">
                    Update at:
                    <?= $t_feed->update_at->format(DATE_RFC850) ?>
                </div>
                <div class="<?php echo $dis;?>">
                    <span class="edite">
                        <?= $this->Html->link('Edit', ['action' => 'edit', $t_feed->id]) ?>
                    </span>
                    <span class="edite">
                        <?= $this->Form->postLink(
                            'Delete',
                            ['action' => 'delete','class'=>'edite', $t_feed->id],
                            ['confirm' => 'Are you sure?'])
                        ?>
                    </span>
                </div>
            </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</table>