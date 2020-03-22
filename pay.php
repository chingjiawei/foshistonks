<?php
$userid = '1234';
$_SESSION['userid'] = $userid;


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">

    <title>Bookstore</title>

    <link rel="stylesheet" href="">
    <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Bootstrap libraries -->
    <meta name="viewport" 
        content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" 
    crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script 
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>
    
    <script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>
</head>
<body>
    <div id = "main-container" class="container" style ='width: 300px; padding: 10px; border:1px solid black'>
        <form action="add-book.html" id="addBookForm" method="POST">
            <h1>Make a payment</h1>
            <input type="hidden" id="senderid" name="senderid" value=<?=$userid?> >
            <!-- might need a loop here -->
            <h3>Accessories</h3>
            <table border='1'>
                <tr>
                    <td><input type="checkbox" name="acc[]" value="Bike"></td>
                    <td>Bike</td>
                    <td>Price_Bike</td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="acc[]" value="Car"></td>
                    <td>Car</td>
                    <td>Price_Car</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td>Sum_of_selection {JS here}</td>
                </tr>
            </table>
            <input type="submit" id="addBookButton" class="submit btn btn-primary" value="Pay by Paypal" style="margin-top:10px">
        </form>
        <p id='msg' style="display: none; color: red">
            Payment successfully made!
            <a id="addBookBtn" class="btn btn-primary" href="index.html">Check all accessories</a>
        </p>
    </div>

    <script>
        
        $("#addBookForm").submit(async(event) => {
            //Prevents screen from refreshing when submitting
            event.preventDefault();
            var isbnNumber = $('#isbn13').val();
            var serviceURL = "http://localhost:5000/account" + "/" + userid;
            
            var title = $('#title').val();
            var price = $('#price').val();
            var availability = $('#availability').val();
            console.log("clicked");
            try {
                const response =
                 await fetch(
                   serviceURL, 
                   {
                        mode: 'cors',
                        method: 'POST',
                        headers: {"Content-Type": "application/json"},
                        body: JSON.stringify({
                            title: title, 
                            price: price, 
                            availability: availability
                        })
                    }
                );
                const data = await response.json();
                // var book = data.books; //the arr is in data.books of the JSON data
                console.log("hello");
                if (response.ok) {
                    $("#msg").css("display", 'block');
                }else{
                    showError('Books not found.')
                }
                
            } catch (error) {
                // Errors when calling the service; such as network error, 
                // service offline, etc
                showError
              ('There is a problem retrieving books data, please try again later.<br />'+error);
               
            } // error
            function showError(message) {
                // Hide the table and button in the event of error
                $('#booksTable').hide();
                $('#addBookBtn').hide();
        
                // Display an error under the main container
                $('#main-container')
                    .append("<label>"+message+"</label>");
            }
        });

    </script>
</body>

</html>