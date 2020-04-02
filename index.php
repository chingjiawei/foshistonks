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

    <!-- Latest compiled and minified JavaScript -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>

</head>

<!-- Page passes the container for the graph to the program -->

<body id="index_body">
    <div class='col-2 login_left'>
        <img src="src/img/logo.png" alt="">
        <p><i>one-stop platform</i></p>
        <p class="login_descript">THE ONLY PLACE TO LEARN ABOUT STONKS, EARN SOME STONKS, INVEST IN STONKS,
HAPPY STONKING!</p>
    </div>
    <div class='col-2 login_right'>
        <img src="src/img/yoshi_house.png" alt="">

        <form id="login_form">
            <input type="text" class="form-control" id="username" placeholder="Username" value="">
            <input type="password" class="form-control" id="password" placeholder="Password" value="">
            <div class="button_row">    
                <button type="submit" class="btn_login">Log In</button>
                <span> | </span> 
                <a class="a_signup" href="signup.html">Sign Up</a>
            </div>
        </form>

        <label id="error" class="text-danger"></label>
        
    </div>

    <!-- C:\wamp64\www\foshistonks\atomic 
        <script async src="https://telegram.org/js/telegram-widget.js?7" data-telegram-login="foshistonks_bot"
            data-size="large" data-onauth="onTelegramAuth(user)" data-request-access="write"></script> -->
	<script>
        function showError(message) {
            // Display an error under the the predefined label with error as the id
            $('#error').text(message);
        }

        $("#login_form").submit(async (event) => {
            //Prevents screen from refreshing when submitting
            event.preventDefault();
            //Get form data 
            var username = $('#username').val();
            var password = $('#password').val();

            var serviceURL = "http://localhost:5013/login/";
            var homeURL = "http://localhost/foshistonks/home.php";

            // form the POST url which includes the dynamic username
            serviceURL += username;
            try {
                const response =
                    await fetch(
                        serviceURL, {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({username : username, password : password}) 
                        });
                const data = await response.json();

                if (response.ok) {
                    sessionStorage.setItem('username', username);

                    // relocate to home page
                    window.location.replace(homeURL);
                    return false;
                } else {
                    console.log(data);
                    showError(data.message);
                }
            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError
                    ("There is a problem logging into this account, please try again later. " + error);

            } // error
        });
        // function onTelegramAuth(user) {
        //         alert('Logged in as ' + user.first_name + ' ' + user.last_name + ' (' + user.id + (user.username ? ', @' + user.username : '') + ')');
        //     }
            
        </script>
    </script>
</body>

</html>