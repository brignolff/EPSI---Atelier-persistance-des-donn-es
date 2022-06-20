<?php
session_start();
include('../db/loginDb.php');
header( 'content-type: text/html; charset=utf-8' );
$id = $_SESSION['id_user'];
$er = "";
// Si la variable "$_Post" contient des informations alors on les traitres
if (!empty($_POST)) {
    extract($_POST);
    $valid = true;

    $MatARemp = htmlentities(trim($MatARemp));
    $MatSou = htmlentities(trim($MatSou)); 
    $commentaire = htmlentities(trim($commentaire)); 
    $date = htmlentities(trim($date)); 
    $now = date('y-m-d');

    if (empty($MatARemp)) {
        $valid = false;
        $er = "Le Matériel à remplacer ne peut pas être vide !";
    }
    if (empty($MatSou)) {
        $valid = false;
        $er = "Le Matériel souhaité ne peut pas être vide !";
    }
    if (empty($date)) {
        $valid = false;
        $er = "Vous devez renseigner une date.";
    }else{
        if($date>$now){
            $er = "La date ne peux pas être passé !";

        }

    }


    if ($valid) {
        $sql = $DB->insert("INSERT INTO Demandes (Id_Employe, Commentaire, MaterielARemplacer, MaterielSouhaite, DateSouhaite, DateDemande, Id_Status) VALUES (?, ?, ?, ?, ?, ?, ?)", array($id, $commentaire, $MatARemp, $MatSou, $date, $now, 1));
    }

}

?>
<!DOCTYPE html>

<html>


<head>
    <title>Soumettre un besoin</title>

    <meta charset="utf-8">
    <html lang="fr">
    <link rel="stylesheet" href="../css/formDemande.css" />
    <link rel="icon" type="image/png" href="../src/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                toggleActive: true
            });
        });
        function back() {
            window.open('../index.php');
            window.close();

        };
    </script>

</head>

<body>

<form method="post" action="#">

    <div class="container">
        <div class="card">
        <img style="width: 25px;padding: 0px;height: 25px;margin-top: 15px;" onclick="back()" class="btn hBack" type="button" src="http://cdn.onlinewebfonts.com/svg/img_68649.png"/>

            <?php
            if($er){
                echo $er;
            }
            ?>
            <div class="payment-details">
                <h3>Soumettre un besoin </h3>
                <p>Merci de renseigner les détails de votre demande.</p>
            </div>
            <div class="input-text">
                <input name="MatARemp" type="text" placeholder="ex: MacBook Pro 14..">
                <span>Matériel à remplacer</span>
            </div>
            <div class="input-text">
                <input name="MatSou" type="text"  placeholder="ex : Alienware m15..." >
                <span>Matériel souhaité</span>
            </div>

            <div class="input-text form-group row">
            <span>Pour Quand ?</span>
            <input type="text" id="dp1" class="datepicker mr-2" placeholder="Select Date" name="date"><br>

            </div>
            <div style="margin-bottom: 20px;" class="input-text">
                <textarea style="width: 100%;" id="commentaire" name="commentaire" rows="5" cols="33" placeholder="Ajouter un commentaire..." > </textarea>
                <span>Commentaire</span>
            </div>

            <div style="margin-bottom: 10px;" class="send">
                <input class="button" type="submit" name="upload" value="Envoyer">
            </div>


            
        </div>
        
    </div>
</form>

</body>

</html>