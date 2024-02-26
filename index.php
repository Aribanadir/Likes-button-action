<?php

session_start();

$host = "localhost";
$dbname = "school";
$username = "root"; // Votre nom d'utilisateur de base de données
$password = ""; // Votre mot de passe de base de données

try {
 $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 $stmt = $pdo->query("SELECT id, likes FROM products");

    ?>
    <html lang="en" >
    <head>
      <meta charset="UTF-8">
      <title>Likes.Github - AribaMS</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://vjs.zencdn.net/5-unsafe/video-js.css'><link rel="stylesheet" href="./style.css">

    </head>

<style>

.card-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.card {
  margin: 20px;
  background-color: #2C2C3A;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  width: 270px;
}

.card:hover {
  box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.card img {
  width: 100%;
}

.card-content {
  padding: 20px;
}

.card-content p {
  margin: 5px 0;
  font-size: 14px;
}
</style>

<body>

<div class='card-container'>

<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<div class='card'>";
      // Image ou couverture du produits ( Récupéré depuis la base de donnée )
      echo "<img src='./uploads/" . htmlspecialchars($row['couverture']) . "' alt='Cover'>";
      echo "<div class='card-content'>";
      // Titre ou Nom du produit ( Récupéré depuis la base de donnée )
      echo "<h4><b>" . htmlspecialchars($row['titre']) . "</b></h4>";
      // Nombre de likes ( Récupéré depuis la base de donnée )
      echo "<p><strong>Likes:</strong>" . htmlspecialchars($row['likes']) . "</p>";
      // Bouton "like" avec attribut data-product-id
      echo "<form method='post' action='like_product.php'>";
echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
echo "<div class='button-wrapper'>";
echo "<button class='like-btn like red' data-product-id='" . htmlspecialchars($row['id']) . "'>";
?>
<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M15.85 2.5c.63 0 1.26.09 1.86.29 3.69 1.2 5.02 5.25 3.91 8.79a12.728 12.728 0 01-3.01 4.81 38.456 38.456 0 01-6.33 4.96l-.25.15-.26-.16a38.093 38.093 0 01-6.37-4.96 12.933 12.933 0 01-3.01-4.8c-1.13-3.54.2-7.59 3.93-8.81.29-.1.59-.17.89-.21h.12c.28-.04.56-.06.84-.06h.11c.63.02 1.24.13 1.83.33h.06c.04.02.07.04.09.06.22.07.43.15.63.26l.38.17c.092.05.195.125.284.19.056.04.107.077.146.1l.05.03c.085.05.175.102.25.16a6.263 6.263 0 013.85-1.3zm2.66 7.2c.41-.01.76-.34.79-.76v-.12a3.3 3.3 0 00-2.11-3.16.8.8 0 00-1.01.5c-.14.42.08.88.5 1.03.64.24 1.07.87 1.07 1.57v.03a.86.86 0 00.19.62c.14.17.35.27.57.29z" />
</svg>
<?php
echo "</button></form>";
echo "<button class='like-btn like'>";
?>
</body>

