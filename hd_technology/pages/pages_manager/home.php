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

        <!---- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
        
        <!-- DataTable -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

        <!-- Sweet Alert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
        <!-- Title & Icon -->
        <title>HD Technology</title>
        <link rel="icon" type="image/x-icon" href="../../img/hd_techno.png">
    </head>
    <body>
        <?php 
        // CONNEXION BDD
        require('../../php/db.php');

        // RECUP INFO USER
        include('../../php/login.php');

        // VERIF SESSION EXISTE
        if(!isset($_SESSION['username'])) {
            header('Location: ../error_401.html');
            session_unset();
            session_destroy();
            die();
        }
        ?>
    
    <!-- START NAVBAR -->
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
                    <li class="navigation-list-item active">
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
                    <?php
                    if ($_SESSION['idRole'] == 1 || $_SESSION['idRole'] == 2) {
                        echo "<li class='navigation-list-item'>
                        <a href='gestion_frais.php' class='navigation-link'>
                            <div class='row'>
                                <div class='col-2'>
                                    <i class='bx bx-pie-chart-alt icon'></i>
                                </div>
                                <div class='col-10'>
                                   Gestion des frais
                                </div>
                            </div>
                        </a>
                    </li>";
                    }
                    if ($_SESSION['idRole'] == 1) {
                        echo "<li class='navigation-list-item'>
                        <a href='gestion_utilisateurs.php' class='navigation-link'>
                            <div class='row'>
                                <div class='col-2 mt-3'>
                                    <i class='bx bx-user icon'></i>
                                </div>
                                <div class='col-10'>
                                   Gestion utilisateurs
                                </div>
                            </div>
                        </a>
                    </li>";
                    }
                    ?>
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
        <!-- END NAVBAR -->
        
        <!-- START CONTAINER -->
        <div class="container">
            <div class="row cardHome">
                <div class="col-md-8 ">
                    <!-- START TABLE FRAIS -->
                    <h1 class="titleFrais">Mes frais</h1>
                    <div class="row d-flex">
                        <div class="col-md-2"></div>
                        <div class="col-md-10 add_flex">
                            <div class="form-group searchInput">
                                <label>Rechercher</label>
                                <input type="search" class="form-group" id="mySearchText" placeholder=" ">
                            </div>
                        </div>
                    </div>
                    <table id="frais" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <td scope="col">Date</td>
                                <td scope="col">Montant</td>
                                <td scope="col">Type</td>
                                <td scope="col">Etat</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $data = $db->query('SELECT * FROM frais 
                                INNER JOIN typefrais ON typefrais.idTypeFrais = frais.type 
                                INNER JOIN etatfrais ON etatfrais.idEtatFrais = frais.etat 
                                WHERE idUser = '.$_SESSION['idUser'].'')->fetchAll();

                                foreach ($data as $row) {
                                    echo "<tr>
                                    <td>".$row['date']."</td>
                                    <td>".$row['montant']."€</td>
                                    <td>".$row['name_typefrais']."</td>
                                    <td>".$row['name']."</td>
                                    </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                        <!-- END TABLE FRAIS -->
                </div>
                <!-- START GRAPH -->
                <div class="col-md-4">
                    <div class="" style="position: relative; height:20vh; width:20vw">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                <!-- END GRAPH -->
            </div>
               
        </div>
    </div>
    <!-- END CONTAINER -->

    <!-- RECUP INFO GRAPH -->
    <?php
        $data = $db->query('SELECT * FROM typefrais')->fetchAll();
        foreach ($data as $row) {
            $color[] = $row['color'];
        }
        $data2 = $db->query('SELECT SUM(f.montant), tf.name_typefrais FROM typefrais tf 
        INNER JOIN frais f ON f.type = tf.idtypefrais WHERE idUser = '.$_SESSION['idUser'].' GROUP BY name_typefrais desc')->fetchAll();

        foreach ($data2 as $row) {
            $typeName[] = $row['name_typefrais'];
            $montant[] = $row['SUM(f.montant)'];
        }

    ?>

    <!-- CONFIG GRAPH -->
    <script>
        const labels = <?php echo json_encode($typeName) ?>;
        const colors = <?php echo json_encode($color) ?>;
        const montant = <?php echo json_encode($montant) ?>;
        const data = {
        labels: labels,
        
        datasets: [{
            label: 'My First Dataset',
            data: montant,
            backgroundColor: colors,
            hoverOffset: 4
        }]
        };

        const config = {
            type: 'pie',
            data: data,
        };

        module.exports = {
            actions: [],
            config: config,
        };
    </script>
    
    <!-- JS -->
    <script src="../../js/home.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- DATATABLE FRAIS -->
    <script type="text/javascript">
        $(document).ready( function () {
            var table = $('#frais').DataTable( {
            "scrollX": true,
            "lengthChange": false,
            "pageLength": 5,
            columnDefs: [ {
                "targets": [-1], 
                "className": "text-center",
            }],
            "dom":'<"top">ct<"top"p><"clear">',
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "search": "<i class='bx bx-search-alt-2'></i> Rechercher : ",
                "zeroRecords": "Aucun",
                "info": "Afficher la page _PAGE_ de _PAGES_",
                "infoEmpty": "",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "<i class='bx bx-right-arrow-alt' ></i>",
                    "previous": "<i class='bx bx-left-arrow-alt'></i>"
                }
            }
        }   );
        $('#mySearchText').on( 'keyup', function () {
            table.search(this.value).draw();
        });
        }   );
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
    
    <!-- INITIALISATION GRAPH -->
    <script>
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
  </body>
</html>