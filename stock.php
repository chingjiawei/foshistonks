<!DOCTYPE HTML>
<html>

<head>
    <title>FoshiStonk</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../src/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../src/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../src/icons/favicon-16x16.png">
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
            // var allStocksData = displayStocks();
            displayStocks();
        });

        async function displayStocks() {
            var stockURL = "http://localhost:8000/api/v1/stock";
            try {
                const response =
                    await fetch(
                        stockURL, {
                            method: 'GET'
                        }
                    );
                const data = await response.json();
                if (!response.ok) {
                    //print some error
                    // $("#chartContainer").text("Error in retrieving stock data")
                    alert("error");
                } else {
                    // console.log(data);

                    //success             
                    // Begin accessing JSON data here
                    var spoofname = [];
                    // var dict = [];
                    var stockArr = data["stock"];

                    for (var i in stockArr) {
                        spoofname[i] = ([data["stock"][i].spoofname]);
                    }

                    var html = "";

                    var allData = new Object();
                    // var allData = [];
                    for (var j in spoofname) {
                        var serviceURL = "http://localhost:8000/api/v1/stock/api/" + spoofname[j];
                        //     var request2 = new XMLHttpRequest()
                        // console.log(serviceURL)
                        const response2 =
                            await fetch(
                                serviceURL, {
                                    method: 'GET'
                                }
                            );
                        const data2 = await response2.json();
                        // allData[spoofname[j]] = data2;
                        // allData.push(data2);
                        allData[spoofname[j]] = data2;
                        console.log(data2);

                        // var thisStockName = dict[spoofname[j]];
                        var thisStockPrice = data2[Object.keys(data2)[Object.keys(data2).length - 1]];
                        html += "<tr data-spoof='" + spoofname[j] + "' data-price='" + thisStockPrice + "'>";
                        html += "<td>" + spoofname[j] + "</td>";
                        html += "<td>" + Object.keys(data2)[Object.keys(data2).length - 1] + "</td>";
                        html += "<td>" + data2[Object.keys(data2)[Object.keys(data2).length - 1]] + "</td>";
                        html += "<td><input type=\"text\" name=\"buy" + spoofname[j] + "\" list=\"amount\"><datalist id=\"amount\"><option value=\"5\"><option value=\"10\"></datalist></td>";
                        html += "<td><input class='buy_btn' type='button' value='Buy' data-spoof='" + spoofname[j] + "' data-price='" + thisStockPrice + "' onclick= \"buyStock(\'" + spoofname[j] + "\', \'" + thisStockPrice + "\')\" /></td>";
                        html += "</tr>";
                        document.getElementById("buytd").innerHTML = html;
                    }
                    // console.log(allData);
                    showChart(allData);
                    showPostion();
                };
            } catch (error) {
                //error, print something 
                $("#display").text("Error in calling the service, " + error);
            }

        };

        async function showPostion() {
            var positionURL = "http://localhost:8000/api/v1/position/" + userName;
            //selling
            const response3 =
                await fetch(
                    positionURL, {
                        method: 'GET'
                    }
                );
            const data3 = await response3.json();
            var html2 = "";
            for (var k in data3.stock) {
                var currentPrice = $('[data-spoof="' + data3.stock[k]["stockName"] + '"]').attr('data-price');
                if (data3.stock[k].purchasetype == "buy") {
                    // console.log(data3.stock[k]["stockName"]);
                    html2 += "<tr>";
                    html2 += "<td>" + data3.stock[k]["stockName"] + "</td>";
                    html2 += "<td>" + data3.stock[k]["price"] + "</td>";
                    html2 += "<td>" + currentPrice + "</td>";
                    html2 += "<td data-sellId='" + data3.stock[k]["stockName"] + "'>" + data3.stock[k]["amount"] + "</td>";
                    // html2 += "<td><input class='sell_btn' type='button' value='Sell' data-spoof='" + data3.stock[k]["stockName"] + "' data-price='" + currentPrice + "' onclick= \"sellStock(\'" + data3.stock[k]["stockName"] + "\',\'" + data3.stock[k]["price"] + "\',\'" + data3.stock[k]["amount"] + "\')\" /></td>";
                    html2 += "<td><input class='sell_btn' type='button' value='Sell' data-spoof='' data-price='' onclick= \"sellStock(\'" + data3.stock[k]["stockName"] + "\',\'" + currentPrice + "\',\'" + data3.stock[k]["amount"] + "\')\" /></td>";
                    html2 += "</tr>";
                }
            }
            document.getElementById("selltd").innerHTML = html2;
        }



        async function buyStock(spoofname, price) {
            var amount = document.getElementsByName('buy' + spoofname)[0];
            var amt = amount.value
            var notiURL = "http://localhost:8000/api/v1/createposition/" + userName;
            //selling
            const response6 =
                await fetch(
                    notiURL, {
                        mode: 'cors',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            username: userName,
                            spoofname: spoofname,
                            price: price,
                            purchasetype: "buy",
                            amount: amt
                        })
                    }
                );
            const data6 = await response6.json();
            alert(data6["message"])
            // alert("Creation of postion is successful!");
            
            location.reload();
        };

        async function sellStock(stockName, price, amount) {
            var notiURL = "http://localhost:8000/api/v1/createposition/" + userName;
            //selling
            const response7 =
                await fetch(
                    notiURL, {
                        mode: 'cors',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            username: userName,
                            spoofname: stockName,
                            price: price,
                            purchasetype: "sell",
                            amount: amount
                        })
                    }
                );
            const data7 = await response7.json();
            alert(data7["message"])
            // alert("Creation of postion is successful!");
            location.reload();
        }

        async function goBack(){
            var indexURL = "http://localhost/foshistonks/home.php";
            window.location.replace(indexURL);
        }

        async function showChart(allData) {

            var options = {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Stock Prices"
                },
                axisX: {
                    valueFormatString: "DDDD MMM YYYY HH:mm:ss zzz"
                },
                axisY: {
                    title: "Stock Price",
                    minimum: 5,
                    maximum: 80
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "bottom",
                    horizontalAlign: "left",
                    dockInsidePlotArea: true,
                    itemclick: toogleDataSeries
                },
                data: [
                    //     {
                    //     type: "line",
                    //     showInLegend: true,
                    //     name: "stock name", 
                    //     lineDashType: "dash",
                    //     yValueFormatString: "#,##",
                    //     dataPoints:
                    //     //aps
                    //     [{ x: new Date("2015-03-25 12:05:00"), y: 57 },
                    //     { x: new Date("2015-03-25 12:10:00"), y: 57 },
                    //     { x: new Date("2015-03-25 12:15:00"), y: 57 }]
                    // }
                ]
            };

            for (var stockName in allData) {
                var val_list = allData[stockName];
                // console.log(val_list);
                var dps = [];
                for (var val in val_list) {
                    // console.log(val);
                    dps.push({
                        x: new Date(val),
                        y: parseFloat(val_list[val])
                    });
                }
                var temp = {
                    type: "line",
                    showInLegend: true,
                    name: stockName,
                    lineDashType: "dash",
                    yValueFormatString: "#,##",
                    dataPoints: dps
                }
                options.data.push(temp);
            }
            console.log(options.data);

            $("#chartContainer").CanvasJSChart(options);

            function toogleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.chart.render();
            }

        }
    </script>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</head>

<body>
    <button onclick="goBack()">Back</button>
    <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
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
                        Below are the list of stocks that you can buy.
                        <!-- You have $<?php $price = 100;
                                        echo $price; ?> left! -->
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