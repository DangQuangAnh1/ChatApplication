<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <style>
        .top-nav{
            min-width: 100%;
            background-color: lightblue;
        }
        .top-nav-title{
            padding-left: 100px;
        }
        .top-nav-links{
            padding-right: 100px;
        }
        .container{
            min-width: 100%;
            padding: 20px 50px 50px 50px;
            min-height: 74vh;
        }
        footer{
            width: 100%;
            height: 100px;
            background-color: lightblue;
        }
        .hi{
            position: relative;
        }
        .hi:hover .log_out{
            display: block;
        }
        .log_out{
            display: none;
            position: absolute;
            padding: 10px 20px;
            background-color: white;
            border-radius: 5px;
            top: 16px;
            right: -50px;
            animation: hi ease 0.5s;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        }
        @-webkit-keyframes hi {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .user_name{
            font-size: 16px;
            font-weight: bolder;
        }
    </style>
    <nav class="top-nav">
        <div class="top-nav-title">
            <span>
                <img src="https://www.inquangcaopcm.com/upload/images/12.png" alt="logo" style="width: 50px;">
            </span>
            <a href="<?= $this->Url->build('/chat') ?>"><span>WEB</span>CHAT</a>
        </div>
        <div class="top-nav-links">
            <?php
                $session = $this->request->getSession();
                $email="";
                $name="";
                $email=$session->read('email');
                $name=$session->read('name');
                if($email == "" && $name == ""){
                    echo "            
                    <a target='_self' rel='noopener' href='/user/login'>Login</a>
                    <a target='_self' rel='noopener' href='/user/regist'>Regist</a>
                    ";
                }
                else{
                    echo "
                    <span class='hi'>
                        <span class='user_name'>Hello: ".$name."</span>
                        <div class='log_out'>
                            <a href='user/login'>Logout</a>
                        </div>
                    </span>
                    ";
                }
            ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
