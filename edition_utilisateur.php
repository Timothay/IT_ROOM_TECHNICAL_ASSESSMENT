<?php
session_start();

// Vérification de connexion
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

$db = new PDO('mysql:host=localhost:8889;dbname=bdd_test_it_room', 'root', 'root');

// Get the user id from the URL
$id = $_GET['id'];

// Check if this user is the logged in user
if ($_SESSION['user']['id'] != $id) {
    header('Location: liste_utilisateurs.php');
    exit();
}

// Process the form if it is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = $_POST['age'];

    $query = $db->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, password = ?, age = ? WHERE id = ?');
    $query->execute([$firstname, $lastname, $email, $password, $age, $id]);

    // Update the session with the new details
    $_SESSION['user'] = array_merge($_SESSION['user'], $_POST);

    header('Location: liste_utilisateurs.php');
    exit();
}

// If form is not submitted, load the user's data
$query = $db->prepare('SELECT * FROM users WHERE id = ?');
$query->execute([$id]);
$user = $query->fetch();

?>

<form action="" method="post">
    <input type="text" name="firstname" placeholder="Prénom" value="<?php echo $user['firstname']; ?>">
    <input type="text" name="lastname" placeholder="Nom" value="<?php echo $user['lastname']; ?>">
    <input type="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>">
    <input type="password" name="password" placeholder="Mot de passe" value="">
    <input type="number" name="age" placeholder="Âge" value="<?php echo $user['age']; ?>">
    <input type="submit" value="Mettre à jour">
</form>

<a href="supprimer_utilisateur.php?id=<?php echo $id; ?>">Supprimer mon compte</a>