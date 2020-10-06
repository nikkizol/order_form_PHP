<?php
//this line makes PHP behave in a more strict way

declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);


//we are going to use session variables so we need to enable sessions
session_start();
//SET SESSIONS TO DEFAULT

if (!isset($_SESSION["semail"])) {
    $_SESSION["semail"] = "";
}
if (!isset($_SESSION["sstreet"])) {
    $_SESSION["sstreet"] = "";
}

if (!isset($_SESSION["sstreetnumber"])) {
    $_SESSION["sstreetnumber"] = "";
}

if (!isset($_SESSION["scity"])) {
    $_SESSION["scity"] = "";
}

if (!isset($_SESSION["szipcode"])) {
    $_SESSION["szipcode"] = "";
}

if (!isset($_SESSION["sproducts"])) {
    $_SESSION["sproducts"] = [];
}

if (!isset($_SESSION["express"])) {
    $_SESSION["express"] = "";
}

function whatIsHappening()
{
//    echo '<h2>$_GET</h2>';
//    var_dump($_GET);
//    echo '<h2>$_POST</h2>';
//    var_dump($_POST);
//    echo '<h2>$_COOKIE</h2>';
//    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//your products with their price.

$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

//$products = [
//    ['name' => 'Cola', 'price' => 2],
//    ['name' => 'Fanta', 'price' => 2],
//    ['name' => 'Sprite', 'price' => 2],
//    ['name' => 'Ice-tea', 'price' => 3],
//];

$totalValue = 0;

// define variables and set to empty values
$emailErr = $streetErr = $streetNumbErr = $cityErr = $zipcodeErr = $productsErr = "";
$emailG = $streetG = $streetNumbG = $cityG = $zipcodeG = $productsG = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST["email"])) {
        $email = $_POST["email"];
        if (!empty (filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $emailG = "Good";
        } else {
            $emailErr = "* is not a valid email address";
        }
    }

    if (isset ($_POST["street"])) {
        $street = $_POST["street"];
        if (!empty (preg_match("/^[a-zA-Z\s]+$/", $street))) {
            $streetG = "Good";
        } else {
            $streetErr = "* is a required field";
        }
    }

    if (isset ($_POST["streetnumber"])) {
        $streetNumber = $_POST["streetnumber"];
        if (is_numeric($streetNumber)) {
            $streetNumbG = "Good";
        } else {
            $streetNumbErr = "* is not a valid Street number";
        }
    }

    if (isset ($_POST["city"])) {
        $city = $_POST["city"];
        if (!empty (preg_match("/^[a-zA-Z\s]+$/", $city))) {
            $cityG = "Good";
        } else {
            $cityErr = "* is not a valid city";
        }
    }

    if (isset ($_POST["zipcode"])) {
        $zipcode = $_POST["zipcode"];
        if (is_numeric($zipcode)) {
            $zipcodeG = "Good";
        } else {
            $zipcodeErr = "* is not a valid zipcode";
        }
    }

    if (!isset($_POST["products"])) {
        $productsErr = "* You must select at least one item!";
    } else {
        $productsG = "Good";
    }
}

if (isset($_POST['submit'])) {
    if (empty($emailErr) && empty($streetErr) && empty($streetNumbErr) && empty($cityErr) && empty($zipcodeErr)) {
        if (!isset($_POST['express_delivery'])) {
            $msg = date("H:i", strtotime('+2 hours'));
        } else {
            $msg = date("H:i", strtotime('+45 minutes'));
        }
        echo  '<div class="p-3 mb-2 bg-success text-white">Thank you for your order! The estimated time of delivery '.$msg.'</div>';
    };
    $_SESSION["semail"] = $email;
    $_SESSION["sstreet"] = $street;
    $_SESSION["sstreetnumber"] = $streetNumber;
    $_SESSION["scity"] = $city;
    $_SESSION["szipcode"] = $zipcode;
    if (isset($_POST["express_delivery"])) {
        $_SESSION["express"] = $_POST["express_delivery"];
    } else {
        $_SESSION["express"] = "";
    }
    if (isset($_POST['products'])) {
        foreach ($_POST['products'] as $value) {
            $array = array_push($_SESSION["sproducts"], $value);
            $_SESSION["sproducts"] = array_unique($_SESSION["sproducts"]);

        }
    } else {
        $value = $_POST['products'];


    }

}

whatIsHappening();

if (isset($_GET['food'])) {
    if ($_GET['food'] == '1') {
        $products = [
            ['name' => 'Club Ham', 'price' => 3.20],
            ['name' => 'Club Cheese', 'price' => 3],
            ['name' => 'Club Cheese & Ham', 'price' => 4],
            ['name' => 'Club Chicken', 'price' => 4],
            ['name' => 'Club Salmon', 'price' => 5]
        ];
    } elseif ($_GET['food'] == '0') {
        $products = [
            ['name' => 'Cola', 'price' => 2],
            ['name' => 'Fanta', 'price' => 2],
            ['name' => 'Sprite', 'price' => 2],
            ['name' => 'Ice-tea', 'price' => 3],
        ];
    }
}

//if (isset($_SESSION["sproducts"]) && in_array($products['price'], $_SESSION["sproducts"])) {
//    echo ;
//}
echo array_sum($_SESSION["sproducts"]);

require 'form-view.php';