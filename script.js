$(document).ready(function () {

  if (sessionStorage.getItem("customer_id") === null) {
    
    $("#logout").hide();
    $("#viewordernav").hide();
    $("#placeordernav").hide();
    $("#addFloralNav").hide();
    $("#addanotherProduct").hide();
    
  }
  else{

    if (sessionStorage.getItem("customer_id") !== null  && sessionStorage.getItem("customer_id") != 8){
      $("#addFloralNav").hide();
      $("#addanotherProduct").hide();
    }
    $("#loginhref").hide();
    $("#registerHref").hide();
    
  }
  
});

$("#startOrder").on('click', function () {

  var customer_name = $("#customer_name").val().trim();
  var customer_address = $("#customer_address").val().trim();
  var customer_phone = $("#customer_phone").val().trim();
  var customer_email = $("#customer_email").val().trim();

  $.ajax({
    type: "GET",
    url: 'get_customer.php',
    data:{action:'call_this', customer_nameVal: customer_name, customer_addressVal : customer_address,  customer_phoneVal: customer_phone, customer_emailVal : customer_email},
    success:function(data) {
      sessionStorage.setItem("customer_id", data);
      location.href = 'order.php';
    }

  });

})



$("#backorder").on('click', function () {

  location.href = 'order.php';

})


  // $("#loginhref").click(function(){

  //   location.href = 'login.html';
  //   $(this).hide();
  //   return false;
    
  // });


$("#addanotherProduct").on('click', function () {

  location.href = 'add_products.php';

})

$("#viewwProducts").on('click', function () {

  location.href = 'view_product.php';

})

$("#register_customer").on('click', function (evt) {

  const phonePattern = /^\d{3}-\d{3}-\d{4}$/;
  const emailPattern = /\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/;

  var isValid = true;
  var customer_name = $("#customer_name").val().trim();
  var customer_address = $("#customer_address").val().trim();
  var customer_phone = $("#customer_phone").val().trim();
  var customer_email = $("#customer_email").val().trim();

  // if(customer_phone == "" || customer_name == "" || customer_address == ""|| customer_email==""){
  //   alert("Please fill all the fields");
  //   isValid = false;
  // }

  // if(!phonePattern.test(customer_phone)){
  //   alert("Customer phone number should be in the format xxx-xxx-xxxx");
  //   isValid = false;
  // }

  // if(!emailPattern.test(customer_email)){
  //   alert("Email address is not valid");
  //   isValid = false;
  // }

  if(isValid){
    $.ajax({
      type: "GET",
      url: 'get_customer.php',
      data:{action:'call_this', customer_nameVal: customer_name, customer_addressVal : customer_address,  customer_phoneVal: customer_phone, customer_emailVal : customer_email},
      success:function(data) {
        if(data == "Customer already exists. Please login."){
          alert(data);
        }
        else if(isNaN(data)){
          alert(data);
        }
        else{
          sessionStorage.setItem("customer_id", data);
          alert("Customer created successfully");
          location.href = 'order.php';
        }
  
      }
  
    });
  }

 

})


$("#login_customer").on('click', function () {

  var customer_emailVal = $("#customer_email").val().trim();

  $.ajax({
    type: "GET",
    url: 'login_customer.php',
    data:{action:'call_this', customer_emailVal},
    success:function(data) {
      
      if(String(data).trim() == "false"){
        alert("No customer found with this email. Please register!");
      }
      else if(isNaN(data)){
        alert(data);
      }
      else{
        sessionStorage.setItem("customer_id", data);
        alert("Customer logged in successfully!");
        location.href = 'index.html';
      }
      
    }

  });

})

function logout () {
  sessionStorage.clear();
  alert("Logged out");
  $(this).attr("href", 'index.html'); 
}

$("#logout").on('click', function () {

    $(this).attr("href", 'index.html'); 

})

$("#placeordernav").on('click', function () {

  if (sessionStorage.getItem("customer_id") === null) {
    alert("Please register/login to place an order");
    evt.preventDefault();
  }
  else{
    $(this).attr("href", 'order.php'); 
  }

})

$("#viewordernav").on('click', function () {

    var customer_id = sessionStorage.getItem("customer_id");
    $(this).attr("href", 'my_orders.php?id=' + customer_id); 

})


