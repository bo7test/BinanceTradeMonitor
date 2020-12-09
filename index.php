
<?php require "db.php" ?>
<?php

    // DELETING CARD
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $query = "DELETE FROM data WHERE id = $id";
        $stmt = mysqli_query($conn, $query) or die(mysqli_error($conn));
        header("Location: index.php");
    }


    // WRITING QUERY FOR UPDATING CURRENT AMOUNT
    $query1 = "SELECT * FROM data";
    $data1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));

    while($row1 = mysqli_fetch_array($data1)) {
        $symbol1 = $row1['symbol'];
        updateCoin($symbol1);
    }

    function updateCoin($symbol){
        require "db.php";
        $url = "https://api.binance.com/api/v3/ticker/price?symbol=$symbol";
        $json = file_get_contents($url);
        $jsonObj = json_decode($json);
        $value = $jsonObj->price;

        $query = "UPDATE data set `currentAmount` = $value WHERE `symbol` = '$symbol'";
        $stmt = mysqli_query($conn, $query) or die(mysqli_error($conn));
    }

    if(isset($_POST['addCoinBtn'])){
        $message = '';
        $class = '';
        $symbol = $_POST['symbol'];
        $currency = $_POST['currency'];

        $url = "https://api.binance.com/api/v3/ticker/price?symbol=$symbol";
        $json = file_get_contents($url);
        $jsonObj = json_decode($json);

        // VALIDATION
        $query = "SELECT * FROM options WHERE symbol = '$symbol'";
        $stmt_count = mysqli_query($conn, $query) or die(mysqli_error($conn));



        if($symbol != $jsonObj->symbol){
            $message = 'Please add a correct Symbol! e.g BNBBTC';
            $class = 'alert-danger';
        }
        else if(mysqli_num_rows($stmt_count) > 0){
            $message = 'Symbol Already Added!';
            $class = 'alert-danger';
        }
        else{
        $query = "INSERT INTO options (`symbol`, `currency`) VALUES ('$symbol', '$currency')";
        $stmt = mysqli_query($conn, $query) or die(mysqli_error($conn));
        header("Location: index.php");
        $message = 'Symbol Added';
        $class = 'alert-success';
        }
    }
    if(isset($_POST['saveBtn'])){
        $amountPost = $_POST['amount'];
        $symbolPost = $_POST['symbol'];
        $typePost = $_POST['type'];
        $quantityPost = $_POST['quantity'];

        getApi($amountPost, $symbolPost, $typePost, $quantityPost);

    }

    function getApi($amount, $symbol, $type, $quantity){
        // Reading JSON POST using PHP
        $url = "https://api.binance.com/api/v3/ticker/price?symbol=$symbol";
        $json = file_get_contents($url);
        $jsonObj = json_decode($json);

        // Use $jsonObj
        $current = $jsonObj->price;

        require "db.php";


        $query = "INSERT INTO data (`amount`, `symbol`, `type`, `currentAmount`, `quantity`) VALUES ($amount, '$symbol', '$type', $current, $quantity);";
        $stmt = mysqli_query($conn, $query) or die(mysqli_error($conn));
        header("Location: index.php");


    }




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="300">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href='style.css' rel='stylesheet'>
    <title>CRYPTO TRADER</title>
