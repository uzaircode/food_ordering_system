<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// initialize variables
$name = "";
$address = "";
$id = 0;
$edit_state = false;

$username = "";
$email = "";
$password = "";
$errors = array();

$customer_username = "";
$customer_name = "";
$customer_email = "";
$customer_id = "";
$customer_phone = "";
$customer_password = "";

$admin_name = "";
$admin_password = "";
$admin_email = "";
$admin_phone = "";
$phone = "";

$cart_id = "";


$productId = "";
$customerId = "";

$customer_id = "";
$feedback_order_description = "";
$feedback_pickup_description = "";
$feedback_rating = "";

$card_name = "";
$card_number = "";
$card_expired_month = "";
$card_expired_year = "";
$card_cvv = "";

$searchTerm = "";

$total = "0";

$cart_item_id = "";

$staff_name = "";
$staff_email = "";
$staff_id = "";
$staff_phone = "";
$staff_password = "";

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'admin_database');

// add product records
if(isset($_POST['save'])) {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $description = mysqli_real_escape_string($db, $_POST['product_description']);
    $product_image = $_POST['upload'];

    $query = "INSERT INTO product (product_name, product_price, product_description, product_image) VALUES ('$name','$price','$description','$product_image')";
    mysqli_query($db, $query);
    header('location: product.php');
}


// save customer feedbacks
if(isset($_POST['customerFeedbackSave'])) {
  $customer_id = $_POST['customer_id'];
  $feedback_order_description = $_POST['feedback_order_description'];
  $feedback_pickup_experience = $_POST['feedback_pickup_experience'];
  $feedback_rating = $_POST['feedback_rating'];

  $query = "INSERT INTO feedback (customer_id, feedback_order_description, feedback_pickup_experience, feedback_rating) VALUES ('$customer_id', '$feedback_order_description','$feedback_pickup_experience','$feedback_rating')";
  mysqli_query($db, $query);
  header('location: feedback.php');
}

// save customer credit cards
if(isset($_POST['customerCardSave'])) {
  $customer_id = $_POST['customer_id'];
  $card_name = $_POST['card_name'];
  $card_number = $_POST['card_number'];
  $card_expired_month = $_POST['card_expired_month'];
  $card_expired_year = $_POST['card_expired_year'];
  $card_cvv = $_POST['card_cvv'];

  $query = "INSERT INTO payment_method (customer_id, card_name, card_number, card_expired_month, card_expired_year, card_cvv) VALUES ('$customer_id', '$card_name', '$card_number', '$card_expired_month', '$card_expired_year', '$card_cvv')";
  mysqli_query($db, $query);
  header('location: feedback.php');
}

// update product records
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($db, $_POST['product_name']);
    $price = mysqli_real_escape_string($db, $_POST['product_price']);
    $description = mysqli_real_escape_string($db, $_POST['product_description']);
    $product_image = $_POST['upload'];
    $id = mysqli_real_escape_string($db, $_POST['id']);

    $query = "UPDATE product SET product_name='$name', product_price='$price', product_description='$description', product_image='$product_image' WHERE product_id=$id";
    mysqli_query($db, $query);
    header('location: product.php');
}

// delete product records
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE FROM product WHERE product_id=$id");
    header('location: product.php');
}

// retrieve product records
$results = mysqli_query($db, "SELECT * FROM product");

// retrieve product records
$customer_results = mysqli_query($db, "SELECT * FROM customer");

// retrieve customer receipts
$receipt_results = mysqli_query($db, "SELECT `receipt`.*, `customer`.* FROM `receipt` INNER JOIN `customer` ON `receipt`.`customer_id` = `customer`.`customer_id`");

// retrieve customer feedbacks
$feedback_results = mysqli_query($db, "SELECT * FROM feedback");



// if the admin register button is clicked
if (isset($_POST['register'])) {
  $username = mysqli_real_escape_string($db, $_POST['admin_name']);
  $email = mysqli_real_escape_string($db, $_POST['admin_email']);
  $password = mysqli_real_escape_string($db, $_POST['admin_password']);
  $phone = mysqli_real_escape_string($db, $_POST['admin_phone']);

  // $password = md5($password);
  $sql = "INSERT INTO user (admin_name, admin_email, admin_password, admin_phone) VALUES ('$username', '$email', '$password', '$phone')";
  mysqli_query($db, $sql);

  // Get the `admin_id` of the newly created user
  $admin_id = mysqli_insert_id($db);

  // Start the session
  session_start();
  // Set the `admin_id` session variable
  $_SESSION['admin_id'] = $admin_id;
  $_SESSION['admin_name'] = $username;
  $_SESSION['admin_email'] = $email;
  $_SESSION['admin_phone'] = $phone;

  // Redirect to the desired page
  header('location: index.php');
}

