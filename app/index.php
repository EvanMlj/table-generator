<?php

session_start();

$error = "";

$servername = "mysql:host=mysql";
$username = getenv("MYSQL_USER");
$password_db = getenv("MYSQL_PASSWORD");
$dbname = getenv("MYSQL_DATABASE");



$conn = new PDO("$servername;dbname=$dbname; charset=utf8", $username, $password_db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(
        isset($_POST['csrf_token']) &&
        isset($_SESSION['csrf_token']) &&
        $_SESSION['csrf_token'] === $_POST['csrf_token']
    ){

        if($_POST['tableName'] !== "" && $_POST['colonne'] !== "" && isset($_POST['tableName']) && isset($_POST['colonne'])) {
        

            $colonne = $_POST['colonne'];
            $tableName = $_POST['tableName'];
            $colonneType = $_POST['colonneType'];
    
            if($_POST['colonne2'] !== ""){
                $colonne2 = $_POST['colonne2'];
                $colonneType2 = $_POST['colonneType2'];
            }
            
            try {
    
                if($_POST['colonne2'] !== "" && isset($_POST['colonne2'])){
                    $sql = "CREATE TABLE IF NOT EXISTS :tableName (:colonne :colonneType NOT NULL, :colonne2 :colonneType2 NOT NULL)";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS :tableName (:colonne :colonneType NOT NULL)";
                }
                
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
                $stmt->bindParam(':colonne', $colonne, PDO::PARAM_STR);
                $stmt->bindParam(':colonneType', $colonneType, PDO::PARAM_STR);
                if($_POST['colonne2'] !== ""){
                    $stmt->bindParam(':colonne2', $colonne2, PDO::PARAM_STR);
                    $stmt->bindParam(':colonneType2', $colonneType2, PDO::PARAM_STR);
                }
                $stmt->execute();
                
                $error = "valid";
    
            } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
       
        } else {
           $error = "error";
        }
    
        // Insérer les données dans la table "Book"
    
    }
    
    } else {
        $error = "CSRF"; 
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
    <?php
    if($error === "error"){
        echo 
        "<div class='alert alert-danger' role='alert'>
        Vous devez renseignez le nom de la table et de la première colonne.
        </div>";
    } else if ($error === "valid"){
        echo
        "<div class='alert alert-success' role='alert'>
        La table à été créé avec succès ! 
        </div>";

    } else if ($error === "CSRF"){
        echo
        "<div class='alert alert-danger' role='alert'>
        Alerte CSRF. 
        </div>";

    }

$csrf_token = bin2hex(random_bytes(32));
$_SESSION['crsf_token'] = $csrf_token; 

?>
    
    <form action="" method="POST">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required><br>

        <label for="author">Auteur :</label>
        <input type="text" id="author" name="author" required><br>

        <label for="publication_year">Année de publication :</label>
        <input type="text" id="publication_year" name="publication_year" required><br>

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="submit" value="Créer le livre">
    </form>
</body>
</html>