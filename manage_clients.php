<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: rgb(247, 210, 222); /* fond rose clair */
        padding: 20px;
    }

    h3 {
        text-align: center;
        color: rgb(207, 11, 109); /* rose vif */
        margin-bottom: 20px;
    }

    form {
        max-width: 500px;
        margin: 0 auto;
        background-color: rgb(255, 206, 226); /* rose très pâle */
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(214, 51, 132, 0.1);
        box-sizing: border-box;
    }

    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #f8c1d9;
        border-radius: 8px;
        background-color: #fff;
        box-sizing: border-box;
        font-size: 16px;
    }

    input[type="submit"] {
        width: 22%;
        padding: 10px;
        margin: 5px 1% 0 0;
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 14px;
        box-sizing: border-box;
    }

    input[name="ajouter"] {
        background-color: #ff1493; /* rose pink */
    }

    input[name="ajouter"]:hover {
        background-color: rgb(124, 4, 44); /* deep pink */
    }

    input[name="supprimer"] {
        background-color: #ff1493; /* rose pink */
    }

    input[name="supprimer"]:hover {
        background-color: rgb(124, 4, 44);
    }

    input[name="modifier"] {
        background-color: #ff1493; /* rose pink */
    }

    input[name="modifier"]:hover {
        background-color: rgb(124, 4, 44);
    }

    input[name="afficher"] {
        background-color: #ff1493; /* rose pink */
    }

    input[name="afficher"]:hover {
        background-color: rgb(124, 4, 44);
    }

    p, .message {
        text-align: center;
        font-weight: bold;
        color: rgb(207, 11, 109);
        margin-top: 20px;
    }
</style>
</head>
<body>

<h3>Gestion Clients</h3>

<form method="post" action="">
    ID:<br>
    <input type="number" name="id" ><br>
    Nom:<br>
    <input type="text" name="nom"><br>
    role:<br> 
    <input type="text" name="role"><br>
    Adresse :<br>
    <input type="text" name="addresse" ><br>
    Ville:<br>
    <input type="text" name="ville"><br>  
    Téléphone:<br>
    <input type="text" name="tel" ><br>
     Email:<br>
    <input type="email" name="email" ><br>
    Mot de passe:<br>
    <input type="password" name="pwd"><br><br>

    <input type="submit" name="ajouter" value="Ajouter Client">
    <input type="submit" name="supprimer" value="Supprimer Client">
    <input type="submit" name="modifier" value="Modifier Client">
    <input type="submit" name="afficher" value="Afficher Tous les Clients">
</form>

<br><hr><br>

<?php    
include('connexionprojet.php');
$lien = connect(); // Connexion à la base

// Ajouter un client
if (isset($_POST['ajouter'])) {
    $sql = "INSERT INTO utilisateur (id, nom, role, adresse, ville, tel, email, password)
            VALUES (?, ?, 'client', ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($lien, $sql);
    mysqli_stmt_bind_param($stmt, "issssss",
        $_POST['id'],
        $_POST['nom'],
        $_POST['addresse'],
        $_POST['ville'],
        $_POST['tel'],
        $_POST['email'],
        $_POST['pwd']
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "Client ajouté avec succès.<br>";
    } else {
        echo "Erreur lors de l'ajout : " . mysqli_error($lien);
    }

    mysqli_stmt_close($stmt);
}

// Supprimer un client
if (isset($_POST['supprimer'])) {
    $sql = "DELETE FROM utilisateur WHERE id = ? AND role = 'client'";
    $stmt = mysqli_prepare($lien, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_POST['id']);

    if (mysqli_stmt_execute($stmt)) {
        echo "Client supprimé avec succès.<br>";
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($lien);
    }

    mysqli_stmt_close($stmt);
}

// Modifier un client
if (isset($_POST['modifier'])) {
    $sql = "UPDATE utilisateur 
            SET nom = ?, adresse = ?, ville = ?, tel = ?, email = ?, password = ? 
            WHERE id = ? AND role = 'client'";

    $stmt = mysqli_prepare($lien, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi",
        $_POST['nom'],
        $_POST['addresse'],
        $_POST['ville'],
        $_POST['tel'],
        $_POST['email'],
        $_POST['pwd'],
        $_POST['id']
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "Client modifié avec succès.<br>";
    } else {
        echo "Erreur lors de la modification : " . mysqli_error($lien);
    }

    mysqli_stmt_close($stmt);
}

// Afficher tous les clients
if (isset($_POST['afficher'])) {
    $sql = "SELECT * FROM utilisateur WHERE role = 'client'";
    $result = mysqli_query($lien, $sql);

    echo "<h3>Liste des Clients :</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: {$row['id']} | Nom: {$row['nom']} | Adresse: {$row['adresse']} | Ville: {$row['ville']} | Tél: {$row['tel']} | Email: {$row['email']} | Password: {$row['password']}<br>";
    }

    mysqli_free_result($result);
}

mysqli_close($lien);
?>


</body>
</html>
