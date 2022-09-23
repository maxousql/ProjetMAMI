<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
// CONNEXION BDD
require('db.php');

// GESTION USER

// ADD USER
$success = 0;

if (isset($_POST['user']) && isset($_POST['mdp']) && isset($_POST['role']) && isset($_POST['mail'])) {
    $username = $_POST['user'];
    $email = $_POST['mail'];
    $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT); 
    $role = $_POST['role'];

    $stmt = $db->prepare("INSERT INTO users(name, email, password, Role) VALUES (:name, :email, :password, :Role)");

    $stmt->bindParam(':name', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':Role', $role);

    $stmt->execute();
    $success = 1;
    if ($success == 1) {
        ?>
        <script>
            swal("Utilisateur ajouté avec succès !", "", "success").then(function () {
                window.location.href = "../pages_manager/gestion_utilisateurs.php";
            });
        </script>
        <?php
    }
}
?>

<?php
// DELETE USER
function deleteUser($idf) {
    $db = new PDO('mysql:host=maximenlylt.mysql.db;dbname=maximenlylt;charset=utf8mb4', 'maximenlylt', 'Maxime140902');
    $db->query("DELETE FROM users WHERE idUser = $idf");
}

if (isset($_GET['idf'])) {
    deleteUser($_GET['idf']);   
}
?>

<?php
// MODIFY USER
$success = 0;
if (isset($_GET['idf_e'])) {
    $idf_e = $_GET['idf_e'];
    $res = $db->query("SELECT * FROM users 
    INNER JOIN role ON role.idRole = users.Role 
    WHERE idUser = '$idf_e'")->fetchAll();
    foreach ($res as $row) {
        
    }
}

if (isset($_POST['modif']) && isset($_GET['idf_e'])) {
    $idf_e = $_GET['idf_e'];
    $username = $_POST['modifyUser'];
    $email = $_POST['modifyMail'];
    // $password = $_POST['modifyMdp'];
    $role = $_POST['modifyRole'];
    
    if ($_POST['modifyMdp'] != NULL) {
        $password = password_hash($_POST['modifyMdp'], PASSWORD_BCRYPT); 
    } else {
        $password = $row['password'];
    }

    $row['name'] = $username;
    $row['email'] = $email;
    $row['password'] = $password;
    $row['Role'] = $role;

    $db->query("UPDATE users SET name='$username', email='$email', password='$password', Role='$role' WHERE idUser =$idf_e");

    $success = 1;
    if ($success == 1) {
        ?>
        <script>
            swal("Utilisateur modifié avec succès !", "", "success");
        </script>
        <?php
    }
}
?>

<?php
// GESTION DE FRAIS

// ADD FRAIS
if (isset($_POST['addFrais'])) {
    $idUser = $_SESSION['idUser'];
    $date = $_POST['dateFrais'];
    $montant = $_POST['montantFrais'];
    $type = $_POST['typeFrais'];
    $etat = 2;

    $stmt = $db->prepare("INSERT INTO frais(idUser, date, montant, type, etat) VALUES (:idUser, :date, :montant, :type , :etat)");

    $stmt->bindParam(':idUser', $idUser);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':montant', $montant);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':etat', $etat);

    $stmt->execute();

    if (!empty($_FILES['pjFrais'])) {
        $data = $db->query("SELECT * FROM frais WHERE idFrais = (SELECT MAX(idFrais) FROM frais)");
        foreach ($data as $row) {
        }
        $idFrais = $row['idFrais'];

        $nameFile = $_FILES['pjFrais']['name'];
        $typeFile = $_FILES['pjFrais']['type'];
        $sizeFile = $_FILES['pjFrais']['size'];
        $tmpFile = $_FILES['pjFrais']['tmp_name'];
        $errFile = $_FILES['pjFrais']['error'];
        
        $extensions = ['png', 'jpg', 'jpeg'];
        $type = ['image/png', 'image/jpg', 'image/jpeg'];
        $extension = explode('.', $nameFile);
        $max_size = 500000;
        
        if(in_array($typeFile, $type))
        {
            if(count($extension) <= 2 && in_array(strtolower(end($extension)), $extensions))
            {
                if($sizeFile <= $max_size && $errFile == 0)
                {
                    if(move_uploaded_file($tmpFile, '../../uploadFrais/' . $idFrais . '-' . $_SESSION['username'] . '.' . strtolower(end($extension)))) {
                        $srcImg = $idFrais . '-' . $_SESSION['username'] . '.' . strtolower(end($extension));
                        $db->query("UPDATE frais SET srcImg='$srcImg' WHERE idFrais = $idFrais");
                    }
                }   
            }   
        }
    }
    
    header('Location: ../pages_manager/frais.php');
}
?>

<?php
// MODIFY FRAIS
$success = 0;
if (isset($_GET['idf_frais'])) {
    $idf_frais = $_GET['idf_frais'];
    $res = $db->query("SELECT * FROM frais 
    INNER JOIN typefrais ON typefrais.idTypeFrais = frais.type 
    INNER JOIN etatfrais ON etatfrais.idEtatFrais = frais.etat 
    WHERE idFrais = '$idf_frais'")->fetchAll();
    foreach ($res as $row) {
        
    }
}

if (isset($_POST['modif']) && isset($_GET['idf_frais'])) {
    $idf_frais = $_GET['idf_frais'];
    $date = $_POST['dateFrais'];
    $montant = $_POST['montantFrais'];
    $type = $_POST['typeFrais'];
    $etat = $_POST['etatFrais'];
    
    $row['date'] = $date;
    $row['montant'] = $montant;
    $row['name_typefrais'] = $type;
    $row['name'] = $etat;

    $db->query("UPDATE frais SET date='$date', montant='$montant', type='$type', etat='$etat' WHERE idFrais =$idf_frais");

    $success = 1;
    if ($success == 1) {
        ?>
        <script>
            swal("Frais modifié avec succès !", "", "success");
        </script>
        <?php
        
    }
}
?>

<?php
// DELETE FRAIS
if (isset($_GET['idf_f'])) {
    deleteFrais($_GET['idf_f']);
}

function deleteFrais($idf_f) {
    $db = new PDO('mysql:host=maximenlylt.mysql.db;dbname=maximenlylt;charset=utf8mb4', 'maximenlylt', 'Maxime140902');
    $db->query("DELETE FROM frais WHERE idFrais = $idf_f");
} 
?>
<?php
// ACCEPT FRAIS
if (isset($_GET['idf_v'])) {
    $idf_v = $_GET['idf_v'];
    $etat = 1;

    $db->query("UPDATE frais SET etat='$etat' WHERE idFrais =$idf_v");
    ?>
    <script>
        swal("Frais validé avec succès !", "", "success");
       
    </script>
<?php
}

// REFUS FRAIS
if (isset($_GET['idf_r'])) {
    $idf_r = $_GET['idf_r'];
    $etat = 3;

    $db->query("UPDATE frais SET etat='$etat' WHERE idFrais =$idf_r");
    ?>
    <script>
        swal("Frais refusé avec succès !", "", "success");
       
    </script>
    <?php
}

// ADD TYPE 
if (isset($_POST['addType'])) {
    $name = $_POST['nomType'];
    $color = $_POST['colorType'];

    $stmt = $db->prepare("INSERT INTO typefrais(name_typefrais, color) VALUES (:name_typefrais, :color)");

    $stmt->bindParam(':name_typefrais', $name);
    $stmt->bindParam(':color', $color);

    $stmt->execute();
    
    header('Location: ../pages_manager/gestion_frais.php');   
}