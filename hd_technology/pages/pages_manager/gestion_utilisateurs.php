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
    if(!($_SESSION['idRole'] == 1 || $_SESSION['idRole'] == 2)) {
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
                        <a href="gestion_frais.php" class="navigation-link">
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
                        <a href="#" class="navigation-link">
                            <div class="row">
                                <div class="col-2 mt-3">
                                    <i class="bx bx-user icon"></i>
                                </div>
                                <div class="col-10">
                                   Gestion utilisateurs
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item">
                        <a href="../../php/logout.php" class="navigation-link confirmLogout">
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
            <div class="row card">
                <div class="row d-flex">
                    <div class="col-md-3 text-center ">
                        <a class="btn createSegment" data-toggle="modal" data-target="#change_password" name="addFrais" id="addFrais">
                            <i class='bx bx-plus'></i> Ajouter un utilisateur
                        </a>
                    </div>
                    <div class="col-md-9 add_flex">
                        <div class="form-group searchInput">
                            <label>Rechercher</label>
                            <input type="search" class="form-group" id="mySearchText" placeholder=" ">
                        </div>
                    </div>
                </div>
            <table id="listUser" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <td scope="col">Pseudo</td>
                            <td scope="col">Adresse Email</td>
                            <td scope="col">Rôle</td>
                            <td scope="col">Suppression</td>
                            <td scope="col">Gérer</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $data = $db->query('SELECT * FROM users 
                            INNER JOIN role ON role.idRole = users.Role')->fetchAll();

                            foreach ($data as $row) {
                                echo "<tr>
                                <td>".$row['name']."</td>
                                <td>".$row['email']."</td>
                                <td>".$row['name_role']."</td> 
                                <td><a class='btnDeleteUser confirmDelete' id='btnDeleteUser' href='gestion_utilisateurs.php?idf=".$row['idUser']."'><i class='bx bx-trash'></i> Supprimer</a></td> 
                                <td><a class='btnModifyUser' id='btnModifyUser' href='edit.php?idf_e=".$row['idUser']."'><i class='bx bx-pencil' ></i> Gérer</a></td>   
                                </tr>";
                            }
                        ?>
                    </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un utilisateur</h5>
                    </div>
                            <div class="modal-body">
                                <form action="gestion_utilisateurs.php" method="POST">
                                    <label for='user'>Nom d'utilisateur</label>
                                    <input type="text" id="user" name="user" class="form-control" required/>
                                    <br/>
                                    <label for='password'>Adresse Email</label>
                                    <input type="text" id="mail" name="mail" class="form-control"/>
                                    <br/>
                                    <label for='password'>Mot de passe</label>
                                    <input type="password" id="mdp" name="mdp" class="form-control" required/>
                                    <br/>
                                    <label for='role'>Rôle</label>
                                    <select name="role" id="role" class="form-select" required>
                                        <?php
                                        $data = $db->query("SELECT * FROM role")->fetchAll();

                                        foreach ($data as $row) {
                                            echo "<option value=".$row['idRole'].">".$row['name_role']."</option>";
                                        }
                                        ?>
                                    </select>
                                    <br/>
                                    <input type="submit" value="Ajouter" class="btn_add" name="btndb" id="btndb">
                                </form>
                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                            
                    </div>
            </div>
        </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../../js/home.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    

    <script>
    $('.confirmDelete').on('click',function (e) {
        e.preventDefault();
        var self = $(this);
        swal({
            title: "Êtes vous sûr ?",
            text: "Une fois supprimé, vous ne pourrez plus récupérer cet utilisateur !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                swal("Poof!", "Utilisateur supprimé avec succès !", "success", {
                icon: "success",
                }).then(function () {
                location.href = self.attr('href');
            });
            }
        })
    })
    $('.confirmLogout').on('click',function (e) {
        e.preventDefault();
        var self = $(this);
        swal({
            title: "Voulez vous vous déconnecter ?",
            text: "Une fois déconnecter, vous ne pourrez plus accéder à votre espace !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                location.href = self.attr('href');
            }
        })
    })
    </script>

    <script type="text/javascript">
        $(document).ready( function () {
            var table = $('#listUser').DataTable( {
            "scrollX": true,
            "lengthChange": false,
            "pageLength": 8,
            columnDefs: [ {
                "targets": [-1, -2, -3], 
                "className": "text-center",
            }],
            columnDefs: [ {
                "targets": [-1, -2], 
                "orderable": false,
            }],
            "dom":'<"top">ct<"top"p><"clear">',
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "search": "<i class='bx bx-search-alt-2'></i> Rechercher : ",
                "zeroRecords": "Nothing found - sorry",
                "info": "Afficher la page _PAGE_ de _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "<i class='bx bx-right-arrow-alt' ></i>",
                    "previous": "<i class='bx bx-left-arrow-alt'></i>"
                }
            }
        });
        $('#mySearchText').on( 'keyup', function () {
            table.search(this.value).draw();
        });
        });
    </script>
  </body>
</html>