<!-- Case Section Start -->
<section class="case_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 text-left">
                <h5 class="sub_title no_bars">Our Projects</h5>
                <h2 class="sec_title">Case Studies</h2>
                <div class="dvd_bar"></div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="case_slider_01_nav">
                    <button type="button" class="case_navigation case_prev"><i class="bx bx-left-arrow-alt"></i></button>
                    <button type="button" class="case_navigation case_next"><i class="bx bx-right-arrow-alt"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 noPadding">
                <div class="case_slider_01 owl-carousel">
                    <?php
                    $db = new db2();
                    $sql = "select * from project";
                    $result = $db->result($sql);
                    foreach($result as $a)
                    {
                        extract($a);
                        // debug_r($image_upload);
                        // $image_upload = 'images/case/1.jpg';
                        echo '
                    <div class="case_01">
                        <img src="'.$image_upload.'" alt=""/>
                        <div class="c01_cats">
                            <a href="#"></a>
                        </div>
                        <div class="c01_det">
                            <h2><a href="#">'.$name.'</a></h2>
                            <p>'.$description.'</p>
                            <!--<a href="#" class="learn_more_lnk">Read More</a>-->
                        </div>
                    </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
</div>
</section>
<!-- Case Section End -->