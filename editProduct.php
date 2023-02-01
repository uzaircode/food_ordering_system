<?php
// phpinfo(); // Works correctly
ini_set('display_errors', 1);
include('server.php');
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $rec = mysqli_query($db, "SELECT * FROM product WHERE product_id=$id");
  $record = mysqli_fetch_array($rec);
  $name = $record['product_name'];
  $price = $record['product_price'];
  $description = $record['product_description'];
  $product_image = $record['product_image'];
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"
    />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <aside>
        <div class="top">
          <div class="logo">
            <!-- <img src=".images/logo.png" alt="logo" /> -->
            <h2">AD<span class="danger">MIN</span></h2>
          </div>
          <div class="close" id="close-btn">
            <span class="material-symbols-outlined">close</span>
          </div>
        </div>

        <div class="sidebar">
          <a href="index.html">
            <span class="material-symbols-outlined">dashboard</span>
            <h3>Dashboard</h3>
          </a>
          <a href="customer.html">
            <span class="material-symbols-outlined">person</span>
            <h3>Customer</h3>
          </a>
          <a href="order.html">
            <span class="material-symbols-outlined">receipt_long</span>
            <h3>Orders</h3>
          </a>
          <a href="analytics.html">
            <span class="material-symbols-outlined">insights</span>
            <h3>Analytics</h3>
          </a>
          <a href="feedback.html">
            <span class="material-symbols-outlined">auto_awesome</span>
            <h3>Feedbacks</h3>
            <span class="message-count">26</span>
          </a>
          <a href="product.html" class="active">
            <span class="material-symbols-outlined">inventory</span>
            <h3>Products</h3>
          </a>
          <a href="invoice.html">
            <span class="material-symbols-outlined">receipt</span>
            <h3>Invoice</h3>
          </a>
          <a href="setting.html">
            <span class="material-symbols-outlined">settings</span>
            <h3>Settings</h3>
          </a>
          <a href="addProduct.html">
            <span class="material-symbols-outlined">add</span>
            <h3>Add Product</h3>
          </a>
          <a href="login.html">
            <span class="material-symbols-outlined">logout</span>
            <h3>Logout</h3>
          </a>
        </div>
      </aside>

      <main>
        <h1>Dashboard</h1>

        <div class="date">
            <input type="date">
        </div>

        <div class="recent-table-list">
            <h2>Update Product</h2>
            <div class="accountDetails">
                <div class="acc-detail">
                    <form method="post" action="server.php">
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="user-details">
                        <div class="input-box">
                            <span class="details">Product Name</span>
                            <input type="text" name="product_name" value="<?php echo $name; ?>"/>
                        </div>
                        <div class="input-box">
                            <span class="details">Price</span>
                            <input type="text" name="product_price" value="<?php echo $price; ?>"/>
                        </div>
                        <div class="input-box">
                            <span class="details">Description</span>
                            <input type="type" name="product_description" value="<?php echo $description; ?>"/>
                        </div>
                        <div class="input-box">
                          <label for="upload" id="upload-btn">
                            <span class="details" id="text">Product image</span>
                            <input type="file" name="upload" id="upload"  />
                          </label>
                        </div>
                            <button type="submit" name="update" >
                            UPDATE PRODUCT
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </main>

      <div class="right">
        <div class="top">
            <button id="menu-btn">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="theme-toggler">
                <span class="material-symbols-outlined active">light_mode</span>
                <span class="material-symbols-outlined">dark_mode</span>
            </div>
            <div class="profile">
                <div class="info">
                    <p>Hey, <b>Uzair</b></p>
                    <small class="text-muted">Admin</small>
                </div>
                <div class="profile-photo">
                    <img src="images/uzair.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="recent-updates">
            <h2>Recent Updates</h2>
            <div class="updates">
                <div class="update">
                    <div class="profile-photo">
                        <img src="images/anise.jpg" alt="">
                    </div>
                    <div class="message">
                        <p><b>Anise</b> received his order of Night lion tech GPS drone.</p>
                        <small class="text-muted">2 Minutes Ago</small>
                        <p>hello</p>
                    </div>
                </div>
                <div class="update">
                    <div class="profile-photo">
                        <img src="images/haziq.jpeg" alt="">
                    </div>
                    <div class="message">
                        <p><b>Haziq Fikri</b> received his order of Night lion tech GPS drone.</p>
                        <small class="text-muted">2 Minutes Ago</small>
                        <p>hello</p>
                    </div>
                </div>
                <div class="update">
                    <div class="profile-photo">
                        <img src="images/nik-fikri.jpg" alt="">
                    </div>
                    <div class="message">
                        <p><b>Nik Fikri</b> received his order of Night lion tech GPS drone.</p>
                        <small class="text-muted">2 Minutes Ago</small>
                        <p>hello</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="sales-analytics">
            <h2>Sales Analytics</h2>
            <div class="item online">
                <div class="icon">
                    <span class="material-symbols-outlined">shopping_cart</span>
                </div>
                <div class="right">
                    <div class="info">
                        <h3>ONLINE ORDERS</h3>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                    <h5 class="success">+39%</h5>
                    <h3>3849</h3>
                </div>
            </div>
            <div class="item online">
                <div class="icon">
                    <span class="material-symbols-outlined">local_mall</span>
                </div>
                <div class="right">
                    <div class="info">
                        <h3>ONLINE ORDERS</h3>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                    <h5 class="danger">-17%</h5>
                    <h3>1100</h3>
                </div>
            </div>

      </div>
    </div>
    <script src="orders.js" async defer></script>
    <script src="index.js" async defer></script>

  </body>
</html>