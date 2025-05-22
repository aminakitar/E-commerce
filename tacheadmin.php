<?php
include('connexionprojet.php');
$conn = connect();
session_start();

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Rediriger vers login si pas admin
    exit;
}

// Ici on récupère les infos de l'admin si besoin
$id = intval($_SESSION['user_id']);
$query = $conn->query("SELECT * FROM utilisateur WHERE id = $id");
$user = $query->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Menu Vertical</title>
<style>
  /* Reset */
  * {
    box-sizing: border-box;
  }
  
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #ffe6f0;
    margin: 0;
    height: 100vh;
    display: flex;
    justify-content: center;  /* centre horizontal */
    align-items: center;      /* centre vertical */
  }
  
  /* Conteneur pour titre + menu */
  .container {
    display: flex;
    align-items: center;
    gap: 50px;
    background-color: #fff0f5;
    border: 2px solid #d63384;
    border-radius: 12px;
    padding: 40px 50px;
    box-shadow: 0 0 15px rgba(214, 51, 132, 0.25);
  }
  
 
  /* Titre fixé en haut */
  h3 {
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 600px;
 
    color: #000;
    font-weight: 700;
    font-size: 2.4rem;
    padding: 20px 0;
    margin: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    text-align: center;
    z-index: 1000;
  }

  /* Menu de navigation */
  nav {
    width: 280px;
  }

  nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  nav ul li a {
    display: block;
    padding: 14px 20px;
    text-decoration: none;
    font-weight: 600;
    font-size: 18px;
    color: #d63384; /* rose foncé */
    border-radius: 8px;
    transition: background-color 0.3s, color 0.3s;
    box-sizing: border-box;
    text-align: center;
    border: 2px solid transparent;
  }

  nav ul li a:hover {
    background-color: #d63384;
    color: #fff;
  }

  /* Style différent pour Déconnexion */
  nav ul li a[href="logout.php"] {
    color: #b22222; /* rouge foncé */
    font-weight: 700;
    border: 2px solid #b22222;
  }
  nav ul li a[href="logout.php"]:hover {
    background-color: #b22222;
    color: #fff;
  }
</style>
</head>
<body>
    <h3>Espace Admin</h3><br>
    <br>
<nav>
  <ul>
    <li><a href="manage_products.php">➕ Gérer les Produits</a></li>
    <li><a href="manage_clients.php">👥 Gérer les Clients</a></li>
    
    <li><a href="logout.php">🚪 Déconnexion</a></li>
  </ul>
</nav>

</body>
</html>
