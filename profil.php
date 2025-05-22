<?php
session_start();
include 'connexionprojet.php';

// Rediriger vers la page de login si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: llogin.php");
    exit();
}

$conn = connect();

// Récupérer les infos de l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT nom, email,ville,adresse,tel FROM utilisateur WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #E91E63;
            margin-top: 40px;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #E91E63;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(233, 30, 99, 0.2);
            background-color: #fdfdfd;
            margin-top: 40px;
        }

        p {
            font-size: 18px;
            margin: 10px 0;
            text-align: center;
        }

        a {
            color: #E91E63;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #C2185B;
        }

        .actions {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h2>Mon Compte</h2>

    <div class="container">
        <?php if ($user): ?>
            <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
			    <p><strong>Ville:</strong> <?= htmlspecialchars($user['ville']) ?></p>
				  <p><strong>Adresse :</strong> <?= htmlspecialchars($user['adresse']) ?></p>
				    <p><strong>Tel:</strong> <?= htmlspecialchars($user['tel']) ?></p>
        <?php else: ?>
            <p>Utilisateur introuvable.</p>
        <?php endif; ?>

        <div class="actions">
            <a href="accueil.php">⬅ Retour à l'accueil</a> |
            <a href="logout.php">Se déconnecter</a>
        </div>
    </div>
</body>
</html>