// if the staff register button is clicked
if (isset($_POST['staffRegister'])) {
  $username = mysqli_real_escape_string($db, $_POST['staff_name']);
  $email = mysqli_real_escape_string($db, $_POST['staff_email']);
  $password = mysqli_real_escape_string($db, $_POST['staff_password']);
  $phone = mysqli_real_escape_string($db, $_POST['staff_phone']);

  // $password = md5($password);
  $sql = "INSERT INTO staff (staff_name, staff_email, staff_password, staff_phone) VALUES ('$username', '$email', '$password', '$phone')";
  mysqli_query($db, $sql);

  // Get the `admin_id` of the newly created user
  $admin_id = mysqli_insert_id($db);

  // Start the session
  session_start();
  // Set the `admin_id` session variable
  $_SESSION['staff_id'] = $admin_id;
  $_SESSION['staff_name'] = $username;
  $_SESSION['staff_email'] = $email;
  $_SESSION['staff_phone'] = $phone;

  // Redirect to the desired page
  header('location: staffLogin.php');
}




// if the customer register button is clicked
if (isset($_POST['customerRegister'])) {
  $customer_username = mysqli_real_escape_string($db, $_POST['customer_name']);
  $password = mysqli_real_escape_string($db, $_POST['customer_password']);
  $email = mysqli_real_escape_string($db, $_POST['customer_email']);

  $password = md5($password);
  $sql = "INSERT INTO customer (customer_name, customer_password, customer_email, customer_phone) VALUES ('$customer_username', '$password', '$email', '0189002414')";
  mysqli_query($db, $sql);

  session_start();
  // set session variable with the username
  $_SESSION['customer_name'] = $customer_username;

  // redirect to register page
  header('location: userLogin.php');
}

// if the admin login button is clicked
if (isset($_POST['login'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // Check if the user exists in the admin table
  // $password = md5($password);
  $query = "SELECT * FROM user WHERE admin_email='$email' AND admin_password='$password'";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) == 1) {
    // Fetch the admin's information
    $row = mysqli_fetch_assoc($results);
    // Store the admin's information in a session
    $_SESSION['admin_name'] = $row['admin_name'];
    $_SESSION['admin_email'] = $row['admin_email'];
    $_SESSION['admin_id'] = $row['admin_id'];
    $_SESSION['staff_password'] = $row['staff_password'];
    $_SESSION['staff_phone'] = $row['staff_phone'];

    header("location: index.php");
  } else {
    // If the login fails, redirect the user to the login page
    header("location: login.php");
  }
}

// if the admin login button is clicked
if (isset($_POST['staffLogin'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // Check if the user exists in the admin table
  // $password = md5($password);
  $query = "SELECT * FROM staff WHERE staff_email='$email' AND staff_password='$password'";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) == 1) {
    // Fetch the admin's information
    $row = mysqli_fetch_assoc($results);
    // Store the admin's information in a session
    $_SESSION['staff_name'] = $row['staff_name'];
    $_SESSION['staff_email'] = $row['staff_email'];
    $_SESSION['staff_id'] = $row['staff_id'];
    $_SESSION['staff_password'] = $row['staff_password'];
    $_SESSION['staff_phone'] = $row['staff_phone'];

    header("location: staffDashboard.php");
  } else {
    // If the login fails, redirect the user to the login page
    header("location: staffLogin.php");
  }
}

