<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Aurora Florals</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <hr id="topline" />

    <div id="navdiv">
        <nav>
            <a href="index.html">Home </a>
            <a href="view_product.php">View Florals </a>
            <a id="addFloralNav" href="add_products.php">Add Florals</a>
            <a href="" id="placeordernav">Place Order</a>
            <a href="" id="viewordernav">View Order</a>
            <a id="registerHref" href="register_customer.html">Register</a>
            <a id="loginhref" href="login.html">Login</a>
            <a id="logout" href="" onclick="return logout();">Logout</a>
        </nav>
    </div>

    <div id="logoDiv">
        <a id="logoLinkSub" href="index.html"><img id="logoImgSub" src="imgs/logo2.png" alt="Logo"></a>
        <hr id="bottomline" />
    </div>

    <div class="container" id="details-data">


        <fieldset>
            <legend> My Orders </legend>

            <table class="table">
                <!-- <tr>
              <th>Order Id</th>
              <th>Order Date</th>
              <th>Order Total</th>
            </tr> -->
                <tr>
                    <?php include 'get_my_orders.php';?>
                </tr>
            </table>

            <div>
                <input type="button" class="btnSubmt" id="backorder" value="Back">
            </div>
        </fieldset>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="script.js"></script>
</body>

<footer>
    <p>Copyright @ Aurora Florals</p>
    <p>299, Doon Valley Drive, Kitchener, ON, Canada</p>
</footer>

</html>