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
        <div class='ele'>
            <h3 class='name'>MARIO HAT</h3>
            <div class='img'>
                <img src='src/img/shop/hat1.png'>
            </div>
            <p class='desc'>this is a short description.........</p>
            <p class='price'>$3.33</p>
            <button class='buy_btn' data-id='1' data-price='...'>BUY</button>
        </div>
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
    $('.buy_btn').click(
        function(){
            var accessoryID = $(this).attr('data-id');
            var price = $(this).attr('data-price');
            getStonks(accessoryID, price); //will call buy()
        }
    );
    
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
            // var book = data.books; //the arr is in data.books of the JSON data
            if (response.ok) {
                $('#plusone').fadeIn(200);
                $('#plusone').delay(1200).fadeOut(200);
            }else{
                showError('Books not found.')
            }
            
        } catch (error) {
            // Errors when calling the service; such as network error, 
            // service offline, etc
            showError
            ('There is a problem retrieving books data, please try again later.<br />'+error);
            
        }
    } 

    ///////////////////////display accessories//////////////////
    $(function(){
        $("#plusone").hide();
        // anonymous async function 
        // - using await requires the function that calls it to be async
        $(async() => {           
            // Change serviceURL to your own
            var serviceURL = "http://127.0.0.1:5100/populateShopAccessories/1";
            try {
                const response =
                 await fetch(
                   serviceURL, { method: 'GET' }
                );
                const shop = await response.json();
                // var shop = data["1"]; //only have 1 shop for now
    
                // array or array.length are falsy
                if (!shop || !shop.length) {
                    showError('Shop list empty or undefined.')
                } else {
                    // for loop to setup all table rows with obtained book data
                    var headBlocks = "";
                    var bodyBlocks = "";
                    var handBlocks = "";
                    var petBlocks = "";
                    for (const accessory of shop) {
                        if (accessory.inStock > 0){
                            
                            eachBlock =
                                "<div class='ele'><h3 class='name'>" + accessory.accessoryName + "</h3>" 
                                    +"<div class='img'><img src='src/img/shop/" + accessory.src + "'></div>" +
                                    "<p class='desc'>" + accessory.accessoryDesc + "</p>" +
                                    "<p class='price'> $" + accessory.price + "</p>" + 
                                    "<button class='buy_btn' value='" + accessory.accessoryID + "' onclick='buy(this.value)'>BUY</button></div>";
                            if (accessory.category == 'equipHead'){
                                headBlocks += "<div class='ele'>" + eachBlock + "</div";
                            }
                            if (accessory.category == 'equipBody'){
                                bodyBlocks += "<div class='ele'>" + eachBlock + "</div";
                            } 
                            if (accessory.category == 'equipHand'){
                                handBlocks += "<div class='ele'>" + eachBlock + "</div";
                            } 
                            if (accessory.category == 'equipPet'){
                                petBlocks += "<div class='ele'>" + eachBlock + "</div";
                            }
                                
                        }
                    }
                    console.log(shop)

                    // add all the rows to the table
                    $('.ctg_head').append(headBlocks);
                    $('.ctg_body').append(bodyBlocks);
                    $('.ctg_hand').append(bodyBlocks);
                    $('.ctg_pet').append(petBlocks);
                }
            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError
              ('There is a problem retrieving shop data, please try again later.<br />'+error);
               
            } // error
        });
    });

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
    });

    // Helper function to display error message
    function showError(message) {
            $('#error_display')
                .append("<label>"+message+"</label>");
    }
    
</script>    
</body>

</html>