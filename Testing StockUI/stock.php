<!DOCTYPE HTML>
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
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <!-- Bootstrap libraries -->
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stock.css">

    <!-- Latest compiled and minified JavaScript -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- /<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        var data;
        var userName = sessionStorage.getItem('username');
        $(function() {
            displayStocks()
        });
        async function displayStocks() {
            var stockURL = "http://localhost:5010/stock";
            try {
                const response =
                    await fetch(
                        stockURL, {
                            method: 'GET'
                        }
                    );
                if (!response.ok) {
                    //print some error
                    // $("#chartContainer").text("Error in retrieving stock data")
                    alert("error");
                } else {
                    const data = await response.json();
                    console.log(data)
                    //success             
                    // Begin accessing JSON data here
                    var spoofname = []
                    stocknamekey = data["stock"]
                    for (var i in stocknamekey) {
                        spoofname[i] = ([data["stock"][i].spoofname])
                    }
                    console.log(spoofname)
                    var html = ""

                    for (var j in spoofname) {
                        var serviceURL = "http://localhost:5010/stock/api/" + spoofname[j];
                        //     var request2 = new XMLHttpRequest()
                        console.log(serviceURL)
                        const response2 =
                            await fetch(
                                serviceURL, {
                                    method: 'GET'
                                }
                            );
                        const data2 = await response2.json();
                        console.log(data2)

                        html += "<tr>";
                        html += "<td>" + spoofname[j] + "</td>";
                        html += "<td>" + Object.keys(data2)[Object.keys(data2).length - 1] + "</td>";
                        html += "<td>" + data2[Object.keys(data2)[Object.keys(data2).length - 1]] + "</td>";
                        html += "<td><form action=\"/action_page.php\"> <input type=\"text\" id=\"fname\" name=\"fname\"><br><br></form></td>";
                        html += "<td><input class='button_class' type='button' value='Buy'/></td>";
                        html += "</tr>";
                        document.getElementById("buytd").innerHTML = html;
                    }
                };
            } catch (error) {
                //error, print something 
                $("#display").text("Error in calling the service, " + error);
            }
            showPostion();
        };

        async function showPostion() {
            var positionURL = "http://localhost:5011/position/" + userName;
            //selling
            const response3 =
                await fetch(
                    positionURL, {
                        method: 'GET'
                    }
                );
            const data3 = await response3.json();
            var html2 = ""
            for (var k in data3.stock) {
                html2 += "<tr>";
                html2 += "<td>" + data3.stock[k]["stockName"] + "</td>";
                html2 += "<td>" + data3.stock[k]["price"] + "</td>";
                html2 += "<td>" + "testing" + "</td>";
                html2 += "<td>" + data3.stock[k]["amount"] + "</td>";
                html2 += "<td><input type='button' value='Sell' id=\"" + data3.stock[k]["stockName"] + "\"  onClick=\"sell(" +this.id+")\" /></td>";
                html2 += "</tr>";
            }
            document.getElementById("selltd").innerHTML = html2;
        }
        
            function sell(clicked_id) {
                alert(clicked_id)

            }
        // async function showChart() {

        // }
    </script>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</head>

<body>
    <!-- <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div> -->
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="tabs">
                    <li class="nav-item">
                        <a class="active nav-link active" href="#post" data-toggle="tab">Buy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#link" data-toggle="tab">Sell</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="post">
                        Below are the list of stocks that you can buy
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Stock Name</th>
                                    <th scope="col">Timestamp</th>
                                    <th scope="col">Current Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Buy?</th>
                                </tr>
                            </thead>
                            <tbody id="buytd">
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="link">
                        <table class="table">
                            Below are the stock that you own. Sell it?
                            <thead>
                                <tr>
                                    <th scope="col">Stock Name</th>
                                    <th scope="col">Price That You Bought At</th>
                                    <th scope="col">Current Price</th>
                                    <th scope="col">Amount Bought</th>
                                    <th scope="col">Sell?</th>
                                </tr>
                            </thead>
                            <tbody id="selltd">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>