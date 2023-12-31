<?php


$servername = "mysql:host=mysql";
$username = getenv("MYSQL_USER");
$password_db = getenv("MYSQL_PASSWORD");
$dbname = getenv("MYSQL_DATABASE");



$conn = new PDO("$servername;dbname=$dbname; charset=utf8", $username, $password_db);

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
        $sql = "CREATE TABLE categories (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
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
    <title>Créer une table</title>
</head>
<body>
    <h1>Créer un nouveau livre</h1>
    <form action="" method="POST">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required><br>

        <label for="author">Auteur :</label>
        <input type="text" id="author" name="author" required><br>

        <label for="publication_year">Année de publication :</label>
        <input type="text" id="publication_year" name="publication_year" required><br>

        <input type="submit" value="Créer la table">
    </form>

    <script>
        function addColumn() {
            const columnsDiv = document.getElementById('columns');
            const newColumn = document.createElement('div');
            newColumn.classList.add('column');
            newColumn.innerHTML = `
                <label for="column_name[]">Nom de la colonne :</label>
                <input type="text" name="column_name[]" required>
                <label for="column_type[]">Type de la colonne :</label>
                <input type="text" name="column_type[]" required>
                <button type="button" class="delete-column" onclick="deleteColumn(this)">Supprimer</button>
            `;
            columnsDiv.appendChild(newColumn);
        }

        function deleteColumn(button) {
            const columnDiv = button.parentElement;
            const columnsDiv = document.getElementById('columns');
            columnsDiv.removeChild(columnDiv);
        }
    </script>
</body>
</html>

