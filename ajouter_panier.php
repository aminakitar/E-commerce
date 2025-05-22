
<?php
session_start();

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Récupérer les données du formulaire
$ref = isset($_POST['ref']) ? intval($_POST['ref']) : 0;
$quantite = isset($_POST['quantite']) ? max(1, intval($_POST['quantite'])) : 1;

// Ajouter au panier
if ($ref > 0) {
    if (isset($_SESSION['panier'][$ref])) {
        $_SESSION['panier'][$ref] += $quantite;
    } else {
        $_SESSION['panier'][$ref] = $quantite;
    }
}

// Rediriger vers le panier
header("Location: panier.php");
exit;
?>
