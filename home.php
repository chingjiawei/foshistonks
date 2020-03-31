<?php

// // $username = 'mary';
// if ( isset($_SESSION['username']) ){
//     $username = $_SESSION['username'];
// } else {
//     echo "you should login first :)";
//     return;
// }

?>

<script>
    alert(sessionStorage.getItem('username'))
</script>

<!DOCTYPE html>
<html>

<head>
	<title>FoshiStonk</title>
	<link rel="apple-touch-icon" sizes="180x180" href="src/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="src/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="src/icons/favicon-16x16.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="images/icons/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Bootstrap libraries -->
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">

   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
	<script src="js/main.js"></script>

</head>

<!-- Page passes the container for the graph to the program -->

<body id="home_body">
    <div class='col-3 home_left'>
        <h1></h1>
        <div class='equipment pointer'>
            <img src="src/img/equipment_thumbnail.png" alt="">
            <h2>EQUIPMENT</h2>
        </div>
        <div class='shop'>
            <img src="src/img/shop_thumbnail.png" alt="">
            <h2>SHOP</h2>
        </div>
    </div>
    <div class='col-3 home_mid'>
        <h1>MY HOME</h1>
        <div class='claimCoin'>
            <img class='bounce-7' src="src/img/claim_coin.png" alt="">
        </div>
        <div class='me'>
            <img src="src/img/me.png" alt="">
        </div>
    </div>
    <div class='col-3 home_right'>
        <div class='quick_btn'>
            <img src="src/icons/user.png" alt="">
            <a href="logout.php">LOG OUT</a>
        </div>
        <div class='stock'>
            <h2>STOCK</h2>
            <img src="src/img/stock_thumbnail.png" alt="">
        </div>
        <div class='account'>
            <h2>ACCOUNT</h2>
            <img src="src/img/account_thumbnail.png" alt="">
        </div>
    </div>

	<script>
        $('.equipment').click(function() {
            window.location.href = '/foshistonks/equipment.php';
            return false;
        });
    </script>
</body>

</html>