<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Form Inscription</title>
</head>
<body>
    <form method="POST">
        <label for="nom">Nom:</label>
        <input  class="text" type="text" id="nom" name="nom"><br><br>
        <label for="mail">Mail:</label>
        <input class="text"type="text" id="mail" name="mail"><br><br>
        <label for="password">Mot de pass:</label>
        <input class="text"type="text" id="password" name="password"><br><br>
        <button type="submit" class="button" name="submit">Envoyer</button>
    </form>
</body>
</html>

<?php
//Cette fonction démarre une nouvelle session ou reprend une session existante, ce qui permet d'utiliser les variables de session:
    session_start();

    //C'est une condition qui vérifie si le formulaire a été soumis. Si le bouton d'envoi du formulaire a été cliqué (c'est-à-dire si le paramètre "submit" est défini dans la superglobale $_POST), le code à l'intérieur du bloc d'instructions sera exécuté:
    if(isset($_POST['submit'])) { 
        //Cette condition vérifie si les champs du formulaire "nom", "mail" et "password" ne sont pas vides:
        if(!empty($_POST['nom']) && !empty($_POST['mail']) && !empty($_POST['password'])) { 
            //Ces lignes récupèrent les valeurs des champs du formulaire et les stockent dans des variables PHP:
            $nomuser = $_POST['nom'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            
            //Ces variables définissent les paramètres de connexion à la base de données MySQL:
            $dsn = 'mysql:host=localhost;dbname=bd-pdo';
            $user = 'root';
            $db_password = ''; // Utilisez une variable différente pour le mot de passe de la base de données

            //Cette structure "try-catch" est utilisée pour capturer les exceptions qui pourraient survenir lors de l'exécution du code à l'intérieur du bloc "try". Si une exception est levée, elle est capturée et gérée dans le bloc "catch":
            try {
                //Cette ligne crée un nouvel objet PDO pour établir une connexion à la base de données MySQL en utilisant les informations de connexion fournies:
                $pdo = new PDO($dsn, $user, $db_password);
                //Cette ligne configure PDO pour qu'il génère des exceptions PDO en cas d'erreur lors de l'exécution des requêtes SQL:
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //Cette requête SQL compte le nombre d'entrées dans la table "user" où le nom correspond à celui soumis dans le formulaire:
                $sql_check = "SELECT COUNT(*) FROM user WHERE nom = :nom";
                $stmt_check = $pdo->prepare($sql_check);
                $stmt_check->bindParam(':nom', $nomuser);
                $stmt_check->execute();
                $count = $stmt_check->fetchColumn();

                //Cette condition vérifie si le nom soumis dans le formulaire n'existe pas déjà dans la base de données. Si c'est le cas, il insère les nouvelles données dans la base de données. Sinon, il affiche un message d'erreur indiquant que le nom est déjà pris:
                if($count == 0) {
                    $sql_insert = "INSERT INTO user (nom, mail, password) VALUES (:nom, :mail, :password)";
                    $stmt_insert = $pdo->prepare($sql_insert);
                    $stmt_insert->bindParam(':nom', $nomuser);
                    $stmt_insert->bindParam(':mail', $mail);
                    $stmt_insert->bindParam(':password', $password);
                    $stmt_insert->execute();

                    echo "<p class='success-message'>Nouvel utilisateur ajouté. Données insérées avec succès!</p>";
                } else {
                    echo "<p class='error-message'>Ce nom est déjà pris. Veuillez choisir un autre nom.</p>";
                }
            } catch(PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            echo "<p class='error-message'>Veuillez remplir tous les champs!</p>";
        }
    }
?>
