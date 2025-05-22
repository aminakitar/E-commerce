<?php
session_start(); // Démarrer la session pour pouvoir la détruire

// Supprimer toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil (ou vers login.php si tu veux)
header('Location: accueil.php');
exit;
?>
