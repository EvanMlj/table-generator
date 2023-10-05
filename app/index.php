<?php
require_once  'config.php' ;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];

    // Valider les données (ajoutez d'autres validations si nécessaire)
    if (empty($title) || empty($author) || empty($publication_year)) {
        die("Veuillez remplir tous les champs.");
    }

    // Insérer les données dans la table "Book"
    try {
        $stmt = $pdo->prepare("INSERT INTO Book (title, author, publication_year) VALUES (?, ?, ?)");
        $stmt->execute([$title, $author, $publication_year]);
        echo "Livre créé avec succès !";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un livre</title>
</head>
<body>
    <h1>Créer un nouveau livre</h1>
    <form action="process_create_book.php" method="POST">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required><br>

        <label for="author">Auteur :</label>
        <input type="text" id="author" name="author" required><br>

        <label for="publication_year">Année de publication :</label>
        <input type="text" id="publication_year" name="publication_year" required><br>

        <input type="submit" value="Créer le livre">
    </form>
</body>
</html>