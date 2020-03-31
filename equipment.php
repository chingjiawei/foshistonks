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
            <div class='ctg_container ctg_head'>
                <div class='ele' id='hat1' data-value='head'>
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
                </div>
            </div>

            <h2>Body</h2>
            <div class='ctg_container ctg_body'>
                <div class='ele'>
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
                </div>
            </div>

            <h2>Hand</h2>
            <div class='ctg_container ctg_hand'>
                <div class='ele'>
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
                </div>
            </div>


            <h2>Pet</h2>
            <div class='ctg_container ctg_pet'>
                <div class='ele'>
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
                </div>
            </div>
            <p id='errorMsg'></p>
            <br>
            <br>
            <br>
            <br>
            <br>
    </div>

    <script>
        $('.ele').css('cursor', 'pointer');
        $('.ele').click(
            function(){
                var category = $(this).attr('data-value');
                var id = $(this).attr('id');
                // $('#me').remove('.'+category);
                $('#me').find('.'+category).remove();
                $('#me').append("<img class='"+ category +" on_avatar' src='src/img/avatar/"+id+".png'>");
                $('#me>img:last-child').hide();
                $('#me>img:last-child').fadeIn(500);
            }
            $(async() => {           
                // Change serviceURL to your own
                var id = $(this).attr('id');
                var serviceURL = "http://127.0.0.1:????/updateEquipment/"+id;
                try {
                    const response = await fetch( serviceURL, 
                        {
                            mode: 'cors',
                            method: 'POST',
                            headers: {"Content-Type": "application/json"},
                            body: JSON.stringify({
                                accessoryID: id
                            })
                        });
                    const shop = await response.json();
                    // var shop = data["1"]; //only have 1 shop for now
        
                    // array or array.length are falsy
                    if (response.ok) {
                        //
                    }else{
                        showError('Equip not updated.')
                    }
                } catch (error) {
                    // Errors when calling the service; such as network error, 
                    // service offline, etc
                    showError
                ('There is a problem updating equip data, please try again later.<br />'+error);
                
                } // error
                function showError(message) {
                    
                    $('#errorMsg')
                        .append("<label>"+message+"</label>");
                }
            });
        );
    </script>
</body>

</html>