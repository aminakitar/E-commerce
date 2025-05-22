<?php
include('connexionprojet.php');
$conn = connect();
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $motdepasse = $_POST['pwd']; 

   
    $query = $conn->query("SELECT * FROM utilisateur WHERE email= '$email'");

    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();

        // Vérification du mot de passe simple (en vrai projet -> password_hash recommandé !)
        if ($motdepasse === $user['password']) { 
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirection selon le rôle
            if ($user['role'] == 'admin') {
                header('Location: tacheadmin.php');
            } else {
                header('Location: accueil.php');
            }
            exit;
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Utilisateur non trouvé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            background: #eef2f3;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            background: white;
            padding: 2rem 3rem;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.9rem;
            margin: 0.7rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.9rem;
            background-color:rgb(218, 28, 145);
            border: none;
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 1rem;
        }

        input[type="submit"]:hover {
            background-color:rgb(233, 35, 127);
        }

        .error-message {
            color: red;
            margin-bottom: 1rem;

        }
        .register-btn {
    display: inline-block;
    margin-top: 1rem;
    padding: 0.9rem;
     width: 90%;
    background-color: rgb(218, 28, 145); /* rose clair */
    color: white;
    text-decoration: none;
    font-size: 1rem;
    text-align: center;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}
    </style>
</head>
<body>

<div class="login-container">
    <h1>Connexion</h1>

    <?php if ($message != ''): ?>
        <div class="error-message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="pwd" placeholder="Mot de passe" required><br>
        <input type="submit" value="Se connecter">
  <a href="register.php" class="register-btn">Créer un compte</a>

    </form>
</div>

</body>
</html>
