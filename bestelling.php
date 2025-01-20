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

                    //Koppel pizzastatus automatisch
                    $bestelRegel_id = $pdo->lastInsertId();
                    $status_id = 2; // Veronderstelde status_id (bijvoorbeeld: 'In voorbereiding')
                    $stmt = $pdo->prepare("INSERT INTO pizza_status (bestelRegel_id, status_id, changed_at) VALUES (?, ?, ?)");
                    $stmt->execute([$bestelRegel_id, $status_id, $datum]);
                }
            }

            // TRANSACTIE VOLTOOIEN
            $pdo->commit();

            echo "<p class='echo'> Bestelling succesvol aangemaakt! </p>";
        } catch (Exception $e) {
            // ROLLBACK bij een fout
            $pdo->rollBack();
            echo "<p class='echo'> Fout bij het aanmaken van de bestelling: </p>" . $e->getMessage();
        }
    } else {
        echo "Vul alle velden correct in.";
    }
} else {
    echo "<p class='echo'> Formulier is niet correct ingediend. </p>";
}
?>

<html><!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserveer - Mario & Luigi's Pizza's</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="orderscreen">
        <video src="backgroundvid.mp4" muted loop autoplay></video>
        <img class= "chefbackground" src="chef_background.png" alt="chef in the background">
        <img class="standardBackground" src="bestellen_background.png" alt="Menu background">
        <div class="backgroundhue"></div>
        <div class="line-1"></div>
        <div class="line-2"></div>
        <div>
            <p class="numberbackground">02</p>
            <p class="textbackground">Bestellen</p>
        </div>
        <div class="foodtype"> 
            <ul>
                <li id="type1">Pizza's</li>
                <li id="type2">Vegetarisch</li>
                <li id="type3">Drank</li>
                <li id="type4">Dessert</li>
            </ul>
        </div>
        
        <div class="message"></div>

        <form action="bestelling.php" method="POST">

            <div class ="foodmenu">
                    <label for="product_1">Aantal Margherita:</label><br>
                    <input type="number" id="product_1" name="product_1" value="0" min="0"><br><br>

                    <label for="product_2">Aantal Pepperoni:</label><br>
                    <input type="number" id="product_2" name="product_2" value="0" min="0"><br><br>

                    <label for="product_3">Aantal Quattro Formaggi:</label><br>
                    <input type="number" id="product_3" name="product_3" value="0" min="0"><br><br>

                    <label for="product_3">Aantal Hawaï:</label><br>
                    <input type="number" id="product_4" name="product_4" value="0" min="0"><br><br>
            </div>

            <div class ="foodmenu">
                <label for="product_3">Aantal Vegan Special:</label><br>
                <input type="number" id="product_5" name="product_5" value="0" min="0"><br><br>
            </div>

            <div class ="foodmenu">
                <label for="product_3">Aantal Coca-Cola:</label><br>
                <input type="number" id="product_6" name="product_6" value="0" min="0"><br><br>

                <label for="product_3">Aantal Fanta:</label><br>
                <input type="number" id="product_7" name="product_7" value="0" min="0"><br><br>

                <label for="product_3">Aantal Sprite:</label><br>
                <input type="number" id="product_8" name="product_8" value="0" min="0"><br><br>
            </div>
            
            <div class ="foodmenu" id="foodlist">
                <label for="product_3">Aantal Tiramisu:</label><br>
                <input type="number" id="product_9" name="product_9" value="0" min="0"><br><br>

                <label for="product_3">Aantal Panna Cotta:</label><br>
                <input type="number" id="product_10" name="product_10" value="0" min="0"><br><br>
            </div>

            <div id="overlay_cart">
                <h1>Bestelling:</h1>
                <legend>Klantgegevens</legend>
                <label for="naam">Naam:</label><br>
                <input type="text" id="naam" name="naam" required><br><br>
                <label for="telefoonnummer">Telefoonnummer:</label><br>
                <input type="text" id="telefoonnummer" name="telefoonnummer" required><br><br>
                <h2>Producten:</h2>
                <ul id="productenlijst">
                </ul>
                <p>Totaal Prijs:</p>
                <p Id="totalPrice"></p>
                <input type="submit" value="Bestellen">
            </div> 
    </form>
    <img id="cart" src="shoppingcart.png" alt="pictogram winkelwagen">
    <a href="index.html"><img class="backarrow" src="backarrow_std.png" alt="Go back to main menu."></a>    
    </section>

