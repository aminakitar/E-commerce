<?php
session_start();
include 'connexionprojet.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BijouxAS</title>
	<style>.btn { background: #E91E63; color: white; border: none; padding: 10px; cursor: pointer; }</style>
    <link rel="stylesheet" href="INDEX.CSS">
</head>
<body>
<body>
    <!-- HEADER -->
    <header>
        <div class="header1">
            <div class="logo">
                <h1 class="nom">BijouxAS</h1>
                <img src="logo.jpeg" alt="Logobijouxas" class="L">
            </div>
            <nav>
                <ul>
                    <li><a href="accueil.php">Accueil</a></li>
                  
                    <li><a href="contactez_nous.html">Contactez-Nous</a></li>
                </ul>
            </nav>
            <div class="LL">
                <a href="recherche.php">
                    <img src="recherche.jpeg" alt="Recherche" style="width:30px; height:30px;">
                </a>
                <a href="profil.php">
                    <img src="profil.jpeg" alt="Profil" style="width:30px; height:30px;">
                </a>
                <a href="panier.php">
                    <img src="panier.jpeg" alt="Panier" style="width:30px; height:30px;">
                </a>
            </div>
        </div>
    </header>

<h1>Nos Produits</h1>

<div class="produits-container">
<?php
$conn = connect();
$sql = "SELECT * FROM produit";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='produit-card'>";
    echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Image du produit'>";
    echo "<h3>" . htmlspecialchars($row['designation']) . "</h3>";
    echo "<p>Prix : " . htmlspecialchars($row['prix']) . " DH</p>";
    
    echo "<form method='POST' action='ajouter_panier.php'>";
    echo "<input type='hidden' name='ref' value='" . intval($row['reference']) . "'>";
   // echo "<input type='number' name='quantite' value='1' min='1'>";
    echo "<button type='submit' class='btn'>Ajouter au panier +</button>";
    echo "</form>";

    echo "</div>";
}
mysqli_close($conn);
?>
</div>
 <main>
        

        <?php if (isset($_SESSION['user_id'])): ?>
             
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
           
            <a href="llogin.php">Se connecter</a>
        <?php endif; ?>
    </main>
    <?php
    include 'contactez_nous.html';
?>
</body>
</html>