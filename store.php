<?php 
    // require files
    require_once("config/config.php"); 
    require_once("includes/header.php");
    $collection = $_GET['collection_id'];

    $sql = "SELECT count(id) as nmbr_of_products FROM `products` WHERE `collection_id` = '$collection'";
    $result = mysqli_query($conn , $sql);
    $row = mysqli_fetch_assoc($result) ;
    
    // filters
    $filter = $_GET['filterby'];
    if($filter == "bestselling") {
        $order = "sales";
        $sort = 'ASC';
    } else if ($filter == "AZ" || $filter == "ZA") {
        $order = "name";
        if($filter == "AZ") {
            $sort = 'ASC';
        } else {
            $sort = 'DESC';
        }
    } else if ($filter == "High" || $filter == "Low") {
        $order = "price";
         if($filter == "High") {
             $sort = 'DESC';
            } else {
            $sort = 'ASC';
        }
    } else {
        $order = "create-at";
         if($filter == "New") {
            $sort = 'ASC';
        } else {
            $sort = 'DESC';
        }
    }


        // add to cart functionality
        if(isset($_POST['add'])) {
            if(isset($_SESSION['cart'])) {
                $item_arr_id = array_column($_SESSION['cart'], column_key:"product_id");
    
                if(in_array($_POST['product_id'] , $item_arr_id)) {
                    echo '<script>alert("product is already added to the cart
                    ")</script>';
                } else {
                    $count = count($_SESSION['cart']);
                    $item_arr=array('product_id'=>$_POST["product_id"]);
                    $_SESSION['cart'][$count] = $item_arr;
                }
               
            } else {
    
                $item_arr=array(
                    'product_id'=>$_POST["product_id"],
                );
    
                 $_SESSION['cart'][0] = $item_arr;
            }
        }
    
?>
<!-- breadcumps -->
<section class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="index.php" class="text-primary">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
        </ol>
    </nav>
</section>
   <section class="container mt-8">
       <div class="d-flex align-items-center justify-content-between my-4">
           <p class="text-dark fw-bold"><?php echo $row['nmbr_of_products']; ?> Products</p>
           <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="drop" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php  echo $filter ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="drop">
                    <li><a class="dropdown-item" href="store.php?filterby=bestselling">Best Selling</a></li>
                    <li><a class="dropdown-item" href="store.php?filterby=AZ">Alphabities - A,Z</a></li>
                    <li><a class="dropdown-item" href="store.php?filterby=ZA">Alphabities - Z,A</a></li>
                    <li><a class="dropdown-item" href="store.php?filterby=Low">Price - Low To High</a></li>
                    <li><a class="dropdown-item" href="store.php?filterby=High">Price - High To Low</a></li>
                    <li><a class="dropdown-item" href="store.php?filterby=New">Date - New To Old </a></li>
                    <li><a class="dropdown-item" href="store.php?filterby=Old">Date - Old To New</a></li>
                </ul>
            </div>
       </div>
       <div class="row">
           <?php 
           $sql = "SELECT * FROM `products` WHERE `collection_id` = '$collection'  ORDER BY `$order` $sort  ";
           $result = mysqli_query($conn , $sql);
           while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-3 col-sm-6 col-12 mb-5">
                     <div class="card" >
                        <img src="<?php echo $row['src'] ?>" class="img-fluid" alt="<?php echo $row['name'] ?>">
                        <div class="card-body">
                                  <form method="POST" class="d-flex align-items-center justify-content-between">
                                        <a href="product.php?id=<?php echo $row['id'] ?>" class="text-primary"><?php echo $row['name'] ?></a>
                                        <input type="hidden" name="product_id" value="<?php echo $row["id"] ?>">
                                        <button type="submit" name="add" class="btn btn-primary">
                                            <i class="fas fa-shopping-cart cursor "></i>
                                        </button>
                                    </form>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="card-text my-3">Price: <?php echo $row['price'] ?></p>
                                <p class="card-text my-3">Sales: <?php echo $row['sales']  ?></p>
                            </div>
                        </div>
                      </div>
                 </div>
             <?php }   ?>
       </div>
   </section>
<?php 
    require_once("includes/footer.php")
?>