<script>
    const message = document.getElementsByClassName("message")[0];
    const pizza = document.getElementsByClassName("foodmenu")[0];
    const vega = document.getElementsByClassName("foodmenu")[1];
    const drank = document.getElementsByClassName("foodmenu")[2];
    const desert = document.getElementsByClassName("foodmenu")[3];
    let typeID;
    let cartOpen = false;
    let x = 1;

    window.onload=function(){

        const typePizza = document.getElementById("type1");
        const typeVega = document.getElementById("type2");
        const typeDrank = document.getElementById("type3");
        const typeDesert = document.getElementById("type4");
        const cart = document.getElementById("cart");

        let echo = document.getElementsByClassName("echo")[0];

        typePizza.addEventListener("click", 
            function(){
                typeID = 1;
                document.getElementById("type1").style.color="rgb(0, 0, 0)";
                document.getElementById("type2").style.setProperty("color", "rgb(255, 255, 255)");
                document.getElementById("type3").style.setProperty("color", "rgb(255, 255, 255)");
                document.getElementById("type4").style.setProperty("color", "rgb(255, 255, 255)");
                switchType()
            });
        typeVega.addEventListener("click",
            function(){ 
                typeID = 2;
                document.getElementById("type2").style.setProperty("color", "rgb(0, 0, 0)");
                document.getElementById("type1").style.setProperty("color", "rgb(255, 255, 255)");
                document.getElementById("type3").style.setProperty("color", "rgb(255, 255, 255)");
                document.getElementById("type4").style.setProperty("color", "rgb(255, 255, 255)");
                switchType()
            });
        typeDrank.addEventListener("click", 
            function(){ 
                typeID = 3;
                document.getElementById("type3").style.setProperty("color", "rgb(0, 0, 0)");
                document.getElementById("type1").style.setProperty("color", "rgb(255, 255, 255)");
                document.getElementById("type2").style.setProperty("color", "rgb(255, 255, 255)");
                document.getElementById("type4").style.setProperty("color", "rgb(255, 255, 255)");
                switchType()
            });
        typeDesert.addEventListener("click", 
            function(){
                typeID = 4;
                document.getElementById("type4").style.setProperty("color", "rgb(0, 0, 0)");
                document.getElementById("type1").style.setProperty("color", "rgb(255, 255, 255)");
                document.getElementById("type2").style.setProperty("color", "rgb(255, 255, 255)");
                document.getElementById("type3").style.setProperty("color", "rgb(255, 255, 255)");
                switchType()
            });
        cart.addEventListener("click", openCart);
        message.appendChild(echo);
        }

    function switchType()
    {   

        switch(typeID) {
        case 1:
            pizza.style.display="inline";
            vega.style.display="none";
            drank.style.display="none";
            desert.style.display="none";
            message.style.display="none";
            break;
        case 2:
            pizza.style.display="none";
            vega.style.display="inline";
            drank.style.display="none";
            desert.style.display="none";
            message.style.display="none";
            break;
        case 3:
            pizza.style.display="none";
            vega.style.display="none";
            drank.style.display="inline";
            desert.style.display="none";
            message.style.display="none";
            break;
        case 4:
            pizza.style.display="none";
            vega.style.display="none";
            drank.style.display="none";
            desert.style.display="inline";
            message.style.display="none";
            break;
        }   
    }


    function openCart()
    {
        if(openCart)
        {
            let list = document.getElementById("productenlijst");
            document.getElementById("overlay_cart").style.display='none';
            openCart = false;
            list.removeChild(list.firstChild);
        }
        else
        {
            document.getElementById("overlay_cart").style.display='inline';
            openCart = true;
            showPrice();
        }
    }

    function showPrice()
    {
        let list = document.getElementById("productenlijst");

        let margherita = document.getElementById("product_1");
        let pepperoni = document.getElementById("product_2");
        let quattro = document.getElementById("product_3");
        let hawai = document.getElementById("product_4");
        let veganspecial = document.getElementById("product_5");
        let cocacola = document.getElementById("product_6");
        let fanta = document.getElementById("product_7");
        let sprite = document.getElementById("product_8");
        let tiramisu = document.getElementById("product_9");
        let pannacotta = document.getElementById("product_10");

        let totalPrice = 0;

        if(margherita.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Pizza Margherita";
            newPrice.innerHTML = "€8,50";
            newCount.innerHTML = margherita.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < margherita.value; i++)
            {
                totalPrice = totalPrice + 8.50;
            }
        }
        if(pepperoni.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Pizza Pepperoni";
            newPrice.innerHTML = "€10,00";
            newCount.innerHTML = pepperoni.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < pepperoni.value; i++)
            {
                totalPrice = totalPrice + 10.00;
            }
        }
        if(quattro.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Pizza Quattro Formaggi";
            newPrice.innerHTML = "€12,00";
            newCount.innerHTML = quattro.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < quattro.value; i++)
            {
                totalPrice = totalPrice + 12.00;
            }
        }
        if(hawai.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Pizza Hawaï";
            newPrice.innerHTML = "€9,50";
            newCount.innerHTML = hawai.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < hawai.value; i++)
            {
                totalPrice = totalPrice + 9.50;
            }
        }
        if(veganspecial.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Pizza Vegan Special";
            newPrice.innerHTML = "€11,00";
            newCount.innerHTML = veganspecial.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < veganspecial.value; i++)
            {
                totalPrice = totalPrice + 11.00;
            }
        }
        if(cocacola.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Coca-Cola";
            newPrice.innerHTML = "€2,50";
            newCount.innerHTML = cocacola.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < cocacola.value; i++)
            {
                totalPrice = totalPrice + 2.50;
            }
        }
        if(fanta.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Fanta";
            newPrice.innerHTML = "€2,50";
            newCount.innerHTML = fanta.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < fanta.value; i++)
            {
                totalPrice = totalPrice + 2.50;
            }
        }
        if(sprite.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Sprite";
            newPrice.innerHTML = "€2,50";
            newCount.innerHTML = sprite.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < sprite.value; i++)
            {
                totalPrice = totalPrice + 2.50;
            }
        }
        if(tiramisu.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Tiramisu";
            newPrice.innerHTML = "€5,00";
            newCount.innerHTML = tiramisu.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < tiramisu.value; i++)
            {
                totalPrice = totalPrice + 5.00;
            }
        }
        if(pannacotta.value > 0)
        {
            let newProduct = document.createElement("li");
            newProduct.className = 'productlist';
            let newName = document.createElement("p");
            let newPrice = document.createElement("p");
            let newCount = document.createElement("p");
            newName.innerHTML = "Panna Cotta";
            newPrice.innerHTML = "€5,50";
            newCount.innerHTML = pannacotta.value + "x";
            list.appendChild(newProduct);
            newProduct.appendChild(newName);
            newProduct.appendChild(newPrice);
            newProduct.appendChild(newCount);
            for(let i = 0; i < pannacotta.value; i++)
            {
                totalPrice = totalPrice + 5.50;
            }
        }

        document.getElementById("totalPrice").innerHTML= "€" + totalPrice;
    }

    </script>
</body>
</html>
