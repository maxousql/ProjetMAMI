<?php
require('db.php');
session_start();

if (isset($_POST['connexion'])) {
    $user = isset($_POST['uname']) ? $_POST['uname'] : NULL;
    $pass = isset($_POST['password']) ? $_POST['password'] : NULL;

    if (empty($user)) {
        header("Location: ../index.php?error=Utilisateur requis !");
        exit();
    }else if (empty($pass)){
        header("Location: ../index.php?error=Mot de passe requis !");
        exit();
    }

    $success = false;

    $data = $db->query('SELECT * FROM users INNER JOIN role ON role.idRole = users.Role')->fetchAll();

    foreach ($data as $row) {
        if ($row['name'] == $user) {
            if (password_verify($pass, $row['password'])) {
                $success = true;
                $_SESSION['username'] = $row['name'];
                $_SESSION['role'] = $row['name_role'];
                $_SESSION['idUser'] = $row['idUser'];
                $_SESSION['idRole'] = $row['idRole'];
                break;
            }
        }
    }

    if ($success) {
        header('Location: ../pages/pages_manager/home.php');
        exit();
    } else {
        header("Location: ../index.php?error=Utilisateur ou mot de passe Incorrect !"); 
    }
}
?>