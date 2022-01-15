<?php
    require_once("config/config.php"); 
    require_once("includes/header.php");

     // add to cart functionality
    if(isset($_POST['add'])) {
        if(isset($_SESSION['cart'])) {
            $item_arr_id = array_column($_SESSION['cart'], column_key:"product_id");
            if(in_array($_POST['product_id'] , $item_arr_id)) {
                echo '<script>alert("product is already added to the cart")</script>';
            } else {
                echo "hi";
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

<div class="row mt-5">
    <div class="col-md-9 col-sm-8 col-12">
        <!-- Slider main container -->
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">
                    <div class="bg-image-1 text-white text-center">
                        <h1 class="fw-bold fs-1 mt-5">Best Accessories</h1>
                        <p class="my-3 lh-lg word-spacing w-75 mx-auto">The Best Tech-Accessories Provided By Us </p>
                        <a href="store.php?filterby=bestselling" class="btn btn-outline-light ">Shop Now</a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-image-2 text-white text-center">
                        <h1 class="fw-bold fs-1 mt-5">Latest Products</h1>
                        <p class="my-3 lh-lg word-spacing w-75 mx-auto">Check Our Latest Products Added To Our Store</p>
                        <a href="store.php?filterby=New" class="btn btn-outline-light ">Shop Now</a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-image-3 text-white text-center">
                        <h1 class="fw-bold fs-1 mt-5">Phone Accessories</h1>
                        <p class="my-3 lh-lg word-spacing w-75 mx-auto">Shop From The Best Phone Accessories You Need For Your Phone</p>
                        <a href="store.php?collection_id=2&filterby=New" class="btn btn-outline-light ">Shop Now</a>
                    </div>
                </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
    <div class="col-md-3 col-sm 4 col-12">
    <?php 
        $sql = "SELECT * FROM `promotion` WHERE `home_page` = 'true' ORDER BY `id` DESC LIMIT 1";
        $result = mysqli_query($conn , $sql);
        while ($row = mysqli_fetch_assoc($result)) { ?>
          <img src=" <?php echo $row['src']?>" alt="<?php echo $row['name'] ?>" class="img-fluid">
        <?php } ?>    
        <img src="assets/images/special.jpg" alt="special offer" class="img-fluid">
    </div>
</div>
    <!-- best selling +++ latest products -->
    <section class="mt-8">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-Best-Selling-tab" data-bs-toggle="pill" data-bs-target="#pills-Best-Selling" type="button" role="tab" aria-controls="pills-Best-Selling" aria-selected="true">Best-Selling</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-Latest-Products-tab" data-bs-toggle="pill" data-bs-target="#pills-Latest-Products" type="button" role="tab" aria-controls="pills-Latest-Products" aria-selected="false">Latest Products</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-Best-Selling" role="tabpanel" aria-labelledby="pills-Best-Selling-tab">
                <div class="grid">
                    <?php 
                        $sql = "SELECT * FROM `products` ORDER BY `sales` DESC LIMIT 0,5";
                        $result = mysqli_query($conn , $sql);
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="columne">
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
            </div>
            <div class="tab-pane fade" id="pills-Latest-Products" role="tabpanel" aria-labelledby="pills-Latest-Products-tab">
                <div class="grid">
                    <?php 
                        $sql = "SELECT * FROM `products` ORDER BY `id` DESC LIMIT 0,5";
                        $result = mysqli_query($conn , $sql);
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="columne">
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
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- promotion -->
    <section class="mt-8 row">
    <?php 
        $sql = "SELECT * FROM `promotion` WHERE `home_page` = 'false' ORDER BY `id` DESC LIMIT 0,2";
        $result = mysqli_query($conn , $sql);
        while ($row = mysqli_fetch_assoc($result)) { 
            ?>
        <div class="col-md-6 col-12">
            <img src="admin/<?php echo $row['src'] ?>" alt="<?php echo $row['name'] ?>" class="img-fluid">
        </div>
        <?php } ?>    
    </section>

    <!-- categories -->
    <section class="mt-8">
        <h2 class="fs-2 fw-bold text-dark mb-4">Categories</h2>
        <div class="row">
            <?php  
            $sql = "SELECT * FROM `collection` ORDER BY `id` DESC LIMIT 0,5";
            $result = mysqli_query($conn , $sql);
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-4 col-sm-6 col-12">
                    <a href="store.php?collection_id=<?php echo $row['id'] ?>&filterby=bestselling" >
                        <div  class="card cardhv bg-dark text-white fw-bold h-200">
                            <img src=" <?php echo $row['src'] ?>" alt=" <?php echo $row['name'] ?>" class="img-fluid transition">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center background-overlay">
                                <h5 class="card-title fw-bold fs-3 "><?php echo $row['name'] ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php   } ?>
        </div>
    </section>


<?php

    require_once("includes/footer.php") 
?>