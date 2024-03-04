<?php
// Vérifier si l'ID du produit est fourni dans la requête POST sur la page boutique
if (isset($_POST['user_id'])) {
    // Récupérer l'ID du produit depuis la requête POST
    $productId = $_POST['user_id'];

    // Supposons que l'ID de l'utilisateur est stocké dans une variable $userId (vous devez implémenter cette logique)
    $userId = 1; // Exemple d'ID d'utilisateur, vous devez récupérer l'ID de l'utilisateur connecté

    // Connexion à la base de données school
    $host = "localhost";
    $dbname = "school";
    $username = "root";
    $password = "";


// inormation sur 


    try {
        // Connexion à la base de données MySQL
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si l'utilisateur a déjà aimé ce produit
        // ”likes” est la table dans la base de donnée school qui permet de verifier si chaque utilisateur a clicker une seule fois sur le boutto. like
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM likes WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si l'utilisateur n'a pas encore aimé ce produit
        if ($result['count'] == 0) {
            // Mettre à jour le nombre de likes du produit
            $stmt = $pdo->prepare("UPDATE produits SET likes = likes + 1 WHERE id = :id");
            $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            // Insérer une nouvelle entrée dans la table likes pour enregistrer que l'utilisateur a aimé ce produit
            $stmt = $pdo->prepare("INSERT INTO likes (user_id, product_id) VALUES (:user_id, :product_id)");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            // Récupérer le nouveau nombre de likes du produit
            $stmt = $pdo->prepare("SELECT likes FROM produits WHERE id = :id");
            $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retourner le nombre de likes sous forme de réponse JSON
            echo json_encode(['likes' => $result['likes']]);
            header("Location: index.php");
        } else {
            // Si l'utilisateur a déjà aimé ce produit
            echo json_encode(['error' => 'Vous avez déjà aimé ce produit.']);
            header("Location: index.php");
        }
    } catch (PDOException $e) {
        // En cas d'erreur de connexion ou de requête SQL
        echo json_encode(['error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);

    }
} else {
    // Si l'ID du produit n'est pas fourni dans la requête POST
    echo json_encode(['error' => 'ID du produit non fourni.']);
}
?>
