<?php
    require_once("config/config.php"); 
    require_once("includes/header.php");

    if(isset($_POST["register"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $hash_pass = password_hash("$password", PASSWORD_BCRYPT);
        $sql = "INSERT INTO `users` (`firstname` , `lastname` , `email` , `password` , `isAdmin`) VALUES ('$fname' , '$lname' , '$email' , '$hash_pass' , 'false') ";
        $result = mysqli_query($conn , $sql);
      
        if($result){  
            header("Location:login.php") ; 
        }  
    } 
?>

<section class="mt-5">
    <form class="row" method="POST">
        <div class="col-sm-3 col-12"></div>
        <div class="col-sm-6 col-12">
            <div class="card  w-100">
            <i class="fas p-4 text-center text-info fa-user fa-3x" alt="account"></i>
                <div class="card-body p-4">
                     <div class="mb-5">
                        <label for="FirstName" class="form-label">FirstName</label>
                        <input type="FirstName" name="fname" class="form-control" id="FirstName" placeholder="FirstName">
                    </div>
                    <div class="mb-5">
                        <label for="LastName" class="form-label">LastName</label>
                        <input type="LastName" name="lname" class="form-control" id="LastName" placeholder="LastName">
                    </div>
                    <div class="mb-5">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-5">
                        <label for="pass" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="pass" >
                    </div>
                    <button type="submit" name="register" class="btn btn-outline-primary w-100">
                         Register
                    </button>
                </div>
                <div class="card-footer ">
                   <p class="text-muted">
                       You Already Have An Account ? <a href="login.php">Log in</a>
                   </p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-12"></div>
    </form>
</section>

<?php
    require_once("includes/footer.php") 
?>
<!-- good good very good -->