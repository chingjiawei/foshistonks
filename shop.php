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

<body id="shop_body">
    <div class='header'>
        <div class='col-3'>
            <img class="home_link" src="src/icons/home.png" alt="">
        </div>
        <h1 class='col-3'>FOSHI SHOP</h1>
        <div class='col-3'>
            <div class='quick_access'>
                <img class='cart equip_link' src="src/icons/cart.png" alt="">
                <img id='plusone' src="src/icons/plusone.png" alt="">
                <span class='pipe'> | </span>
                <img src="src/icons/user.png" alt="">
                <a href="logout.php">LOG OUT</a>
            </div>      
        </div>
        <p id='errorMsg'></p>
    </div>
    <div id="error_display cleafix"></div>

    <h2>Head</h2>
    <div class='ctg_container ctg_head'>
        <!-- <div class='ele'>
            <h3 class='name'>MARIO HAT</h3>
            <div class='img'>
                <img src='src/img/shop/hat1.png'>
            </div>
            <p class='desc'>this is a short description.........</p>
            <p class='price'>$3.33</p>
            <button class='buy_btn' data-id='1' data-price='...'>BUY</button>
        </div> -->
    </div>

    <h2>Body</h2>
    <div class='ctg_container ctg_body'>
    </div>

    <h2>Hand</h2>
    <div class='ctg_container ctg_hand'>
    </div>

    <h2>Pet</h2>
    <div class='ctg_container ctg_pet'>
    </div>
    

<!-- Page passes the container for the graph to the program -->
<script>
    $('.home_link').click(function() {
        window.location.href = '/foshistonks/home.php';
        return false;
    });
    $('.equip_link').click(function() {
        window.location.href = '/foshistonks/equipment.php';
        return false;
    });
    function addBuyListener(){
        $('.buy_btn').click(
            function(){
                var accessoryID = $(this).attr('data-id');
                var price = $(this).attr('data-price');
                getStonks(accessoryID, price); //will call buy()
            }
        );  
    }
    
    $("#plusone").hide();
    

    ///////////////////////display accessories//////////////////
    $(async() => {           
        // Change serviceURL to your own
        var serviceURL = "http://127.0.0.1:5100/populateShopAccessories/1";
        try {
            const response =
                await fetch(
                serviceURL, { method: 'GET' }
            );
            const shop = await response.json();
            var thisShop = shop["1"]; //only have 1 shop for now
            if (!thisShop) {
                showError('Shop list empty or undefined.')
                // console.log(error);
            } else {
                // for loop to setup all table rows with obtained book data
                // console.log(thisShop);
                var headBlocks = "";
                var bodyBlocks = "";
                var handBlocks = "";
                var petBlocks = "";
                for (var i in thisShop) {
                    if (thisShop[i]['inStock'] > 0){
                        eachBlock =
                            "<div class='ele'><h3 class='name'>" + thisShop[i]["accessoryName"] + "</h3>" 
                                +"<div class='img'><img src='src/img/shop/" + thisShop[i]["src"] + "'></div>" +
                                "<p class='desc'>" + thisShop[i]["accessoryDesc"] + "</p>" +
                                "<p class='price'> $" + thisShop[i]["price"] + "</p>" + 
                                "<button class='buy_btn' data-id='"+thisShop[i]["accessoryID"]+"' data-price='"+thisShop[i]["price"]+"'>BUY</button></div>";

                        if (thisShop[i]['category'] == 'equipHead'){
                            headBlocks += eachBlock;
                        }
                        if (thisShop[i]['category'] == 'equipBody'){
                            bodyBlocks += eachBlock;
                        } 
                        if (thisShop[i]['category'] == 'equipHand'){
                            handBlocks += eachBlock;
                        } 
                        if (thisShop[i]['category'] == 'equipPet'){
                            petBlocks += eachBlock;
                        }
                            
                    }
                }
                // add all the rows to the table
                $('.ctg_head').append(headBlocks);
                $('.ctg_body').append(bodyBlocks);
                $('.ctg_hand').append(handBlocks);
                $('.ctg_pet').append(petBlocks);

                addBuyListener();
            }
        } catch (error) {
            showError('There is a problem retrieving shop data, please try again later.<br />'+error);
        } // error
    });

    ////////////////purchase microservice called here////////////
    async function buy(accessoryID, currentStonks, price){
        //Prevents screen from refreshing when submitting
        var username = sessionStorage.getItem('username');
        // console.log(id)
        var serviceURL = "http://localhost:5200/purchaseAccessories/" + accessoryID;
        
        try {
            const response =
                await fetch(
                serviceURL, 
                {
                    mode: 'cors',
                    method: 'POST',
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify({
                                username : username, 
                                accessoryID : accessoryID,
                                shopID: "1", 
                                currentStonks: currentStonks, 
                                price: price
                            }) 
                }
            );
            const data = await response.json();
            if (response.ok) {
                $('#plusone').fadeIn(200);
                $('#plusone').delay(1200).fadeOut(200);
            }else{
                showError('Books not found.')
            }
        } catch (error) {
            showError
            ('There is a problem retrieving books data, please try again later.<br />'+error);
        }
    }

    async function getStonks(accessoryID, price) { 
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
                showError('Empty account.');
            } else {
                var currentStonks = data2['stonks'];
                buy(accessoryID, currentStonks, price);

            }
        } catch (error) {
            showError('There is a problem retrieving books data, please try again later.<br />'+error);
        } // error
    }

    // Helper function to display error message
    function showError(message) {
            $('#error_display')
                .append("<label>"+message+"</label>");
    }
    
</script>    
</body>

</html>