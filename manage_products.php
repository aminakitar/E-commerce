<?php include 'connexionprojet.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(247, 210, 222); /* fond rose clair */
            padding: 20px;
        }

        h3 {
            text-align: center;
            color:rgb(207, 11, 109); /* rose vif */
            margin-bottom: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color:rgb(255, 206, 226); /* rose très pâle */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(214, 51, 132, 0.1);
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #f8c1d9;
            border-radius: 8px;
            background-color: #fff;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 20%;
            padding: 10px;
            margin: 5px 1%;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        input[name="ajouter_p"] {
            background-color: #ff1493; /* rose pink */
        }

        input[name="ajouter_p"]:hover {
            background-color:rgb(124, 4, 44); /* deep pink */
        }

        input[name="supprimer_p"] {
            background-color: #ff1493; /* rose/rouge */
        }

        input[name="supprimer_p"]:hover {
            background-color: rgb(124, 4, 44);
        }

        input[name="modifier_p"] {
            background-color:#ff1493; /* mauve rosé */
        }

        input[name="modifier_p"]:hover {
            background-color:  rgb(124, 4, 44);
        }

        p {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h3>Produit</h3>

    <form method="POST" action="">
        Ref:<br>
        <input type="number" name="ref" required><br>
        Prix:<br>
        <input type="text" name="prix"><br>
        Désignation:<br>
        <input type="text" name="design"><br>
        Catégorie:<br>
        <input type="text" name="cat"><br>
        Prix d'acquisition:<br>
        <input type="text" name="prixacq"><br>
        Quantité:<br>
        <input type="text" name="quantite"><br>
        Image:<br>
        <input type="text" name="img"><br>

        <input type="submit" name="ajouter_p" value="Ajouter">
        <input type="submit" name="supprimer_p" value="Supprimer">
        <input type="submit" name="modifier_p" value="Modifier">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ref = $_POST['ref'];

        if (!empty($ref)) {
            $lien = connect();

            if (isset($_POST['ajouter_p'])) {
                $prix = $_POST['prix'];
                $design = $_POST['design'];
                $cat = $_POST['cat'];
                $prixacq = $_POST['prixacq'];
                $quantite = $_POST['quantite'];
                $img = $_POST['img'];

                $sql = "INSERT INTO produit (reference, prix, designation, categorie, prixac, quantite, image)
                        VALUES ('$ref', '$prix', '$design', '$cat', '$prixacq', '$quantite', '$img')";
                $action = "ajouté";
            }

            if (isset($_POST['modifier_p'])) {
                $prix = $_POST['prix'];
                $sql = "UPDATE produit SET prix = '$prix' WHERE reference = '$ref'";
                $action = "modifié";
            }

            if (isset($_POST['supprimer_p'])) {
                $sql = "DELETE FROM produit WHERE reference = '$ref'";
                $action = "supprimé";
            }

            if (isset($sql)) {
                if (mysqli_query($lien, $sql)) {
                    echo "<p style='color:green;'>Produit $action avec succès.</p>";
                } else {
                    echo "<p style='color:red;'>Erreur SQL : " . mysqli_error($lien) . "</p>";
                }
            }

            mysqli_close($lien);
        } else {
            echo "<p style='color:red;'>La référence est obligatoire.</p>";
        }
    }
    ?>
</body>
</html>
