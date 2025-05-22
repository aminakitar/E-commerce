<?php
session_start();
include 'connexionprojet.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

//conn bd
$conn = connect();
if (!$conn) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

// vr login
if (!isset($_SESSION['user_id'])) {
    header("Location: llogin.php");
    exit;
}

// panier vide ou non
if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    echo "Votre panier est vide.";
    exit;
}

$id_user = intval($_SESSION['user_id']);
$mode_paiement = $_POST['mode_paiement'] ?? 'à la livraison';

try {
  
    mysqli_begin_transaction($conn);

 
    $sql_commande = "INSERT INTO command (date, numclt, mode_paiement) VALUES (NOW(), ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_commande);
    mysqli_stmt_bind_param($stmt, "is", $id_user, $mode_paiement);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Erreur lors de l'insertion de la commande: " . mysqli_stmt_error($stmt));
    }

    $id_commande = mysqli_insert_id($conn); 
    mysqli_stmt_close($stmt);

    // إدخال كل عنصر في ligne de commande
    $sql_ligne = "INSERT INTO lignedecommande (refprod, nulcmd, quantite) VALUES (?, ?, ?)";
    $stmt_ligne = mysqli_prepare($conn, $sql_ligne);

    foreach ($_SESSION['panier'] as $id_prod => $qt) {
        $id_prod = intval($id_prod);
        $qt = intval($qt);

        mysqli_stmt_bind_param($stmt_ligne, "iii", $id_prod, $id_commande, $qt);
        if (!mysqli_stmt_execute($stmt_ligne)) {
            throw new Exception("Erreur lors de l'ajout des lignes de commande: " . mysqli_stmt_error($stmt_ligne));
        }
    }

    mysqli_stmt_close($stmt_ligne);

 
    mysqli_commit($conn);


    unset($_SESSION['panier']);

    echo "<h2>Commande validée avec succès !</h2><a href='accueil.php'>Retour à la boutique</a>";

} catch (Exception $e) {
 
    mysqli_rollback($conn);
    echo "<h3 style='color:red;'>Une erreur s'est produite : " . $e->getMessage() . "</h3>";
}

mysqli_close($conn);
?>
