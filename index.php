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

/*
    // Paramètres de connexion à la base de données MySQL
$dsn = 'mysql:host=localhost:3306;dbname=bd-pdo';
$user = 'root';
$password = '';

    // Попытка установить соединение с базой данных с помощью PDO
    // Tentative de connexion à la base de données via PDO
try {
    $pdo = new PDO($dsn, $user, $password);
    // Affichage d'un message de connexion réussie
    echo "🎊 Connexion réussie!" . '<br>';
} catch (PDOException $e) {
    // Affichage d'un message d'erreur en cas d'échec de la connexion
    echo "🥹 Échec de la connexion : " . $e->getMessage();
}

    // Проверка, были ли отправлены данные формы через метод POST
    // Vérification de l'envoi des données du formulaire via la méthode POST
if(isset($_POST['nom'])){
    // Извлечение значения поля "nom" из отправленных данных
    // Extraction de la valeur du champ "nom" des données envoyées
    $nomuser=$_POST['nom'];

    // Подготовка и выполнение SQL-запроса для вставки имени пользователя в таблицу "user"
    // Préparation et exécution de la requête SQL pour insérer le nom de l'utilisateur dans la table "user"

    
    $sql = "INSERT INTO user (nom, mail, password) VALUES (:nom, :mail, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nomuser);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    */

    session_start();

// Vérifie si le formulaire a été soumis
if(isset($_POST['submit'])) {
    // Vérifie si les champs requis sont renseignés
    if(!empty($_POST['nom']) && !empty($_POST['mail']) && !empty($_POST['password'])) {
        // Récupère les valeurs du formulaire
        $nomuser = $_POST['nom'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        // Connexion à la base de données
        $dsn = 'mysql:host=localhost;dbname=bd-pdo';
        $user = 'root';
        $password = '';

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prépare la requête SQL d'insertion
            $sql = "INSERT INTO user (nom, mail, password) VALUES (:nom, :mail, :password)";
            $stmt = $pdo->prepare($sql);

            // Lie les paramètres
            $stmt->bindParam(':nom', $nomuser);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':password', $password);

            // Exécute la requête
            $stmt->execute();

            // Affiche un message de succès
            echo "<p class='success-message'>Nouvel utilisateur ajouté.Données insérées avec succès!";
        } catch(PDOException $e) {
            // Affiche les erreurs
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Affiche un message si des champs requis sont manquants
        echo "<p class='alert'>Veuillez remplir tous les champs!";
    }
}


    // Вывод сообщения об успешном добавлении данных
    // Affichage d'un message de succès pour l'ajout des données
    /*
    echo "Ok ajouté";
    
    // Vérification si le nom existe déjà dans la base de données
    $sql_check = "SELECT COUNT(*) FROM user WHERE nom = :nom";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':nom', $nomuser);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();

    // Si le nom n'existe pas, on l'ajoute à la base de données
    if($count == 0) {
        // Préparation et exécution de la requête SQL pour insérer le nom de l'utilisateur dans la table "user"
        $sql_insert = "INSERT INTO user (nom) VALUES (:nom)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':nom', $nomuser);
        $stmt_insert->execute();
        // Affichage d'un message de succès pour l'ajout des données
        echo "Ok ajouté";
    } else {
        // Si le nom existe déjà, on affiche un message d'erreur
        echo "Ce nom est déjà pris, choisissez une autre nom svp!";
    }

    // Подготовка и выполнение SQL-запроса для выборки всех пользователей из таблицы "user"
    // Préparation et exécution de la requête SQL pour sélectionner tous les utilisateurs de la table "user"
    $sql = "SELECT * FROM user";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();

    // Вывод списка всех пользователей
    // Affichage de la liste de tous les utilisateurs
    echo "<ul>";
    foreach($users as $user){

        echo "<li>". $user['nom'] ."</li>";
    }
    echo "</ul>";
}
*/
?>