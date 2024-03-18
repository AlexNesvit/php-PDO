<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Form Inscription</title>
</head>
<body>
    <form method="POST">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom">
        <button type="submit" name="submit">Envoyer</button>
    </form>
</body>
</html>

<?php
    // Paramètres de connexion à la base de données MySQL
$dsn = 'mysql:host=localhost:3306;dbname=bd-pdo';
$user = 'root';
$password = '';

    // Попытка установить соединение с базой данных с помощью PDO
    // Tentative de connexion à la base de données via PDO
try {
    $pdo = new PDO($dsn, $user, $password);
    // Affichage d'un message de connexion réussie
    echo "🎊 Connexion réussie";
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
    $sql = "INSERT INTO user (nom) VALUES (:nom)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom',$nomuser);
    $stmt->execute();

    // Вывод сообщения об успешном добавлении данных
    // Affichage d'un message de succès pour l'ajout des données
    echo "Ok ajouté";

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

?>