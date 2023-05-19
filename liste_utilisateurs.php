<?php
session_start();

// Vérification de connexion
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

$db = new PDO('mysql:host=localhost:8889;dbname=bdd_test_it_room', 'root', 'root');

// Determine how many users to display per page
$usersPerPage = 10;

// Get the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $usersPerPage;

// Calculate the total number of pages
$query = $db->prepare('SELECT COUNT(*) as count FROM users');
$query->execute();
$totalUsers = $query->fetch()['count'];
$totalPages = ceil($totalUsers / $usersPerPage);

// Fetch the users for the current page
$query = $db->prepare('SELECT * FROM users LIMIT :usersPerPage OFFSET :offset');
$query->bindValue(':usersPerPage', $usersPerPage, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$users = $query->fetchAll();

foreach ($users as $user) {
    echo $user['firstname'] . ' ' . $user['lastname'];
    echo '<a href="edition_utilisateur.php?id=' . $user['id'] . '">Éditer</a>';
}

// Display pagination
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i === $page) {
        echo $i;
    } else {
        echo '<a href="?page=' . $i . '">' . $i . '</a>';
    }
}
?>