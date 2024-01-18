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
            <legend>Place an Order</legend>
            <div class="form">
                <form name="order_form">
                    <div class="option">
                        <select name="bouquet" id="bouquet" name="bouquet" class="form-control item">
                            <option selected="selected">Select Floral Product</option>
                            <?php include 'get_floral_producs.php';?>
                        </select>
                    </div>
                    <input type="number" class="form-control item" id="quantity" name="quantity" placeholder="Quantity" min="1" max="100">
                    <input type="button" class="btnSubmt" id="addToCart" value="Add to Cart">
                    <input type="button" class="btnSubmt" id="viewCart" value="View my Cart"><br><br>
                    <input type="button" class="btnSubmt" id="viewMyOrders" value="View Orders">
                </form>
            </div>
        </fieldset>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
    <script language="JavaScript" type="text/javascript" src="/js/jquery-1.2.6.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="script.js"></script>
</body>

<footer>
    <p>Copyright @ Aurora Florals</p>
    <p>299, Doon Valley Drive, Kitchener, ON, Canada</p>
</footer>

</html>