$("#addToCart").on('click', function () {
  var floral = $("#bouquet").val().trim();
  var quantity = $("#quantity").val().trim();
  var customer_id = sessionStorage.getItem("customer_id").trim();

  console.log(floral)
  
  $.ajax({
    type: "POST",
    url: 'add_to_cart.php',
    data:{action:'call_this', floral, quantity, customer_id},
    success:function(html) {

      if(String(html).trim() == "true"){
        
        alert("Added to cart successfully");
        $("#bouquet").val("Select Floral Product");
        $("#quantity").val("");

      }
      else if(String(html).trim() == "false"){
        alert("Error! Product may be already in the cart.");

      }
      else{
        alert(String(html).trim())
      }
    },
    error: function (request, status, error) {
      alert("Hiii");
  }

  });

  
})

$(".updatebtn").on('click', function () {

  var customer_id = sessionStorage.getItem("customer_id");
  var bouquet_id = $(this).attr('alt');
  var quantity = $(this).attr('altt');
  var name = $(this).attr('name');

  location.href = 'update_cart.php?id=' + customer_id+'&bouquet_id='+bouquet_id+'&quantity='+quantity+'&name='+name;
  console.log("pritn " + customer_id + " " + order_id);

})


$("#updateCart").on('click', function () {

  var customer_id = sessionStorage.getItem("customer_id").trim();
  var bouquet_id = $("#bouquet").attr('alt').trim();
  var quantity = $("#quantity").val().trim();
  
  $.ajax({
    type: "POST",
    url: 'update_my_cart.php',
    data:{action:'call_this',  customer_id, bouquet_id, quantity},
    success:function(html) {

      if(String(html).trim() == "true"){

        alert("Cart updated successfully");
        location.href = 'my_cart.php?id=' + customer_id;

      }
      else{
        alert(String(html).trim());
      }
      
    }

  });

})


$(".deletebtn").on('click', function () {

  var customer_id = sessionStorage.getItem("customer_id").trim();
  var bouquet_id = $(this).attr('alt').trim();
  var quantity = $(this).attr('altt').trim();
  var name = $(this).attr('name').trim();

  location.href = 'delete_my_cart.php?id=' + customer_id+'&bouquet_id='+bouquet_id+'&quantity='+quantity+'&name='+name;
  alert("Deleted successfully");
  location.href = 'my_cart.php?id=' + customer_id;

})



$("#add_new_products").on('click', function () {
  var floral = $("#name").val();
  var unitprice = $("#unitprice").val();
  var stock = $("#stock").val();
  
  $.ajax({
    type: "POST",
    url: 'add_products_todb.php',
    data:{action:'call_this', floral, unitprice, stock},
    success:function(html) {
      if(String(html).trim() == "true"){
        alert("Product added successfully");
        $("#name").val("");
        $("#unitprice").val("");
        $("#stock").val("");

      }
      else{
        alert(String(html).trim())
      }
      
    }

  });

  
})


$("#viewCart").on('click', function () {

  var customer_id = sessionStorage.getItem("customer_id").trim();

  $.ajax({
    type: "GET",
    url: 'view_cart.php',
    data:{action:'call_this', customer_id},
    success:function(data) {
      location.href = 'my_cart.php?id=' + customer_id;
    }

  });

})


$("#placeOrder").on('click', function () {

  var customer_id = sessionStorage.getItem("customer_id").trim();
  
  $.ajax({
    type: "POST",
    url: 'post_order.php',
    data:{action:'call_this',  customer_id},
    success:function(html) {
      location.href = 'my_orders.php?id=' + customer_id;
    }

  });

})

$("#viewMyOrders").on('click', function () {

  var customer_id = sessionStorage.getItem("customer_id").trim();

  $.ajax({
    type: "GET",
    // url: 'view_cart.php',
    data:{action:'call_this', customer_id},
    success:function(data) {
      location.href = 'my_orders.php?id=' + customer_id;
    }

  });

})


$(".invoicebtn").on('click', function () {

  var customer_id = sessionStorage.getItem("customer_id").trim();
  var order_id = $(this).attr('alt');

  location.href = 'invoice.php?id=' + customer_id+'&order_id='+order_id;
  console.log("pritn " + customer_id + " " + order_id);

})


