<!-- Preloader Start -->
<!-- <div class="preloader">
  <div class="la-ball-scale-multiple la-2x">
      <div></div>
      <div></div>
      <div></div>
  </div>
</div> -->
<!-- Preloader Start -->

<!-- Top Bar Start -->
<section class="top_bar">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3 col-xl-2">
                <div class="info_item">
                    <i class="bx bx-support"></i>
                    <h5>Call / WhatsApp:</h5>
                    <h6><a target="_blank" href="https://wa.me/+971553070661">+9232-02755331</a></h6>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-xl-2" id="top_bar_email">
                <div class="info_item">
                    <i class="bx bx-at"></i>
                    <h5>Email Us:</h5>
                    <h6><a href="mailto:ta2899274@gmail.com">ta2899274@gmail.com</a></h6>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-xl-3 noPaddingRight">
                <div class="info_item">
                    <i class="bx bxs-map"></i>
                    <h5>Our Locations:</h5>
                    <h6>Karachi, Pakistan</h6>

                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-xl-5">
                <div class="bar_btns">
                    <a href="<?php echo BASE_URL; ?>#request_quote_section" class="req_btn "><span>Request a
                            Quote</span><i class="bx bx-right-arrow-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Top Bar End -->

<!-- Header 01 Start -->
<header class="header_01 isSticky">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-3">
                <div class="logo_01">
                    <a href="<?=BASE_URL?>">
                        <img src="<?=BASE_URL?>images/Investor_insight.png" alt="investor_insight" />
                    </a>
                </div>
            </div>
            <div class="col-md-7 col-lg-9">
                <nav class="menu_1">
                    <div class="menuButton">
                        <a href="#">Menu<i class="bx bx-menu"></i></a>
                    </div>
                    <ul>
                        <li>
                            <a href="<?=BASE_URL?>">Home</a>
                        </li>
                        <li>
                            <a href="<?=BASE_URL?>about_us">About Us</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Service</a>
                            <?php echo service_list('sub-menu'); ?>
                        </li>
                        <li><a href="<?=BASE_URL?>contact_us">Contact Us</a></li>
                        <?php if(is_login()) 
                        echo '<li><a href="'.BASE_URL.DEFAULT_MY_ACCOUNT_URL.'">Client Portal</a>
                        <ul class="sub-menu">
                            <li><a href="dash">Dashboard</a></li>
                            <!-- <li><a href="my_account">Profile</a></li> -->
                            <li><a href="upload_files">Upload Files</a></li>
                            <li><a href="data_center">Data Center</a></li>
                            <li><a href="billing">Billing</a></li>
                        </ul>
                    </li>';
                    else{
                        echo '<li><a href="'.BASE_URL.DEFAULT_MY_ACCOUNT_URL.'">Client Portal</a>
                            <ul class="sub-menu">
                                <li><a href="dash">Login</a></li>
                                <li><a href="register.php">Register</a></li>
                            </ul>
                        </li>';
                    }
                    ?>

                        <?= is_login() ? '<li><a href="'.BASE_URL.'logout.php">Logout</a></li>' : ''; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
<div class="blanks"></div>
<!-- Header 01 End -->
<!-- Popup Search Start -->
<section class="popup_search_sec">
    <div class="popup_search_overlay"></div>
    <div class="pop_search_background">
        <div class="middle_search">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="popup_search_form">
                            <form method="get" action="#">
                                <input type="search" name="s" id="s" placeholder="Type Words and Hit Enter">
                                <button type="submit"><i class="bx bx-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Popup Search End -->