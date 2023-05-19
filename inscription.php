<?php
session_start();

// Vérification de connexion
if (isset($_SESSION['user'])) {
    header('Location: liste_utilisateurs.php');
    exit();
}

// Process the form if it is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new PDO('mysql:host=localhost:8889;dbname=bdd_test_it_room', 'root', 'root');

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = $_POST['age'];

    $query = $db->prepare('INSERT INTO users (firstname, lastname, email, password, age) VALUES (?, ?, ?, ?, ?)');
    $query->execute([$firstname, $lastname, $email, $password, $age]);

    header('Location: connexion.php');
    exit();
}
?>

<form action="" method="post">
    <input type="text" name="firstname" placeholder="Prénom">
    <input type="text" name="lastname" placeholder="Nom">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Mot de passe">
    <input type="number" name="age" placeholder="Âge">
    <input type="submit" value="Inscription">
</form>