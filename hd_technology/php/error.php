<?php
if(!isset($_SESSION['username'])) {
        header('Location: ../error_401.html');
        session_unset();
        session_destroy();
        die();
    }
    if ($_SESSION['idRole'] != 1) {
        header('Location: ../error_403.html');
        session_unset();
        session_destroy();
        die();
    }
?>