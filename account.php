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

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/main.css">

    <!-- Latest compiled and minified JavaScript -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Bootstrap libraries -->
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/main.js"></script>
    <script>
        var username = sessionStorage.getItem('username');
        var getAccountURL = "http://localhost:8000/api/v1/account/" + username;
        $(async () => {
            try {
                const response =
                    await fetch(
                        getAccountURL, {
                            mode: 'cors',
                            method: 'GET'
                        });
                // console.log(username);
                // console.log(telegramID);                
                const data = await response.json();
                // console.log(data);
                console.log(data)
                if (response.ok) {
                    // console.log("ok");
                    $('#username').val(data.username);
                    $('#password').val(data.password);
                    $('#email').val(data.email);
                    $('#phoneNumber').val(data.phoneNumber);
                    $('#telegramID').val(data.telegramID);
                    $('#stonks').val(data.stonks);

                    // relocate to home page
                    // window.location.replace(indexURL);
                    // return false;
                } else {
                    console.log(data);
                    showError(data.message);
                }
            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError
                    ("There is a problem loadding your account details, please try again later. " + error);
            } // error
        });
    </script>
</head>

<!-- Page passes the container for the graph to the program -->

<body id="account_body">
    <h1>UPDATE ACCOUNT INFO</h1>
    <div class='account'>
        <img src="src/img/yoshi_house.png" alt="">
        <form id="account_form">
            <div class="block">
                <label>Username</label>
                <input type="text" class="form-control" id="username" placeholder="Username" value="default-value" required readonly>
            </div>
            <div class="block">
                <label>Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value="default-value" required>
            </div>
            <div class="block">
                <label>Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" value="default-value" required>
            </div>
            <div class="block">
                <label>Phone Number</label>
                <input type="tel" class="form-control" id="phoneNumber" placeholder="Phone Number" pattern="[0-9]{8}" title="8-digit number" value="default-value" required>
            </div>
            <div class="block">
                <label>Telegram ID</label>
                <input type="text" class="form-control" id="telegramID" placeholder="Telegram ID" value="default-value" required>
            </div>
            <div class="block">
                <label>Amount Of Stonks You Have</label>
                <input type="text" class="form-control blockUpdate" id="stonks" placeholder="Amount Of Stonks You Have" value="default-value" required readonly>
            </div>
            <div class="button_row">
                <button type="submit" class="btn_update">Update</button>
            </div>
        </form>

        <label id="error" class="text-danger" style="color:#fff;"></label>

    </div>

    <!-- <script async src="https://telegram.org/js/telegram-widget.js?7" data-telegram-login="foshistonks_bot"
            data-size="large" data-onauth="onTelegramAuth(user)" data-request-access="write"></script> -->
    <script>
        //var username = sessionStorage.getItem('username');
        $("#account_form").submit(async (event) => {
            //Prevents screen from refreshing when submitting
            event.preventDefault();
            //Get form data 
            var username = $('#username').val();
            var password = $('#password').val();
            var email = $('#email').val();
            var phoneNumber = $('#phoneNumber').val();
            var telegramID = $('#telegramID').val();

            var serviceURL = "http://localhost:8000/api/v1/account/" + username;
            var homeURL = "http://localhost/foshistonks/home.php";

            // var availability = parseInt($("#availability").val());

            // form the POST url which includes the dynamic username
            // serviceURL += username;
            try {
                const response =
                    await fetch(
                        serviceURL, {
                            mode: 'cors',
                            method: 'PUT',
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                password: password,
                                email: email,
                                phoneNumber: phoneNumber,
                                telegramID: telegramID
                            })

                        });
                console.log(username);
                console.log(telegramID);
                const data = await response.json();
                console.log(data);

                if (response.ok) {
                    // create php session first
                    // var xmlhttp = new XMLHttpRequest();
                    // xmlhttp.open("GET", "session_maker.php?username="+username, true);

                    // xmlhttp.onreadystatechange = function(){
                    //     if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    //         alert("Done! Session created.");
                    //     }
                    // };
                    console.log("ok");

                    // relocate to home page
                    window.location.replace(homeURL);
                    alert("Account details successfully updated!")
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
        function showError(message) {
            // Display an error under the the predefined label with error as the id
            $('#error').text(message);
        }
    </script>
</body>

</html>