// if the customer login button is clicked
if (isset($_POST['customerLogin'])) {
  $customer_email = mysqli_real_escape_string($db, $_POST['customer_email']);
  $password = mysqli_real_escape_string($db, $_POST['customer_password']);

  $password = md5($password);
  // Check if the user exists in the database
  $query = "SELECT * FROM customer WHERE customer_email='$customer_email' AND customer_password='$password'";

  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) == 1) {
    // Fetch the user's information
    $row = mysqli_fetch_assoc($results);
    // Store the user's information in a session
    session_start();
    $_SESSION['customer_name'] = $row['customer_name'];
    $_SESSION['customer_email'] = $row['customer_email'];
    $_SESSION['customer_phone'] = $row['customer_phone'];
    $_SESSION['customer_id'] = (int)$row['customer_id'];
    // $_SESSION['payment_method'] = $row['payment_method'];

    // Check if the shopping session id already exists for the customer
    $customer_id = $_SESSION['customer_id'];
    $query = "SELECT shopping_session_id FROM shopping_session WHERE customer_id='$customer_id'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) > 0) {
      // If the shopping session id exists, fetch the shopping session id
      $row = mysqli_fetch_assoc($results);
      $_SESSION['session_id'] = (int)$row['shopping_session_id'];
      $_SESSION['total'] = $total;
    } else {
      // If the shopping session id does not exist, create a new shopping session id
      $query = "INSERT INTO shopping_session (customer_id, total) VALUES ('$customer_id', '$total')";
      mysqli_query($db, $query);
      // Store the new shopping session id in a session
      $_SESSION['session_id'] = (int)mysqli_insert_id($db);
    }

    header("location: userHomepage.php");
  } else {
      $error = mysqli_error($db);
      header("location: userLogin.php?error=$error");
      echo $error;
    // If the login fails, redirect the user to the login page
  }
}



// if the logout button is clicked
if(isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header('location: login.php');
}

// retrieve customer records
$customer_records = mysqli_query($db, "SELECT * FROM customer");

// retrieve order records
$order_records = mysqli_query($db, "SELECT `order`.*, `customer`.`customer_name` FROM `order` INNER JOIN `customer` ON `order`.`customer_id` = `customer`.`customer_id`");


