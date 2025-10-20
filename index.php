<?php
    //PROTECTED PAGE
    session_start();

    //LOGOUT
    if(isset($_POST['logout'])){
        unset($_SESSION['email']);
    }

    //BACK TO LOGIN PAGE IS NOT SIGNED IN
    // if(!isset($_SESSION['email'])){
    //     log($_SESSION['email']);
    //     header("Location: login.php");
    //     exit();
    // }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bagpackers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- <h1>WELCOME!</h1> -->
    <header>
        <a href="#">Logo</a>

        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="product.html">Product</a></li>
                <li><a href="">Blog</a></li>
                <li><a href="">About</a></li>
                <?php
                    //CHECK IF LOGGED IN
                    if(isset($_SESSION['email'])){
                        echo '<li><a href="">
                                    <div class="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                        </svg>
                                        <div class="dropdown-menu">
                                            <a href="dashboard.html">Dashboard</a>
                                            <form method="post">
                                                <input type="hidden" name="logout" value="1">
                                                <input class="btnLogout" type="submit" value="Logout">
                                            </form>
                                        </div>
                                    </div>
                                </a></li>';
                    }else{
                        echo '<li><a href="login.php">Login</a></li>';
                    }
                ?>
            </ul>
        </div>
    </header>

    <section id="hero">
        <div class="heroTeks">
            <h4>Best-of-the-Best-offer</h4>
            <h2>Be ready for the school</h2>
            <h1>On all products</h1>
            <p>Save more with up to discount <strong>60%</strong> off!</p>
            <button>Go to Shop</button>
        </div>
        <div class="heroImage">
            <img src="heroImage.png" alt="" width="600" height="600">
        </div>
    </section>

    <section id="categoriesLine" class="section-p1">
        <div class="cateLine-box">
            <img src="images/bp_06.jpg" alt="" width="100" height="100">
            <p>Bag</p>
        </div>

        <div class="cateLine-box">
            <img src="images/stationery.jpg" alt="" width="100" height="100">
            <p>Stationery</p>
        </div>

        <div class="cateLine-box">
            <img src="images/shoes.jpg" alt="" width="100" height="100">
            <p>Shoes</p>
        </div>

        <div class="cateLine-box">
            <img src="images/lunchbottle.png" alt="" width="100" height="100">
            <p>Box & Bottle</p>
        </div>

        <div class="cateLine-box">
            <img src="images/book.jpg" alt="" width="100" height="100">
            <p>Book</p>
        </div>
    </section>

    <section id="products" class="section-p1">
        <h3>Best Seller Products</h3>
        <p>The best among every schoolers</p>
        <div class="container">
            <div class="prod">
                <img src="images/eagle.png" alt="">
                <div class="pro-desc">
                    <div>
                        <p>Eagle</p>
                        <h4 class="name">Galaxy Eagle Shoes</h4>
                        <h4 >Rp218.405</h4>
                    </div>
                    <div class="icon">
                        <p>Icon</p>
                    </div>
                </div>
            </div>

            <div class="prod">
                <img src="images/hooligans.png" alt="">
                <div class="pro-desc">
                    <div>
                        <p>Hooligans</p>
                        <h4 class="name">Hooligans Bag Gullit x Black</h4>
                        <h4>Rp118.800</h4>
                    </div>
                    <div class="icon">
                        <p>Icon</p>
                    </div>
                </div>
            </div>

            <div class="prod">
                <img src="images/sidu.png" alt="">
                <div class="pro-desc">
                    <div>
                        <p>Sinar Dunia</p>
                        <h4 class="name">Book (38 pages)</h4>
                        <h4>Rp6.500</h4>
                    </div>
                    <div class="icon">
                        <p>Icon</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <footer class="section-p1">
            <h4 style="margin-bottom: 20px;">Logo</h4>
            <p>Slogan here!</p>
            <p><strong>Address</strong></p>
            <p>Pesona Khayangan, Block X 100. Kelurahan Pakisaji Kecamatan Beji Kota Depok.</p>
            <p><strong>Follow Us</strong></p>
            <div class="socialMedia">
                <p>FB</p>
                <p>Instagram</p>
                <p>Twitter</p>
                <p>Youtube</p>
            </div>
        <hr style="margin-top: 20px;">
        <p style="text-align: center;">&copy;2025 - Bagpackers</p>
    </footer>
</body>
</html>