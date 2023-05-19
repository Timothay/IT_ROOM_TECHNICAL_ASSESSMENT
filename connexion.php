<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['user'])) {
    header('Location: liste_utilisateurs.php');
    exit();
}

// Process the form if it is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new PDO('mysql:host=localhost:8889;dbname=bdd_test_it_room', 'root', 'root');

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $db->prepare('SELECT * FROM users WHERE email = ?');
    $query->execute([$email]);
    $user = $query->fetch();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: liste_utilisateurs.php');
        exit();
    } else {
        $error = 'Identifiants incorrects';
    }
}
?>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<form action="" method="post">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Mot de passe">
    <input type="submit" value="Connexion">
</form>