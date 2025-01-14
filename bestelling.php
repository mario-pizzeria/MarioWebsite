<?php

$host = '127.0.0.1';
$db = 'mariopizzeria';
$user = 'extra';
$pass = 'Frikandel@1';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ontvang de gegevens van het formulier en controleer op aanwezigheid
    $naam = isset($_POST['naam']) ? $_POST['naam'] : null;
    $telefoonnummer = isset($_POST['telefoonnummer']) ? $_POST['telefoonnummer'] : null;
    $datum = date('Y-m-d H:i:s');
    
    // Controleer of de verplichte velden niet leeg zijn
    if ($naam && $telefoonnummer) {
        $producten = [
            1 => isset($_POST['product_1']) ? (int)$_POST['product_1'] : 0,
            2 => isset($_POST['product_2']) ? (int)$_POST['product_2'] : 0,
            3 => isset($_POST['product_3']) ? (int)$_POST['product_3'] : 0,
            4 => isset($_POST['product_4']) ? (int)$_POST['product_4'] : 0,
            5 => isset($_POST['product_5']) ? (int)$_POST['product_5'] : 0,
            6 => isset($_POST['product_6']) ? (int)$_POST['product_6'] : 0,
            7 => isset($_POST['product_7']) ? (int)$_POST['product_7'] : 0,
            8 => isset($_POST['product_8']) ? (int)$_POST['product_8'] : 0,
            9 => isset($_POST['product_9']) ? (int)$_POST['product_9'] : 0,
            10 => isset($_POST['product_10']) ? (int)$_POST['product_10'] : 0
        ];

        // START TRANSACTIE
        $pdo->beginTransaction();

        try {
            // 1. Voeg klant toe
            $stmt = $pdo->prepare("INSERT INTO klant (naam, telefoonnummer) VALUES (?, ?)");
            $stmt->execute([$naam, $telefoonnummer]);
            $klant_id = $pdo->lastInsertId();

            // 2. Maak bestelling aan
            $stmt = $pdo->prepare("INSERT INTO bestelling (klant_id, datum) VALUES (?, ?)");
            $stmt->execute([$klant_id, $datum]);
            $bestel_id = $pdo->lastInsertId();

            // 3. Voeg bestelregels toe
            foreach ($producten as $product_id => $aantal) {
                if ($aantal > 0) {
                    $stmt = $pdo->prepare("INSERT INTO bestel_regel (product_id, bestel_id, aantal) VALUES (?, ?, ?)");
                    $stmt->execute([$product_id, $bestel_id, $aantal]);

                    // Koppel pizzastatus automatisch
                    $bestelRegel_id = $pdo->lastInsertId();
                    $status_id = 1; // Veronderstelde status_id (bijvoorbeeld: 'In voorbereiding')
                    $stmt = $pdo->prepare("INSERT INTO pizza_status (bestelRegel_id, status_id, changed_at) VALUES (?, ?, ?)");
                    $stmt->execute([$bestelRegel_id, $status_id, $datum]);
                }
            }

            // TRANSACTIE VOLTOOIEN
            $pdo->commit();

            echo "Bestelling succesvol aangemaakt!";
        } catch (Exception $e) {
            // ROLLBACK bij een fout
            $pdo->rollBack();
            echo "Fout bij het aanmaken van de bestelling: " . $e->getMessage();
        }
    } else {
        echo "Vul alle velden correct in.";
    }
} else {
    echo "Formulier is niet correct ingediend.";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria Bestelling</title>
</head>
<body>
    <h2>Pizzeria Bestelling</h2>
    <form action="bestelling.php" method="POST">
        <fieldset>
            <legend>Klantgegevens</legend>
            <label for="naam">Naam:</label><br>
            <input type="text" id="naam" name="naam" required><br><br>
            <label for="telefoonnummer">Telefoonnummer:</label><br>
            <input type="text" id="telefoonnummer" name="telefoonnummer" required><br><br>
        </fieldset>
        <fieldset>
            <legend>Bestelgegevens</legend>
            <label for="product_1">Aantal Margherita:</label><br>
            <input type="number" id="product_1" name="product_1" value="0" min="0"><br><br>

            <label for="product_2">Aantal Pepperoni:</label><br>
            <input type="number" id="product_2" name="product_2" value="0" min="0"><br><br>

            <label for="product_3">Aantal Quattro Formaggi:</label><br>
            <input type="number" id="product_3" name="product_3" value="0" min="0"><br><br>

            <label for="product_3">Aantal Hawaï:</label><br>
            <input type="number" id="product_4" name="product_4" value="0" min="0"><br><br>

            <label for="product_3">Aantal Vegan Special:</label><br>
            <input type="number" id="product_5" name="product_5" value="0" min="0"><br><br>

            <label for="product_3">Aantal Coca-Cola:</label><br>
            <input type="number" id="product_6" name="product_6" value="0" min="0"><br><br>

            <label for="product_3">Aantal Fanta:</label><br>
            <input type="number" id="product_7" name="product_7" value="0" min="0"><br><br>

            <label for="product_3">Aantal Sprite:</label><br>
            <input type="number" id="product_8" name="product_8" value="0" min="0"><br><br>

            <label for="product_3">Aantal Tiramisu:</label><br>
            <input type="number" id="product_9" name="product_9" value="0" min="0"><br><br>

            <label for="product_3">Aantal Panna Cotta:</label><br>
            <input type="number" id="product_10" name="product_10" value="0" min="0"><br><br>
        </fieldset>
        <input type="submit" value="Bestellen">
    </form>
</body>
</html>
