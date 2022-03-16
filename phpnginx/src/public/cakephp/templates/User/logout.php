
<?php
$session = $this->getRequest()->getSession();
$session->delete('email');
$session->delete('name');
echo '<script type = "text/javascript">';
echo 'window.location.href = "/User/login" ';
echo '</script>';
?>