</head>
<body>

    <div class="cardSection">
    <h1 class='display-4 text-center'>ALL TRADES</h1>

        <a target="_blank" href="invest.php">INVESTMENTS</a>
        <div class="container append">
            <?php
            $query = "SELECT * FROM data ORDER BY id DESC";
            $data = mysqli_query($conn, $query) or die(mysqli_error($conn));



            while ($row = mysqli_fetch_assoc($data)) {
                $amountInitial = $row['amount'];
                $symbol = $row['symbol'];
                $type = $row['type'];
                $currentInitial = $row['currentAmount'];
                $quantity = $row['quantity'];
                $message = 'loosing';
                $id = $row['id'];

                $amount = $amountInitial * $quantity;
                $current = $currentInitial * $quantity;

                // WRITING QUERY TO GET CURRENCY OF SYMBOL
                $queryOptions = "SELECT * FROM options WHERE symbol = '$symbol'";
                $dataOptions = mysqli_query($conn, $queryOptions) or die(mysqli_error($conn));
                $rowOptions = mysqli_fetch_assoc($dataOptions);
                $currency = $rowOptions['currency'];



                $profitGrowth = round(($amount - $current) / $amount * 100, 3);
                $profitGrowthStr = strval($profitGrowth);
                $profitGrowthValue = str_replace("-", "", $profitGrowthStr);

                if($type === 'buy'){
                    $profit = round($current - $amount, 3);
                    $profitStr = strval($profit);
                    $profitValue = str_replace("-", "", $profitStr);

                    $class = '';
                    $fee = 2*(0.075/100)*$amount;

                    if($amount > $current){
                        $message = $profitValue + $fee . ' loosing';
                        echo
                        "<div class='card card-body'>
                            <p id='nameCoin'>$symbol</p>
                            <p class='type'>$type</p>
                            <div class='amountCard'>
                                <p id='entry'>Entry: $amountInitial $currency ($quantity) </p>
                                <p id='current'>Current: $currentInitial $currency</p>
                              <p id='amount_i'>Amount: $amount $currency</p>
                              <p id='fee_i'>Fee: $fee  </p>

                            </div>
                            <div class='percentage'>
                                <div class='percentageValue'>
                                    <p class='dangerMsg'>$profitGrowthValue%</p>
                                </div>
                                <div class='percentageInfo'>
                                    <p class='dangerMsg'>$message</p>
                                </div>
                            </div>

                            <a href='index.php?delete=$id' class='btn btn-dark btn-sm'>delete</a>
                        </div>";
                    }else if($amount < $current){
                        $message = $profitValue + $fee . ' gaining';
                        echo
                        "<div class='card card-body'>
                            <p id='nameCoin'>$symbol</p>
                            <p class='type'>$type</p>
                            <div class='amountCard'>
                                <p id='entry'>Entry: $amountInitial $currency ($quantity)</p>
                                <p id='current'>Current: $currentInitial $currency</p>
                                <p id='amount_i'>Amount: $amount $currency</p>
                                <p id='fee_i'>Fee: $fee  </p>
                            </div>
                            <div class='percentage'>
                                <div class='percentageValue'>
                                    <p class='successMsg'>$profitGrowthValue%</p>
                                </div>
                                <div class='percentageInfo'>
                                    <p class='successMsg'>$message</p>
                                </div>
                            </div>
                            <a href='index.php?delete=$id' class='btn btn-dark btn-sm'>delete</a>
                        </div>";
                    }
                }else{
                    $profit = round($current - $amount, 3);
                    $profitStr = strval($profit);
                    $profitValue = str_replace("-", "", $profitStr);

                    $class = '';
                    $fee = 2*(0.075/100)*$amount;
                    if($amount > $current){
                        $message = $profitValue + $fee . ' gaining';
                        echo
                        "<div class='card card-body'>
                            <p id='nameCoin'>$symbol</p>
                            <p class='type'>$type</p>
                            <div class='amountCard'>
                                <p id='entry'>Entry: $amountInitial $currency ($quantity)</p>
                                <p id='current'>Current: $currentInitial $currency</p>
                              <p id='amount_i'>Amount: $amount $currency</p>
                              <p id='fee_i'>Fee: $fee  </p>

                            </div>
                            <div class='percentage'>
                                <div class='percentageValue'>
                                    <p class='successMsg'>$profitGrowthValue%</p>
                                </div>
                                <div class='percentageInfo'>
                                    <p class='successMsg'>$message</p>
                                </div>
                            </div>
                            <a href='index.php?delete=$id' class='btn btn-dark btn-sm'>delete</a>
                        </div>";
                    }else if($amount < $current){
                        $message = $profitValue + $fee . ' loosing';
                        echo
                        "<div class='card card-body'>
                            <p id='nameCoin'>$symbol</p>
                            <p class='type dangerMsg'>$type</p>
                            <div class='amountCard'>
                                <p id='entry'>Entry: $amountInitial $currency ($quantity)</p>
                                <p id='current'>Current: $currentInitial $currency</p>
                                 <p id='amount_i'>Amount: $amount $currency</p>
                                 <p id='fee_i'>Fee: $fee  </p>

                            </div>
                            <div class='percentage'>
                                <div class='percentageValue'>
                                    <p class='dangerMsg'>$profitGrowthValue%</p>
                                </div>
                                <div class='percentageInfo'>
                                    <p class='dangerMsg'>$message</p>
                                </div>
                            </div>
                            <a href='index.php?delete=$id' class='btn btn-dark btn-sm'>delete</a>
                        </div>";
                    }
                }



        }


            ?>
        </div>
    </div>

    <hr style='border:1px solid black'>

    <div class="container">
            <div>
                <h1 class="display-4 text-center">Enter a Trade</h1>
            </div>
        <div class="informationSection">
            <div>
                <form action='' method='POST'>
                    <div class="form-group">
                        <label for="amount">Enter Amount</label>
                        <input class="form-control" name="amount" id="amount" placeholder="Enter Amount">
                    </div>
                    <div class="form-group">
                        <label for="symbol">Select Symbol</label>
                        <select name="symbol" id="symbol" required>
                            <option>Select Coin</option>
                        <?php
                        $query = "SELECT * FROM options";
                        $data = mysqli_query($conn, $query) or die(mysqli_error($conn));



                        while ($row = mysqli_fetch_assoc($data)) {
                            $option  = $row['symbol'];
                            echo "<option value='$option'>$option</option>";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Enter Quantity</label>
                        <input class="form-control" name="quantity" id="quantity" placeholder="Enter Quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="buy">buy</label>
                        <input type="radio" name="type" id="buy" value='buy' required>
                    </div>
                    <div class="form-group">
                        <label for="sell">sell</label>
                        <input type="radio" name="type" id="sell" value='sell' required>
                    </div>
                    <button class="btn btn-outline-secondary" name="saveBtn" id="saveBtn">SAVE</button>
                </form>
            </div>
            <div>

                <form method='post' action='' class='addSymbolSection'>
                    <div class="form-group">
                        <?php
                        if(isset($_POST['addCoinBtn'])){
                            echo "<p class='alert $class'>$message</p>";
                        }
                        ?>
                        <label for="currency">Currency</label>
                        <input class="form-control" name="currency" id="currency" placeholder="eg. BTC" required>
                    </div>
                    <div class="form-group">
                        <label for="symbol">Symbol</label>
                        <input class="form-control" name="symbol" id="symbol" placeholder="eg. BTCUSDT" required>
                    </div>
                    <button name='addCoinBtn' class='btn btn-dark' type='submit'>Add Coin</button>
                </form>

            </div>
        </div>
    </div>

<script>

// SETTING THE COLOR OF BUY/SELL
const type = document.querySelectorAll(".type");
type.forEach(data =>{
    const value = data.textContent;
    if(value === 'buy'){
        data.style.color = 'green';
    }else{
        data.style.color = 'red';
    }
})



</script>
</body>
</html>
