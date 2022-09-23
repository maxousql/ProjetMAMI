<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- Link CSS -->
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Oswald:wght@500&display=swap" rel="stylesheet">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- DataTable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- Title & Icon -->
    <title>HD Technology</title>
    <link rel="icon" type="image/x-icon" href="../../img/hd_techno.png">
  </head>
  <body>
    <?php 
    require('../../php/db.php');
    include('../../php/login.php');
    include('../../php/fonctions.php');
    if(!isset($_SESSION['username'])) {
        header('Location: ../error_401.html');
        session_unset();
        session_destroy();
        die();
    }
    if(!($_SESSION['idRole'] == 1)) {
        header('Location: ../error_403.html');
        session_unset();
        session_destroy();
        die();
    }
    ?>
    <div class="page">
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo-container">
                    <div class="logo-container">
                        <img class="logo-sidebar" src="../../img/hd_techno.png">
                    </div>
                    <div class="brand-name-container">
                        <p class="brand-name">
                            <?php echo $_SESSION['username']?> <br>
                            <span class="job-name">
                            <?php echo $_SESSION['role']?>
                            </span>
                        </p>
                    </div>

                </div>
            </div>
            <div class="sidebar-body">
                <ul class="navigation-list">
                    <li class="navigation-list-item">
                        <a href="home.php" class="navigation-link">
                            <div class="row">
                                <div class="col-2">
                                    <i class="bx bx-home-alt icon"></i>
                                </div>
                                <div class="col-10">
                                    Accueil
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a href="frais.php" class="navigation-link">
                            <div class="row">
                                <div class="col-2">
                                    <i class="bx bx-bar-chart-alt-2 icon"></i>
                                </div>
                                <div class="col-10">
                                    Mes frais
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a href="#" class="navigation-link">
                            <div class="row">
                                <div class="col-2">
                                    <i class="bx bx-pie-chart-alt icon"></i>
                                </div>
                                <div class="col-10">
                                   Gestion des frais
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item active">
                        <a href="gestion_utilisateurs" class="navigation-link" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="row">
                            <div class="col-2 mt-3">
                                    <i class="bx bx-user icon"></i>
                                </div>
                                <div class="col-10">
                                   Gestion utilisateurs
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu fade-in" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="manage_users/add_user.php"><i class="bx bx-user-plus icon"></i> Ajouter un utilisateur</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bx bx-user-minus icon"></i> Supprimer un utilisateur</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bx bx-user-circle icon"></i> Gérer les utilisateurs</a></li>
                          </ul>
                    </li>
                    <li class="navigation-list-item">
                        <a href="../../php/logout.php" class="navigation-link">
                            <div class="row">
                                <div class="col-2">
                                    <i class="bx bx-log-out icon"></i>
                                </div>
                                <div class="col-10">
                                   Déconnexion
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <hr style="margin-top: 30px; color:white;">
            </div>
        </div>
        <div class="content">
            <div class="navigation-bar">
                <button id="sidebarToggle" class="btn sidebarToggle">
                    <i class="bx bx-list-ul bx-sm"></i>
                </button>
            </div>
        </div>
    </div>
        <div class="container mt-3">
            <a id="sidebarToggle" class="btn sidebarToggle" href="gestion_utilisateurs.php">
                <p><i class='bx bx-arrow-back'></i> Retour</p>
            </a>
        <form action="edit.php?<?php echo "idf_e=", $_GET['idf_e']?>" method="POST">
            <label for='user'>Identifiant</label>
            <input type="text" id="idUser" name="idUser" class="form-control" readonly="readonly" value="<?php echo $_GET['idf_e']?>"/>
                <br/>
            <label for='user'>Nom d'utilisateur</label>
            <input type="text" id="modifyUser" name="modifyUser" class="form-control" value="<?php echo $row['name'] ?>"/>
                <br/>
            <label for='user'>Adresse Email</label>
            <input type="text" id="modifyMail" name="modifyMail" class="form-control"  value="<?php echo $row['email']?>"/>
                <br/>
            <label for='password'>Nouveau mot de passe</label>
            <input type="password" id="modifyMdp" name="modifyMdp" class="form-control" placeholder="Nouveau mot de passe"/>
                <br/>
            <label for='role'>Rôle</label>
            <select name="modifyRole" id="modifyRole" class="form-select">
                <option value="<?php echo $row['idRole']?>"><?php echo $row['name_role']?></option>
                <?php
                    $data = $db->query("SELECT * FROM role")->fetchAll();

                    foreach ($data as $row) {
                        echo "<option value=".$row['idRole'].">".$row['name_role']."</option>";
                    }
                ?>
            </select>
            <br />
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <input type="submit" value="Modifier" class="btn_add" name="modif">
                </div>
            </div>
                
            </form>
        </div>
    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    
    <script src="../../js/home.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
       $(document).ready( function () {
       $('#table_id').DataTable();
    } );
    </script>
  </body>
</html>