<?php
include 'connexionprojet.php';
$conn = connect();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    // Optionnel : vérifier si email existe déjà
    $check = $conn->query("SELECT * FROM utilisateur WHERE email='$email'");
    if ($check->num_rows > 0) {
        $message = "Cet email est déjà utilisé.";
    } else {
        $sql = "INSERT INTO utilisateur (nom, email, password) VALUES ('$nom', '$email', '$password')";
        if ($conn->query($sql)) {
            header("Location: llogin.php");
            exit();
        } else {
            $message = "Erreur lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Créer un compte</title>
    <style>
        body {
            background: #fff0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .register-container {
            background: white;
            padding: 2rem 3rem;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(214, 51, 132, 0.2);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #d63384;
            margin-bottom: 1.5rem;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.9rem;
            margin: 0.7rem 0;
            border: 1px solid #f8c1d9;
            border-radius: 8px;
            font-size: 1rem;
        }
        button.btn {
            width: 100%;
            padding: 0.9rem;
            background-color: #ff69b4;
            border: none;
            color: white;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 1rem;
        }
        button.btn:hover {
            background-color: #ff1493;
        }
        .message {
            color: #d63384;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Créer un compte</h2>

    <?php if ($message != ''): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="nom" placeholder="Nom utilisateur" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br>
        <button type="submit" class="btn" name="submit">S'inscrire</button>
    </form>
</div>

</body>
</html>
