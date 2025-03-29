<?php
session_start();
require 'db.php';

$bid = $_SESSION['id'];

// Handle adding items to cart
if (isset($_GET['flag'])) {
    $pid = mysqli_real_escape_string($conn, $_GET['pid']);
    
    // Check if item already exists in cart
    $check_sql = "SELECT * FROM mycart WHERE bid='$bid' AND pid='$pid'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) == 0) {
        $insert_sql = "INSERT INTO mycart (bid, pid) VALUES ('$bid', '$pid')";
        $result = mysqli_query($conn, $insert_sql);
        if ($result) {
            $_SESSION['message'] = "Item added to cart successfully!";
        } else {
            $_SESSION['message'] = "Error adding item to cart!";
        }
    } else {
        $_SESSION['message'] = "Item already in cart!";
    }
    header("Location: mycart.php");
    exit();
}

// Handle removing items from cart
if (isset($_GET['remove'])) {
    $pid = mysqli_real_escape_string($conn, $_GET['pid']);
    $delete_sql = "DELETE FROM mycart WHERE bid='$bid' AND pid='$pid'";
    $result = mysqli_query($conn, $delete_sql);
    if ($result) {
        $_SESSION['message'] = "Item removed from cart successfully!";
    } else {
        $_SESSION['message'] = "Error removing item from cart!";
    }
    header("Location: mycart.php");
    exit();
}

// Handle quantity updates
if (isset($_POST['update_quantity'])) {
    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $quantity = intval($_POST['quantity']);
    
    // Validate quantity
    if ($quantity > 0 && $quantity <= 10) {
        $update_sql = "UPDATE mycart SET quantity='$quantity' WHERE bid='$bid' AND pid='$pid'";
        $result = mysqli_query($conn, $update_sql);
        if ($result) {
            $_SESSION['message'] = "Quantity updated successfully!";
        } else {
            $_SESSION['message'] = "Error updating quantity!";
        }
    } else {
        $_SESSION['message'] = "Invalid quantity! Must be between 1-10.";
    }
    header("Location: mycart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AgroCulture: My Cart</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="login.css"/>
    <script src="js/jquery.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-layers.min.js"></script>
    <script src="js/init.js"></script>
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
    </noscript>
    <style>
        .quantity-control {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background:rgb(226, 68, 68);
            cursor: pointer;
        }
        .quantity-input {
            width: 50px;
            height: 30px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ddd;
        }
        .cart-summary {
            background:rgba(28, 240, 176, 0.68);
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
        }
    </style>
</head> 
<body>
    <?php require 'menu.php'; ?>

    <!-- Display messages -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <section id="main" class="wrapper style1 align-center">
        <div class="container">
            <h2>My Cart</h2>

            <section id="two" class="wrapper style2 align-center">
                <div class="container">
                    <div class="row">
                    <?php
                    $sql = "SELECT * FROM mycart WHERE bid = '$bid'";
                    $result = mysqli_query($conn, $sql);
                    
                    if(mysqli_num_rows($result) == 0) {
                        echo '<div class="col-md-12"><h3>Your cart is empty</h3></div>';
                    } else {
                        $total = 0;
                        while($row = mysqli_fetch_assoc($result)) {
                            $pid = $row['pid'];
                            $product_sql = "SELECT * FROM fproduct WHERE pid = '$pid'";
                            $product_result = mysqli_query($conn, $product_sql);
                            $product = mysqli_fetch_assoc($product_result);
                            
                            $picDestination = "images/productImages/".$product['pimage'];
                            $quantity = isset($row['quantity']) ? $row['quantity'] : 1;
                            $subtotal = $product['price'] * $quantity;
                            $total += $subtotal;
                    ?>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <section class="product-item">
                                <strong><h2 class="title" style="color:black;"><?php echo htmlspecialchars($product['product']); ?></h2></strong>
                                <a href="review.php?pid=<?php echo $product['pid']; ?>">
                                    <img class="image fit" src="<?php echo htmlspecialchars($picDestination); ?>" alt="<?php echo htmlspecialchars($product['product']); ?>" />
                                </a>

                                <div class="product-details">
                                    <blockquote>
                                        Type: <?php echo htmlspecialchars($product['pcat']); ?><br>
                                        Price: ₹<?php echo number_format($product['price'], 2); ?><br>
                                        Subtotal: ₹<?php echo number_format($subtotal, 2); ?>
                                    </blockquote>
                                    
                                    <!-- Quantity Control -->
                                    <form method="post" action="mycart.php" class="quantity-control">
                                        <button type="button" class="quantity-btn minus" data-pid="<?php echo $product['pid']; ?>">-</button>
                                        <input type="number" name="quantity" class="quantity-input" value="<?php echo $quantity; ?>" min="1" max="10" readonly>
                                        <button type="button" class="quantity-btn plus" data-pid="<?php echo $product['pid']; ?>">+</button>
                                        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">
                                        <input type="hidden" name="update_quantity" value="1">
                                    </form>
                                    
                                    <!-- Remove Button -->
                                    <a href="mycart.php?remove=1&pid=<?php echo $product['pid']; ?>" 
                                       class="button special small" 
                                       onclick="return confirm('Are you sure you want to remove this item from your cart?')">
                                        Remove Item
                                    </a>
                                </div>
                            </section>
                        </div>
                    <?php 
                        }
                    } 
                    ?>
                    </div>

                    <!-- Cart Summary -->
                    <?php if(mysqli_num_rows($result) > 0): ?>
                    <div class="cart-summary">
                        <h3>Order Summary</h3>
                        <p>Total Items: <?php echo mysqli_num_rows($result); ?></p>
                        <p>Total Price: ₹<?php echo number_format($total, 2); ?></p>

						<a href="buyNow.php?pid=<?php echo htmlspecialchars($pid); ?>" class="button special">Proceed to Checkout</a>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </section>

<<<<<<< HEAD


					</div>

			</section>
					</header>

			</section>

	</body>
</html>
=======
    <script>
    // AJAX quantity adjustment
    $(document).ready(function() {
        $('.quantity-btn').click(function() {
            var btn = $(this);
            var input = btn.siblings('.quantity-input');
            var currentVal = parseInt(input.val());
            var pid = btn.data('pid');
            
            if(btn.hasClass('plus')) {
                if(currentVal < 10) {
                    input.val(currentVal + 1);
                }
            } else if(btn.hasClass('minus')) {
                if(currentVal > 1) {
                    input.val(currentVal - 1);
                }
            }
            
            // Submit the form
            btn.closest('form').submit();
        });
        
        // AJAX form submission
        $('.quantity-control form').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            
            $.ajax({
                type: "POST",
                url: "mycart.php",
                data: form.serialize(),
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert("Error updating quantity");
                }
            });
        });
    });
    </script>
</body>
</html>
>>>>>>> 03bb666 (changes)
