<?php
session_start();

// Vérification de connexion
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

$db = new PDO('mysql:host=localhost:8889;dbname=bdd_test_it_room', 'root', 'root');

// Récupération de l'ID
$id = $_GET['id'];


if ($_SESSION['user']['id'] != $id) {
    header('Location: liste_utilisateurs.php');
    exit();
}

$query = $db->prepare('DELETE FROM users WHERE id = ?');
$query->execute([$id]);

// Log the user out
unset($_SESSION['user']);

header('Location: connexion.php');
exit();