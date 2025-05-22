<?php
session_start();
include('connexionprojet.php');
$conn = connect();

$resultats = [];
$message = '';

if (isset($_POST['recherche'])) {
    $recherche = trim($_POST['recherche']);
    $prix_min = isset($_POST['prix_min']) && is_numeric($_POST['prix_min']) ? floatval($_POST['prix_min']) : null;
    $prix_max = isset($_POST['prix_max']) && is_numeric($_POST['prix_max']) ? floatval($_POST['prix_max']) : null;

    if ($recherche !== '') {
        $query = "SELECT reference, nom, prix, designation, image FROM produit WHERE (categorie = ? OR nom = ? OR designation = ?)";
        $types = "sss";
        $params = [$recherche, $recherche, $recherche];

        if ($prix_min !== null) {
            $query .= " AND prix >= ?";
            $types .= "d";
            $params[] = $prix_min;
        }
        if ($prix_max !== null) {
            $query .= " AND prix <= ?";
            $types .= "d";
            $params[] = $prix_max;
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $resultats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $message = "Résultats de la recherche <strong>" . htmlspecialchars($recherche) . "</strong>";
        if ($prix_min !== null || $prix_max !== null) {
            $message .= " avec filtre de prix";
            if ($prix_min !== null) $message .= " à partir de " . $prix_min . " DH";
            if ($prix_max !== null) $message .= " jusqu'à " . $prix_max . " DH";
        }
        $message .= " :";
    } else {
        $message = "Veuillez saisir un terme de recherche.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Recherche de produits</title>
    <style>
body {font-family: Arial, sans-serif;background-color: #fff0f5;margin: 20px auto;max-width: 900px;padding: 0 20px 40px;}
h1 {color: #E91E63;text-align: center;}
form {margin-bottom: 30px;text-align: center;}
input[type="text"],input[type="number"] {width: 150px;padding: 8px 12px;font-size: 16px;border: 2px solid #E91E63;border-radius: 5px;margin: 5px 8px;}
button {background-color: #E91E63;color: white;border: none;padding: 9px 18px;font-size: 16px;border-radius: 5px;cursor: pointer;transition: background-color 0.3s ease;}
button:hover {background-color: #c2185b;}
.message {font-size: 18px;margin-bottom: 20px;color: #333;text-align: center;}
.resultats {display: flex;flex-wrap: wrap;gap: 20px;justify-content: center;}
.produit {background-color: white;border: 1px solid #ddd;border-radius: 8px;width: 260px;padding: 15px;box-shadow: 0 2px 5px rgba(0,0,0,0.1);text-align: center;transition: box-shadow 0.3s ease;}
.produit:hover {box-shadow: 0 5px 15px rgba(233, 30, 99, 0.4);}
.produit img {max-width: 100%;height: 150px;object-fit: contain;margin-bottom: 12px;border-radius: 5px;}
.produit h3 {font-size: 20px;margin: 10px 0 8px;color: #E91E63;}
.produit p {font-size: 14px;color: #555;min-height: 60px;}

    </style>
</head>
<body>

<h1>Recherche de produits</h1>

<form method="POST" action="">
    <input type="text" name="recherche" placeholder="Entrez un mot-clé, catégorie, type..." value="<?= isset($recherche) ? htmlspecialchars($recherche) : '' ?>" required />
    <input type="number" name="prix_min" step="0.01" min="0" placeholder="Prix min" value="<?= isset($prix_min) ? htmlspecialchars($prix_min) : '' ?>" />
    <input type="number" name="prix_max" step="0.01" min="0" placeholder="Prix max" value="<?= isset($prix_max) ? htmlspecialchars($prix_max) : '' ?>" />
    <button type="submit">Rechercher</button>
</form>

<?php if ($message): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<?php if (!empty($resultats)): ?>
    <div class="resultats">
    <?php foreach ($resultats as $produit): ?>
        <div class="produit">
           <img src="<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" />
           <h3><?= htmlspecialchars($produit['nom']) ?></h3>
           <p><?= nl2br(htmlspecialchars($produit['designation'])) ?></p>
           <p><strong>Prix :</strong> <?= htmlspecialchars($produit['prix']) ?> DH</p>
        </div>
    <?php endforeach; ?>
    </div>
<?php elseif(isset($_POST['recherche'])): ?>
    <p style="text-align:center; color:#999;">Aucun produit trouvé pour cette recherche.</p>
<?php endif; ?>

</body>
</html>
