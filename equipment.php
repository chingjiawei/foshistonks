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

<body id="equip_body">
<div class='header'>
        <div class='col-3'>
            <img class="home_link" src="src/icons/home.png" alt="">
        </div>
        <h1 class='col-3'>MY EQUIPMENT</h1>
        <div class='col-3'>
            <div class='quick_access'>
                <img src="src/icons/user.png" alt="">
                <a href="logout.php">LOG OUT</a>
            </div>      
        </div>
    </div>
    <div class='display'>
        <div class='col-2 me' id='me'>
            <img class="ori_foshi" src="src/img/me_test.png" alt="">
            <!-- <img class='on_avatar' src="src/img/avatar/body1.png" alt="">
            <img class='on_avatar' src="src/img/avatar/hat1.png" alt="">
            <img class='on_avatar' src="src/img/avatar/hand1.png" alt="">
            <img class='on_avatar' src="src/img/avatar/pet1.png" alt=""> -->
        </div>
        <div class='col-2 collections'>
            <h2>Head</h2>
            <div class='ctg_container ctg_head' id='equipHead'>
                <!-- <div class='ele' id='hat1' data-value='head'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/hat1.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele' id='hat2' data-value='head'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/hat2.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele' id='hat3' data-value='head'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/hat3.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/hat4.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div> -->
            </div>

            <h2>Body</h2>
            
            <div class='ctg_container ctg_body' id='equipBody'>
                <!-- <div class='ele'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/body1.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/body2.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div><div class='ele'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/body3.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div> -->
            </div>

            <h2>Hand</h2>
            <div class='ctg_container ctg_hand'id='equipHand'>
                <!-- <div class='ele'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/hand1.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/hand2.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/hand3.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele'>
                    <h3 class='name'>MARIO HAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/hand4.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div> -->
            </div>


            <h2>Pet</h2>
            <div class='ctg_container ctg_pet' id ='equipPet'>
                <!-- <div class='ele'>
                    <h3 class='name'>CUTE CAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/pet2.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele'>
                    <h3 class='name'>CUTE CAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/pet1.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele'>
                    <h3 class='name'>CUTE CAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/pet3.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div>
                <div class='ele'>
                    <h3 class='name'>CUTE CAT</h3>
                    <div class='img'>
                        <img src='src/img/shop/pet4.png'>
                    </div>
                    <p class='desc'>this is a short description.........</p>
                </div> -->
            </div>
            <p id='errorMsg'></p>
            <br>
            <br>
            <br>
            <br>
            <br>
    </div>

    <script>
        
        function addEvents(){
            $('.ele').css('cursor', 'pointer');
            $('.ele').click(
                function(){
                    var category = $(this).attr('data-cate');
                    var data_src = $(this).attr('data-src');
                    var accessoryID = $(this).attr('id');

                    // $('#me').remove('.'+category);
                    $('#me').find('.'+category).remove();
                    $('#me').append("<img class='"+ category +" on_avatar' src='src/img/avatar/"+data_src+"'>");
                    $('#me>img:last-child').hide();
                    $('#me>img:last-child').fadeIn(500);
                    // console.log('hi');
                    updateAccount(accessoryID);
                }
            )
        }
        
    
        // auto run this to pull all myInventory to display on the right
        $(async() => {           
            // Change serviceURL to your own
            var username = sessionStorage.getItem('username');
            var serviceURL = "http://127.0.0.1:5100/populateInventoryAccessories/" + username;
    
            try {
                const response =
                 await fetch(
                   serviceURL, { method: 'GET' }
                );
                const data = await response.json();
                var items = data[username]; //the arr is in data.books of the JSON data
    
                // array or array.length are false
                if (!data) {
                    showError('Empty accessory.')
                } else {
                    // for loop to setup all table rows with obtained book data
                    for (var i in items){
                        console.log(items[i]);
                        var accessoryDesc = items[i]['accessoryDesc'];
                        var accessoryID = items[i]['accessoryID'];  //1
                        var accessoryName = items[i]['accessoryName']; //Santa Hat
                        var category = items[i]['category']; //equipHead
                        var quantity = items[i]['quantity']; //quantity
                        var src = items[i]['src']; //src

                        var add_div = 
                            "<div class='ele' id='"+accessoryID+"' data-cate='"+ category + "' data-src='"+ src +
                                "'><h3 class='name'>"+accessoryName+
                                "</h3><div class='img'><img src='src/img/shop/"+src+
                                "'></div><p class='desc'>"+accessoryDesc+
                                "</p></div>";
                        console.log(category);
                        $('#'+category).append(add_div);
                    }
                    addEvents();
                }
            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError
              ('There is a problem retrieving books data, please try again later.<br />'+error);
               
            } // error

            // Helper function to display error message
            function showError(message) {
                $('#errorMsg')
                    .append("<label>"+message+"</label>");
            }

        });

        async function updateAccount(accessoryID){
            var username = sessionStorage.getItem('username');
            var serviceURL = "http://127.0.0.1:5102/changeEquip/" + username;
    
            try {
                const response =
                await fetch(
                        serviceURL, {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({
                                username : username, 
                                accessoryID : accessoryID
                            }) 
                        });
                const data = await response.json();
                // array or array.length are false
                if (!data) {
                    showError('Not updated.')
                } else {
                    // for loop to setup all table rows with obtained book data
                    console.log('updated')
                }
            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError
            ('There is a problem retrieving books data, please try again later.<br />'+error);
            
            } // error
        }
    </script>
</body>
</html>
    