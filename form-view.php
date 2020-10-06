<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
    <style>
        .error {
            color: #FF0000;
        }

        .good {
            color: green;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post" action="/index.php" autocomplete="on">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control"
                       value="<?php echo $_SESSION["semail"] ?>"/>
                <span class="error"><?php echo $emailErr; ?></span>
                <span class="good"><?php echo $emailG; ?></span>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control"
                           value="<?php echo $_SESSION["sstreet"] ?>">
                    <span class="error"><?php echo $streetErr; ?></span>
                    <span class="good"><?php echo $streetG; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control"
                           value="<?php echo $_SESSION["sstreetnumber"] ?>">
                    <span class="error"><?php echo $streetNumbErr; ?></span>
                    <span class="good"><?php echo $streetNumbG; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control"
                           value="<?php echo $_SESSION["scity"] ?>">
                    <span class="error"><?php echo $cityErr; ?></span>
                    <span class="good"><?php echo $cityG; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control"
                           value="<?php echo $_SESSION["szipcode"] ?>">
                    <span class="error"><?php echo $zipcodeErr; ?></span>
                    <span class="good"><?php echo $zipcodeG; ?></span>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
                    <input type="checkbox" value="<?php echo $product['name']; ?>" <?php if (isset($_SESSION["sproducts"]) && in_array($product['name'], $_SESSION["sproducts"])) { echo "checked='checked'"; } ?> name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?>
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br/>
            <?php endforeach; ?>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5" <?php if (isset($_POST['express_delivery'])) echo "checked='checked'"; ?>/>
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" name="submit" class="btn btn-primary">Order!</button>
    </form>
    <span class="error"><?php echo $productsErr; ?></span>
    <span class="good"><?php echo $productsG; ?></span>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>