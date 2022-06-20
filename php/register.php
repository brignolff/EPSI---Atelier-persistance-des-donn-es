<?php
session_start();
include('../db/loginDb.php');
header( 'content-type: text/html; charset=utf-8' );



// Si la variable "$_Post" contient des informations alors on les traitres
if (!empty($_POST)) {
    extract($_POST);
    $valid = true;

    $identifiant = htmlentities(trim($identifiant)); // On récupère le identifiant
    $id_pays = $_POST['id_pays'];

    if (empty($identifiant)) {
        $valid = false;
        $er_name = "L'identifiant ne peut pas être vide !";
    }
    if (empty($id_pays)) {
        $valid = false;
        $er_name = "Vous devez choisir un pays !";
    }else{
        // On vérifit que le mail est disponible
        $req_employe = $DB->query(
            "SELECT Id,Identifiant,Id_Pays FROM Employes WHERE Identifiant = ? AND Id_Pays = ?",
            array($identifiant,$id_pays)
        );
        $req_employe = $req_employe->fetch();
        if ($req_employe['Identifiant'] <> "") {
            $_SESSION['id_user'] = $req_employe['Id'];
            $_SESSION['pseudo'] = $req_employe['Identifiant'];
            $valid = false;
            header('Location: formDemande.php');
        }
    }

    // Si toutes les conditions sont remplies alors on fait le traitement
    if ($valid) {
        $DB->insert("INSERT INTO Employes (Identifiant, Id_Pays) VALUES (?, ?)", array($identifiant, $id_pays));

        $req_employe = $DB->query(
            "SELECT Id,Identifiant,Id_Pays FROM Employes WHERE Identifiant = ? AND Id_Pays = ?",
            array($identifiant,$id_pays)
        );
        $req_employe = $req_employe->fetch();
        $_SESSION['id_user'] = $req_employe['Id'];
        $_SESSION['pseudo'] = $req_employe['Identifiant'];
        header('Location: formDemande.php');

    }
}
?>
<!DOCTYPE html>

<html>


<head>
    <title>Inscription</title>

    <meta charset="utf-8">
    <html lang="fr">
    <link rel="stylesheet" href="../css/register.css" />
    <link rel="icon" type="image/png" href="../src/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <img src="http://dpp-kkdb.com/wp-content/uploads/2016/07/person-icon-blue-18.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            Gestion du parc Informatique
        </div>
        <form method="post" action="#" class="p-3 mt-3">
        <label style="color: red;font-size:15px"><?= $er ?></label>
        <?php
                    if (isset($er_identifiant)) {
                ?>
                        <label style="color: red;font-size:15px"><?= $er_identifiant ?>
                        </label>
                <?php
                    }
                ?>
        <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" placeholder="Votre identifiant" name="identifiant" value="<?php if (isset($identifiant)) {
                                                                                                    echo $identifiant;
                                                                                                } ?>" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <?php
                    if(empty($id_pays)) {
                    ?>
                        <select required name="id_pays" class="form-control form-control-lg" id="inputGroupSelect01" >
                            <option value="" selected>Sélectionner votre pays</option>
                            <?php
                            $req_cat = $DB->query("SELECT * FROM PaysFiliales");
                            $req_cat = $req_cat->fetchALL();
                            foreach ($req_cat as $rc) {
                            ?>
                            <option value="<?= $rc['Id'] ?>"><?= $rc['NomPays'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php   
                    } else { 
                    ?>
                        <select required name="id_pays" class="form-control form-control-lg" id="inputGroupSelect01" >
                        <option value="" selected>Sélectionner la marque votre voiture</option>
                        <?php
                        $req_cat = $DB->query("SELECT Id,NomPays FROM PaysFiliales WHERE Id = '$id_pays' ");
                        $rc = $req_cat->fetchALL();
                        ?>
                        <option selected value="<?= $id_pays?>"><?= $rc[0]['NomPays'] ?></option>
                        </select>
                  <?php     
                    }
                ?>
            </div>




            <input style="color: #201f22;width:100%;" class="btn mt-3" type="submit" name="upload" value="S'Inscrire">
        </form>
    </div>


</body>

</html>



