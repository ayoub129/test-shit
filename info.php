<!-- info page -->
<?php 
    // require the config for db
    require_once("config/config.php");
    // require the header 
    require_once("includes/header.php");


    
    // send the info to the users table  
    if(isset($_POST["checkout"])) {

        $id = $_SESSION['id'];

        $country = $_POST['country'];
        $postalcode = $_POST['postalcode'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        if(isset($_SESSION['id'])) {  
            $sql = "UPDATE users SET `Country`='$country' , `postalcode`= '$postalcode' , `city` = '$city' , `state` = '$state' , `address` = '$address' , `phone` = '$phone'  WHERE `id`='$id'";
            if(mysqli_query($conn , $sql)) {
                // header('Location : checkout.php');
            }
        } else {
            header("Location: login.php");
        }
    }

    // get the total
    $price = 0;
    if (isset($_SESSION['cart'])){
        $product_id = array_column($_SESSION['cart'], column_key:'product_id');
        $sql = "SELECT * FROM `products`";
        $result = mysqli_query($conn , $sql);
        while ($row = mysqli_fetch_assoc($result)) { 
            foreach ($product_id as $id){
                if ($row['id'] == $id){ 
                    $price = $price + $row['price'];
                }
            }
        }
    }

   
    // check the discount and add them to the total

    if (isset($_POST["discountsend"])) {
        $discount = $_POST["discount"];

        $sql = "SELECT * FROM `discount` WHERE `code` = '$discount'";
        
    }
?>
<!-- breadcumps -->
<section class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="index.php" class="text-primary">Home</a></li>
            <li class="breadcrumb-item "><a href="cart.php" class="text-primary">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Information</li>
        </ol>
    </nav>
</section>

<!-- shopping cart summary -->
<section class="container mt-5">
    <div class="row">
        <div class="col-md-6 col-12">
            <h2 class="fs-1 fw-bold text-dark">Contact information</h2>
            <?php 
                        // get the data if the user already login in
                        $id = $_SESSION["id"];
                        $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
                        $query = mysqli_query($conn , $sql);
                        while ($row = mysqli_fetch_assoc($query)) {?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" value="<?php echo $row["email"] ?>"  class="form-control" id="email" placeholder="name@example.com">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  id="checkbox" checked>
                                    <label class="form-check-label" for="checkbox">
                                        Email me with news and offers
                                    </label>
                            </div>
                            <div class="line bg-secondary w-100 my-3 "></div>
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="FirstName" class="form-label">FirstName</label>
                                            <input type="text" value="<?php echo $row["firstname"] ?>" class="form-control" id="FirstName" >
                                        </div>
                                </div>
                                <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="LastName" class="form-label">LastName</label>
                                            <input type="text" value="<?php echo $row["lastname"] ?>" class="form-control" id="LastName" >
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="Country" class="form-label">Country</label>
                                    <input type="text" value="<?php echo $row["Country"] ?>" class="form-control" id="Country" placeholder="ex: USA" >
                                </div>
                        </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                        <label for="City" class="form-label">City</label>
                                        <input type="text" value="<?php echo $row["city"] ?>" class="form-control" id="City" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="State" class="form-label">State</label>
                                            <input type="text" value="<?php echo $row["state"] ?>" class="form-control" id="State" >
                                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" value="<?php echo $row["address"] ?>" class="form-control" id="Address" >
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="PostalCode" class="form-label">Postal Code</label>
                                            <input type="text" value="<?php echo $row["postalcode"] ?>" class="form-control" id="PostalCode"  >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="Phone" class="form-label">Phone</label>
                                            <input type="text" value="<?php echo $row["phone"] ?>" class="form-control" id="Phone" >
                                        </div>
                                    </div>
                                </div>
                            <button type="submit" name="checkout" class="btn btn-primary my-3 w-50">Checkout</button>
                        </form>
                <?php } ?>
        </div>
        <div class="col-md-6 col-12">
        <h2 class="fs-1 fw-bold text-dark">Summary</h2>
        <form method="POST" class="input-group my-4">
            <input type="text" id="discount" name="discount" class="form-control" placeholder="discount Code" aria-label="discount Code" aria-describedby="btn">
            <button class="btn btn-outline-primary" name="discountsend" type="submit" id="btn">Send</button>
        </form>
        <div class="d-flex align-items-center justify-content-between ">
            <p class="text-dark">
                Subtotal Price
            </p>
            <p class="text-dark">
                $<?php echo $price ?>
            </p>
        </div>
        <div class="d-flex align-items-center justify-content-between ">
            <p class="text-dark">
                Discount code
            </p>
            <?php 
                // check the discount and add them to the total

                if (isset($_POST["discountsend"])) {
                    $discount = $_POST["discount"];

                    $sql = "SELECT * FROM `discount` WHERE `code` = '$discount'";
                    $result = mysqli_query($conn , $sql);

                    while ($row = mysqli_fetch_assoc($result)) { 
                        $persentage = $row['persentage'] ;
                        ?>
                        %<?php echo $persentage?>
                    <?php  }} else {?>
                            <p class="text-dark">
                                %0
                            </p>
                    <?php } ?>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-2">
            <p class="text-dark">
                 Shipping 
            </p>
            <h6 class="text-success">FREE</h6>
        </div>
        <div class="line bg-secondary w-100"></div>
        <div class="d-flex align-items-center justify-content-between my-3">
            <p class="text-dark">
                 Total 
            </p>
            <p class="text-dark">
            <?php $total =  $price * $persentage / 100?>
                $<?php echo $total ?>
            </p>
        </div>
      </div>
    </div>
</section>



<!-- Email call -->
<section class="mt-5 justify-content-center text-center container d-flex">
    <address class="me-5">
        <p class="text-dark">
            Email us
        </p>
        <a href="mailto:techshop000.store@gmail.com" class="text-primary">
            techshop000.store@gmail.com
        </a>
    </address>
    <address>
        <p class="text-dark">
            Call us
        </p>
        <a href="tel:+212 635747467" class="text-primary">
            +212 635747467
        </a>
    </address>
</section>

<?php 
    // require the footer 
    require_once("includes/footer.php");
?>