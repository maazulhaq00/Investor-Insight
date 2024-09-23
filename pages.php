<?php include("includes/application_top2.php");
// echo 1;die;
$data_html = get_tuple("html", page_name(), "html_name");
$data = [];
if(function_exists(page_name()))
{
  eval("\$data = ".page_name()."();");
}
// echo phpinfo();die;
//to pick up from html if not in function 
if(!isset($data['html_title']) || empty($data['html_title'])) $data["html_title"] = $data_html['html_title'];
if(!isset($data['html_heading']) || empty($data['html_heading'])) $data["html_heading"] = $data_html['html_heading'];
if(!isset($data['html_text']) || empty($data['html_text'])) $data["html_text"] = $data_html['html_text'];

if((!isset($data['bg_class']) || empty($data['bg_class'])) && isset($data_html['bg_class']) && !empty($data_html['bg_class']))
  $data["bg_class"] = $data_html['bg_class'];
if(!isset($data['bg_class']) || empty($data['bg_class'])) $data["bg_class"] = 'bg_4';
if(!$data["html_title"])
{
    $data["html_title"] = ucwords(page_name());
    $data["html_heading"] = ucwords(page_name());
    if(!$data["html_text"] ) {
        $data["html_text"] = 'Website Under Consturction';
    }
}
//debug_r($data);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $data["html_title"]; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include('template_parts/head.php'); ?>
    </head>
    <body>
    <?php include('template_parts/header.php'); 
    if(page_name() == 'contact_us')
    {
        echo htmlspecialchars_decode($data['html_text']);
    }
    else
    {
    ?>
        <!-- Page Banner Section Start -->
        <section class="page_banner <?=$data["bg_class"]?> no_overlay pb_light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pb_content text-left">
                            <h2><?=$data["html_heading"]?></h2>
                            <p><a href="index.php"><?php 
                            echo (page_name() == 'services' ? 'Services' : 'Home');
                            ?></a><b>-</b><span><?=$data["html_title"]?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page Banner Section End -->
        <section class="comon_section">
            <div class="container">
                <div class="row">
                   <?=htmlspecialchars_decode($data['html_text']);?>
                </div>
            </div>
        </section>
    <?php
    }
    include('template_parts/cta.php'); ?>
        <?php include('template_parts/footer.php'); ?>
        <?php echo $data["html_head"]; ?>
    </body>
</html>