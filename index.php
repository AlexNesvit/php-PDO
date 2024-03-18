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
    session_start();

    if(isset($_POST['submit'])) {
        if(!empty($_POST['nom']) && !empty($_POST['mail']) && !empty($_POST['password'])) {
            $nomuser = $_POST['nom'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $dsn = 'mysql:host=localhost;dbname=bd-pdo';
            $user = 'root';
            $db_password = ''; // Utilisez une variable différente pour le mot de passe de la base de données

            try {
                $pdo = new PDO($dsn, $user, $db_password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql_check = "SELECT COUNT(*) FROM user WHERE nom = :nom";
                $stmt_check = $pdo->prepare($sql_check);
                $stmt_check->bindParam(':nom', $nomuser);
                $stmt_check->execute();
                $count = $stmt_check->fetchColumn();

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