// record order when customer order
if(isset($_POST['form_submitted'])) {
  if(isset($_SESSION['customer_id']) && isset($_SESSION['session_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $session_id = $_SESSION['session_id'];

    $check_cart = mysqli_query($db, "SELECT * FROM cart WHERE customer_id = '$customer_id'");
    $cart = mysqli_fetch_assoc($check_cart);
    $cart_id = $cart['cart_id'];

    // insert new order into order table
    $result = mysqli_query($db, "INSERT INTO `order` (customer_id, session_id) VALUES ('$customer_id', '$session_id')");

    $order_id = mysqli_insert_id($db);

    // insert order information into receipt table
    $receipt_result = mysqli_query($db, "INSERT INTO receipt (order_id, customer_id) VALUES ('$order_id', '$customer_id')");

    if ($receipt_result) {
        unset($_SESSION['session_id']);
        $query = "INSERT INTO shopping_session (customer_id, total) VALUES ('$customer_id', '$total')";
        mysqli_query($db, $query);
        header('location: userHomepage.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($db);
    }
  } else {
    header('location: payment.php');
  }
}


// record cart when customer place add to cart
if (isset($_POST['action_id'])) {
  $action_id = $_POST['action_id'];
if ($action_id == "add_to_cart") {
  if(isset($_POST['customer_id']) && isset($_POST['session_id']) && isset($_POST['product_id'])) {
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $session_id = $_POST['session_id'];

    // Check if a cart with the same customer ID already exists
    $check_cart = mysqli_query($db, "SELECT * FROM cart WHERE customer_id = '$customer_id' && session_id = '$session_id'");

    if(mysqli_num_rows($check_cart) > 0) {
      $cart = mysqli_fetch_assoc($check_cart);
      $cart_id = $cart['cart_id'];
    } else {
      // If it doesn't exist, insert a new cart
      mysqli_query($db, "INSERT INTO cart (customer_id, session_id) VALUES ('$customer_id', '$session_id')");
      // Get the id of the newly inserted cart
      $cart_id = mysqli_insert_id($db);
    }

    // Check if a cart item with the same cart ID and product ID already exists
    $check_cart_item = mysqli_query($db, "SELECT * FROM cart_items WHERE cart_id = '$cart_id' AND product_id = '$product_id'");

    if(mysqli_num_rows($check_cart_item) > 0) {
      // If it exists, update the quantity of that item
      mysqli_query($db, "UPDATE cart_items SET quantity = quantity + 1 WHERE cart_id = '$cart_id' AND product_id = '$product_id'");
    } else {
      // If it doesn't exist, insert a new cart item
      mysqli_query($db, "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES ('$cart_id', '$product_id', 1)");
    }
    echo "success";
    exit;
  }
} else if ($action_id == "delete_from_cart") {
    if(isset($_POST['customer_id']) && isset($_POST['session_id']) && isset($_POST['product_id'])) {
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $session_id = $_POST['session_id'];

    $delete_query = "DELETE FROM cart_items WHERE product_id = $product_id";
    $result = mysqli_query($db, $delete_query);
    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }
    echo "success";
    exit;
}
  } else {
    // handle unknown action_id here
  }
}

// update admin profile
if (isset($_POST['adminUpdate'])) {
  $admin_name = mysqli_real_escape_string($db, $_POST['admin_name']);
  $admin_email = mysqli_real_escape_string($db, $_POST['admin_email']);
  $admin_phone = mysqli_real_escape_string($db, $_POST['admin_phone']);
  $admin_password = mysqli_real_escape_string($db, $_POST['admin_password']);
  $admin_id = mysqli_real_escape_string($db, $_POST['admin_id']);

  // Hash the password before storing it in the database
  $admin_password = md5($admin_password);

  $query = "UPDATE user SET admin_name='$admin_name', admin_email='$admin_email', admin_phone='$admin_phone', admin_password='$admin_password' WHERE admin_id=$admin_id";
  mysqli_query($db, $query);
  header('location: index.php');
}

// update staff profile
if (isset($_POST['staffUpdate'])) {
  $staff_name = mysqli_real_escape_string($db, $_POST['staff_name']);
  $staff_email = mysqli_real_escape_string($db, $_POST['staff_email']);
  $staff_phone = mysqli_real_escape_string($db, $_POST['staff_phone']);
  $staff_password = mysqli_real_escape_string($db, $_POST['staff_password']);
  $staff_id = mysqli_real_escape_string($db, $_POST['staff_id']);

  // Hash the password before storing it in the database
  // $admin_password = md5($admin_password);

  $query = "UPDATE staff SET staff_name='$staff_name', staff_email='$staff_email', staff_phone='$staff_phone', staff_password='$admin_password' WHERE staff_id=$staff_id";
  mysqli_query($db, $query);
  header('location: index.php');
}


// update customer profile
if (isset($_POST['customerUpdate'])) {
  $customer_name = mysqli_real_escape_string($db, $_POST['customer_name']);
  $customer_email = mysqli_real_escape_string($db, $_POST['customer_email']);
  $customer_phone = mysqli_real_escape_string($db, $_POST['customer_phone']);
  $customer_password = mysqli_real_escape_string($db, $_POST['customer_password']);
  $customer_id = mysqli_real_escape_string($db, $_POST['customer_id']);

  // Hash the password before storing it in the database
  $customer_password = md5($customer_password);

  $query = "UPDATE customer SET customer_name='$customer_name', customer_email='$customer_email', customer_phone='$customer_phone', customer_password='$customer_password' WHERE customer_id=$customer_id";
  mysqli_query($db, $query);
  header('location: customerProfile.php');
}

// update customer payment method
if (isset($_POST['customerPaymentUpdate'])) {
  $card_id = $_POST['card_id'];
  $card_number = mysqli_real_escape_string($db, $_POST['card_number']);
  $card_expired_month = mysqli_real_escape_string($db, $_POST['card_expired_month']);
  $card_expired_year = mysqli_real_escape_string($db, $_POST['card_expired_year']);
  $card_cvv = mysqli_real_escape_string($db, $_POST['card_cvv']);
  $card_id = mysqli_real_escape_string($db, $_POST['card_id']);

  $query = "UPDATE payment_method SET card_id='$card_id', card_name='$card_name', card_expired_month='$card_expired_month', card_expired_year='$card_expired_year', card_cvv='$card_cvv' WHERE card_id=$card_id";
  mysqli_query($db, $query);
  header('location: customerProfile.php');
}

if (isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'];

    // Connect to the database and retrieve the list of products with matching product name
    // Placeholder code, replace with your own database connection and query logic
    $products = [
        [
            'product_id' => 1,
            'product_name' => 'Product 1',
            'product_price' => '$10.00'
        ],
        [
            'product_id' => 2,
            'product_name' => 'Product 2',
            'product_price' => '$20.00'
        ],
        [
            'product_id' => 3,
            'product_name' => 'Product 3',
            'product_price' => '$30.00'
        ],
    ];

    // Iterate through the list of products and display the matching ones
    foreach ($products as $product) {
        if (strpos(strtolower($product['product_name']), strtolower($product_name)) !== false) {
            echo '<p>' . $product['product_name'] . ' - ' . $product['product_price'] . '</p>';
        }
    }
}

?>