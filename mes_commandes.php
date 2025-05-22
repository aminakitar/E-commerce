<?php
session_start();
include 'connexionprojet.php';

$conn = connect();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user_id'];

// requet 
$res = mysqli_query($conn, "
    SELECT 
        c.num AS id_commande,
        c.date,
        c.mode_paiement,
        p.nom,
        p.prix,
        l.quantite
    FROM command c
    JOIN lignedecommande l ON c.num = l.nulcmd
    JOIN produit p ON l.refprod = p.reference
    WHERE c.numclt = $id_user
    ORDER BY c.date DESC
");

$commandes = [];
while ($row = mysqli_fetch_assoc($res)) {
    $id_commande = $row['id_commande'];

    if (!isset($commandes[$id_commande])) {
        $commandes[$id_commande] = [
            'infos' => [
                'date' => $row['date'],
                'mode' => $row['mode_paiement']
            ],
            'lignes' => []
        ];
    }

    $commandes[$id_commande]['lignes'][] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Commandes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff0f5;
            padding: 20px;
        }
        h2 {
            color: #b30059;
            text-align: center;
        }
        .commande {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 25px;
            background-color: #fff;
            border-radius: 8px;
        }
        .commande h3 {
            color: #e91e63;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            padding: 5px 0;
        }
    </style>
</head>
<body>

<h2>Historique de mes commandes</h2>

<?php if (empty($commandes)): ?>
    <p>Vous n'avez encore passé aucune commande.</p>
<?php else: ?>
    <?php foreach ($commandes as $id => $commande): ?>
        <div class="commande">
            <h3>Commande #<?= $id ?> - <?= htmlspecialchars($commande['infos']['date']) ?> (<?= htmlspecialchars($commande['infos']['mode']) ?>)</h3>
            <ul>
                <?php foreach ($commande['lignes'] as $ligne): ?>
                    <li>
                        <?= htmlspecialchars($ligne['nom']) ?> × <?= $ligne['quantite'] ?> = <?= $ligne['prix'] * $ligne['quantite'] ?> MAD
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
