


<?php
session_start();
include 'connexionprojet.php';
$conn = connect();


// Initialiser le panier si vide
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Supprimer un produit du panier
if (isset($_GET['supprimer'])) {
    $ref = $_GET['supprimer'];
    if (isset($_SESSION['panier'][$ref])) {
        unset($_SESSION['panier'][$ref]);
    }
    header("Location: panier.php");
    exit;
}

// Mettre à jour les quantités
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantite'])) {
    foreach ($_POST['quantite'] as $ref => $qt) {
        $_SESSION['panier'][$ref] = max(1, intval($qt));
    }
    header("Location: panier.php");
    exit;
}
// Fonction simple pour vérifier la connexion
function estConnecte() {
    return isset($_SESSION['user_id']);  // adapte selon ta variable session
}

// Gestion du clic sur "Passer la commande"
if (isset($_POST['passer_commande'])) {
    if (!estConnecte()) {
        header("Location: llogin.php");
        exit;
    } else {
        header("Location: commander.php");
        exit;
    }
}

// Gestion du clic sur "Afficher mes commandes"
if (isset($_POST['mes_commandes'])) {
    if (!estConnecte()) {
        header("Location: llogin.php");
        exit;
    } else {
        header("Location: mes_commandes.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Panier</title>
    <style>
        body { font-family: Arial; background: #fff0f5; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #E91E63; color: white; }
        .total { text-align: right; font-weight: bold; }
        .btn { background: #E91E63; color: white; border: none; padding: 10px; cursor: pointer;}
          .form-inline {display: inline;}	
.btn-update {
    background-color: #ff4da6;
}

.btn-commande {
    background-color: #ff1a75;
    margin-right: 10px;
}

.btn-historique {
    background-color: #b30059;
}		  
    </style>
</head>
<body>

<h2>Mon Panier</h2>

<?php if (empty($_SESSION['panier'])): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <form method="POST">
        <table>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['panier'] as $ref => $qt) {
                $result = mysqli_query($conn, "SELECT * FROM produit WHERE reference=" . intval($ref));
                if ($prod = mysqli_fetch_assoc($result)) {
                    $sous_total = $prod['prix'] * $qt;
                    $total += $sous_total;
                    echo "<tr>
                        <td>" . htmlspecialchars($prod['nom']) . "</td>
                        <td>{$prod['prix']} MAD</td>
                        <td><input type='number' name='quantite[$ref]' value='$qt' min='1'></td>
                        <td>$sous_total MAD</td>
                        <td><a href='?supprimer=$ref' style='color:red;'>Supprimer</a></td>
                    </tr>";
                }
            }
            ?>
        </table>
        <p class="total">Total: <?= $total ?> MAD</p>
        <button type="submit" class="btn">Mettre à jour le panier</button><br><br>
    </form>
	     <div class="boutons-panier">
        <form method="POST" action="commander.php" class="form-inline">
            <input type="hidden" name="mode_paiement" value="à la livraison">
            <button type="submit" class="  btn btn-commande">Passer la commande</button>
        </form>

        <form method="GET" action="mes_commandes.php" class="form-inline">
            <button type="submit" class=" btn btn-historique">Afficher historique</button>
        </form>
    </div>
<?php endif; ?>


</body>
</html>
