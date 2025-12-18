<!DOCTYPE html>
<html>
<head>
    <?php require "commons/head.php"; ?>
</head>
<body>
    <?php
        require "php/config.php";
        $query="SELECT COUNT(*) as shops FROM userdata";
        $result=mysqli_query($conn,$query) or die("Query Failed");
        $total_shops=mysqli_fetch_assoc($result)['shops'];
    ?>
    <div class="topbar">
        <div class="logo-box">
            <img src="images/logos/mobifix-purple.png">    
        </div>
        <div class="links-box">
            <nav>
                <img src="images/logos/mobifix-purple.png">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#features-box">Features</a></li>
                    <li><a href="#process-box">Process</a></li>
                    <li><a href="#about-box">About</a></li>
                    <li><a href="#contact-box">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div class="quick-box">
            <button class="login secondry-btn">Login</button>
            <button class="register primary-btn">Register</button>
            <i class="fa fa-bars" id="menu-btn"></i>
        </div>
    </div>
    <div class="container">
        <header>
            <div class="left-header">
                <h1 id="main-heading">Smart Way to Manage Your <span>Mobile Repairing</span> Shop</h1>
                <p id="header-desc">Mobifix is a powerful yet simple Mobile Repairing Shop Management System designed to make your business stress-free. It’s 100% free, super easy to use, automatically generates invoices, and securely saves all your customer data to the cloud—so you can focus on growing your repair shop while we handle the management</p>
                <div class="header-btn-box">
                    <button class="header-register primary-btn"><i class="fa fa-shop"></i> Register Your Shop</button>
                    <button class="header-login secondry-btn"><i class="fa fa-sign-in-alt"></i> Login to Shop</button>
                </div>
                <div class="statics-box">
                    <div class="stats">
                        <h3><?php echo 1000+$total_shops."+"; ?></h3>
                        <p>Shops Registered</p>
                    </div>
                    <div class="stats">
                        <h3>100%</h3>
                        <p>Satisfaction Rate</p>
                    </div>
                    <div class="stats">
                        <h3>24/7</h3>
                        <p>Support Available</p>
                    </div>
                </div>
            </div>
            <div class="right-header">
                <div class="inner-header"></div>
            </div>
        </header>
        <section>
            <div class="first-section" id="features-box">
                <h2 class="first-section-heading">Powerful <span>Features</span> Designed for <span>Your Shop</span></h2>
                <p class="first-section-desc">Everything you need to manage your repair business efficiently</p>
                <div class="features">
                    <div class="feature">
                        <i class="fa fa-infinity feature-icon"></i>
                        <h3>100% Free & Unlimited</h3>
                        <p>Mobifix is completely free and we do not charges anything from you for our services.</p>
                        <ul>
                            <li><i class="fa fa-check-circle"></i> 100% Free</li>
                            <li><i class="fa fa-check-circle"></i> No Hidden Charges</li>
                            <li><i class="fa fa-check-circle"></i> No Trial Limit</li>
                        </ul>
                    </div>
                    <div class="feature">
                        <i class="fa fa-laptop-code feature-icon"></i>
                        <h3>Easy Dashboard</h3>
                        <p>Simple dashboard to track repairs, customers, and payments without any hassle</p>
                        <ul>
                            <li><i class="fa fa-check-circle"></i> Easiest Dashboard</li>
                            <li><i class="fa fa-check-circle"></i> Easy Tracking</li>
                            <li><i class="fa fa-check-circle"></i> No need to learn</li>
                        </ul>
                    </div>
                    <div class="feature">
                        <i class="fa fa-file feature-icon"></i>
                        <h3>Auto Invoice Generator</h3>
                        <p>Create professional invoices in just one click and share instantly</p>
                        <ul>
                            <li><i class="fa fa-check-circle"></i> Unlimited Invoices</li>
                            <li><i class="fa fa-check-circle"></i> PDF Download</li>
                            <li><i class="fa fa-check-circle"></i> Invoice Sharing</li>
                        </ul>
                    </div>
                    <div class="feature">
                        <i class="fa fa-cloud-upload feature-icon"></i>
                        <h3>Secure Cloud Storage</h3>
                        <p>All customer & repair data saved safely in the cloud—accessible anytime, anywhere</p>
                        <ul>
                            <li><i class="fa fa-check-circle"></i> Unlimited Storage</li>
                            <li><i class="fa fa-check-circle"></i> Secure and Fast</li>
                            <li><i class="fa fa-check-circle"></i> Access Data Anywhere</li>
                        </ul>
                    </div>
                    <div class="feature">
                        <i class="fa fa-line-chart feature-icon"></i>
                        <h3>Business Analytics</h3>
                        <p>Get reports & analytics to understand sales, expenses, and growth in one place</p>
                        <ul>
                            <li><i class="fa fa-check-circle"></i> Customers Data</li>
                            <li><i class="fa fa-check-circle"></i> Orders Data</li>
                            <li><i class="fa fa-check-circle"></i> Data Download</li>
                        </ul>
                    </div>
                    <div class="feature">
                        <i class="fa fa-clock feature-icon"></i>
                        <h3>Customer History</h3>
                        <p>Track every customer’s past repairs, invoices, and payments in seconds</p>
                        <ul>
                            <li><i class="fa fa-check-circle"></i> Historical Data</li>
                            <li><i class="fa fa-check-circle"></i> Tracking</li>
                            <li><i class="fa fa-check-circle"></i> Returning Customers</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="second-section" id="process-box">
                <div class="inner-second-section">
                    <h2 class="second-section-heading">How <span>Mobifix</span> Works</h2>
                    <p class="second-section-desc">Get started in just a few simple steps</p>
                    <div class="process-box">
                        <div class="left-process">
                            
                        </div>
                        <div class="right-process">
                            <div class="step">
                                <div class="left-step">
                                    <div class="left-left-step">
                                        <h6>01</h6>
                                    </div>
                                    <div class="left-right-step">
                                        <h3>Sign Up Free</h3>
                                        <p>Create your free Mobifix account in seconds—no credit card required.</p>
                                    </div>
                                </div>
                                <div class="right-step">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="step">
                                <div class="left-step">
                                    <div class="left-left-step">
                                        <h6>01</h6>
                                    </div>
                                    <div class="left-right-step">
                                        <h3>Add Customers & Repairs</h3>
                                        <p>Enter customer details and repair jobs quickly with a simple form.</p>
                                    </div>
                                </div>
                                <div class="right-step">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="step">
                                <div class="left-step">
                                    <div class="left-left-step">
                                        <h6>01</h6>
                                    </div>
                                    <div class="left-right-step">
                                        <h3>Generate Invoice</h3>
                                        <p>Automatically create and share professional invoices with one click.</p>
                                    </div>
                                </div>
                                <div class="right-step">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="step">
                                <div class="left-step">
                                    <div class="left-left-step">
                                        <h6>01</h6>
                                    </div>
                                    <div class="left-right-step">
                                        <h3>Manage & Grow</h3>
                                        <p>All your data stays safe in the cloud—track sales, payments, and grow your repair shop with ease.</p>
                                    </div>
                                </div>
                                <div class="right-step">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="third-section" id="about-box">
                <div class="inner-third-section">
                    <h2>About Mobifix : Our Introduction</h2>
                    <p>Mobifix is a smart and free mobile repairing shop management system built to make your business simple, fast, and stress-free. With Mobifix, you can easily add customer details, manage repair jobs, and create professional invoices in just a few clicks. All your important data is safely stored in the cloud, so you can access it anytime, anywhere without worries. Whether you run a small repair shop or handle multiple customers daily, Mobifix helps you save time, reduce paperwork, and focus more on repairing while we handle the management side for you.</p>
                </div>
            </div>
            <div class="fourth-section" id="contact-box">
                <div class="inner-fourth-section">
                    <div class="contact-box">
                        <div class="contact">
                            <i class="fa fa-phone"></i>
                            <h2>Phone Number</h2>
                            <p>+91 8882778758</p>
                        </div>
                        <div class="contact">
                            <i class="fa fa-envelope"></i>
                            <h2>Email Address</h2>
                            <p>contact@Mobifix.com</p>
                        </div>
                        <div class="contact">
                            <i class="fa-brands fa-whatsapp"></i>
                            <h2>WhatsApp Number</h2>
                            <p>+91 8882778758</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            @copyright 2025 - all rights are reserved by Mobifix Pvt. Ltd.
        </footer>
    </div>
    <script>
        $(document).ready(function(){
            setTimeout(function(){
                $(".left-process").html('<iframe src="https://www.youtube.com/embed/MpZBIseUUlg?si=AD_S1dxGUD0UfCnZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>');
            },4000);
            $("#menu-btn").click(function(){
                if($(this).hasClass("fa fa-bars"))
                {
                    $(this).attr("class","fa fa-close");
                    $(".links-box").animate({
                        "left":"0px"
                    },400);
                }
                else
                {
                    $(this).attr("class","fa fa-bars");
                    $(".links-box").animate({
                        "left":"-300px"
                    },400);
                }

                $(".links-box nav ul li a").click(function(){
                    $(".links-box").animate({
                        "left":"-300px"
                    },400);

                    $("#menu-btn").attr("class","fa fa-bars");
                });
            });

            $(".login,.header-login").click(function(){
                location.href="login.php";
            });

            $(".register,.header-register").click(function(){
                location.href="register.php";
            });
        });
    </script>
</body>
</html>