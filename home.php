
<script>
    // alert(sessionStorage.getItem('username')); //test if session exists
</script>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">

    <title>FoshiStonk</title>
	<link rel="apple-touch-icon" sizes="180x180" href="src/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="src/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="src/icons/favicon-16x16.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="images/icons/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

    <meta name="viewport" 
        content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/main.css">

    <!-- Latest compiled and minified JavaScript -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script 
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--     
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>
    
    <script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>
    <script src="js/main.js"></script> -->
</head>

<!-- Page passes the container for the graph to the program -->

<body id="home_body">
    <div class='col-3 home_left'>
        <h1 class='account_info'>
            <!-- Hi, <b class='name'>Mary</b>:) You are <b class='balance'>$3.00</b> stonks rich! -->
        </h1>
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
        <div class='me' id='me'>
            <img class="ori_foshi" src="src/img/me_test.png" alt="">
        </div>
    </div>
    <div class='col-3 home_right'>
        <div class='quick_btn'>
            <img src="src/icons/user.png" alt="">
            <a href="logout.php" style='color:#fff;'>LOG OUT</a>
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
        $('.shop').click(function() {
            window.location.href = '/foshistonks/shop.php';
            // document.location.href="/foshistonks/shop.php"; 
            return false;
        });
        $('.stock').click(function() {
            window.location.href = '/foshistonks/stock.php';
            return false;
        });
        $('.account').click(function() {
            window.location.href = '/foshistonks/account.php';
            return false;
        });

        $(async() => { 
            var username = sessionStorage.getItem('username');
            var serviceURL2 = "http://127.0.0.1:5000/account/" + username;
            try {
                const response2 =
                  await fetch(
                    serviceURL2, { 
                        method: 'GET'
                    });
                const data2 = await response2.json();
                if (!data2) {
                    showError('Empty account.')
                } else {
                    console.log(data2);
                    var equipBodysrc = data2['equipBody'];
                    var equipHandsrc = data2['equipHand'];
                    var equipHeadsrc = data2['equipHead'];
                    var equipPetsrc = data2['equipPet'];
                    
                    if ( equipBodysrc != null){
                        $('#me').append("<img class='on_avatar' src='src/img/avatar/"+equipBodysrc+"'>"); 
                    }
                    if (equipHandsrc != null){
                        $('#me').append("<img class='on_avatar' src='src/img/avatar/"+equipHandsrc+"'>"); 
                    }
                    if (equipHeadsrc != null){
                        $('#me').append("<img class='on_avatar' src='src/img/avatar/"+equipHeadsrc+"'>"); 
                    }
                    if (equipPetsrc != null){
                        $('#me').append("<img class='on_avatar' src='src/img/avatar/"+equipPetsrc+"'>"); 
                    }
                    var stonks = data2['stonks'];
                    $('.account_info').html(
                        "Hi, <b class='name'>"+ username
                        +"</b>:) You are <b class='balance'>"+ stonks
                        +"</b> stonks rich!"
                    );
                }
            } catch (error) {
                showError('There is a problem retrieving books data, please try again later.<br />'+error);
            } // error

            function showError(message) {
                $('#errorMsg')
                    .append("<label>"+message+"</label>");
            }
        });
    </script>
</body>

</html>