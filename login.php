<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    $result = mysqli_query($conn, "SELECT * FROM utilisateur WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['mot_de_passe']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: produit.php");
        }
        exit;
    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
<div class="register-container">
    <h2>Connexion</h2>
    <?php if (isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <button class="btn" type="submit">Se connecter</button>
		  <p><a href="register.php">creer un compte</a></p>
    </form>
</div>
</body>
</html>