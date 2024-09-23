<?php
function upload_files()
{
    $db = new db2();
    $heading = 'Upload Files';
    // <script src="https://cdn.tailwindcss.com"></script>
    $head = '

    <link href="dist/output.css" rel="stylesheet">    ';
    switch($_GET["action"])
    {
        case "upload":

            $name = ($_FILES['user_file']['name']);
            if(!$name)
            {
                alert("");
                redirect(page_url());
            }
            $file_path = upload('user_file', 'user_files');

            $added_by_id = $_SESSION["users_id"];
            $added_by_name = $_SESSION["users_name"];

            $sql = "INSERT INTO `client_file`
            (`name`, `file_path`, `added_by_id`, `added_by_name`) 
            VALUES 
            ('$name', '$file_path', '$added_by_id', '$added_by_name')";
            $db->sqlq($sql);
            alert("File uploaded sucessfully");
            redirect(page_url());
        break;
        case "delete_image_confirm":
            $id = $_GET["id"];
            echo '<script>
            if(confirm("Are you sure you want to delete?"))
            {
                location.href="?action=delete_image&id='.$id.'";
            }
            else
            {
                location.href="'.page_url().'";
            }
            </script>';
            die;
        case "delete_image":
            $id = $_GET["id"];
            $db->sqlq("update client_file set status = '0' where id = $id");
            redirect(page_url());
            break;
        }
    $temp = get_sidebar().'
        <div class="col-lg-8 col-md-7">
            <div class="px-4 sm:px-0">
                <h3 class="text-base font-semibold leading-7 text-gray-900">'.$heading.'</h3>
                <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Please select file and press upload</p>
                <form action="?action=upload" method="post" enctype="multipart/form-data">
                    <div class="col-lg-12 col-md-12 text-center">
                        <input type="file" name="user_file" id="user_file">
                    </div>
                    <div class="col-lg-12 col-md-12 text-center">
                    <p>&nbsp;</p>
                        <input type="submit" value="Upload File" name="submit" class="fnc_btn reverses">
                    </div>
                </form>
			</div>
            <div class="col-lg-12 col-md-12 text-center">
            <p>&nbsp;</p>
            </div>
            <div id="file_cards">
            ';
        $sql = "select * from client_file where added_by_id = ".$_SESSION["users_id"]." and status = '1'";
        $result = $db->result($sql);
        foreach($result as $a)
        {
            extract($a);
            $ext = pathinfo(basename($file_path), PATHINFO_EXTENSION);
            $temp .= '
        <div class="card"><a href="'.$file_path.'" target="_blank">
        <i class="fa fa-download">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
        </i>
        '.file_get_contents('filetype/'.$ext.'.svg').'
        <!--<svg class="svg-icon" style="width: 5em; height: 5em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024"></svg>-->
        <div class="title"> '.$name.'</div>
                <hr>
                <div class="file_size">
                    <a href="?action=delete_image_confirm&id='.$id.'">Delete</a>
                </div>
            </a>
        </div>';
            // debug_r($a);
        }

        $temp .= '        </div>
        </div>';
	$head .= ' <style>
    #file_cards
    {
        display: flex;
        justify-content: space-around;
    }
    #file_cards a
    {
        color:black;
    }
    #file_cards .card
    {
        width: 250px;
        height:250px;
        border: thin solid #CCC;
        text-align:center;
        padding:20px 20px 10px;
        border-radius:15px;
        position:relative;
    }
    #file_cards .card i
    {
        position: absolute;
        top: 10px; 
        right: 20px;
        font-size:20px;
    }
    #file_cards svg
    {
        display:block;
        text-align:center;
        margin:auto;
        max-width: 68px;
    }
    #file_cards .card hr
    {
        display:none;
        border-top: 1px solid #999;
        position: relative;
        overflow:visible;
        padding-left:10px;
        margin:20px 0;
    }
    #file_cards .card hr:after, #file_cards .card hr:before
    {
        content: "x";
        color: black;
        font-size: 11px;
        position: absolute;
        top: -7px;
    }
    #file_cards .card hr:after
    {
        right:-5px;
    }
    #file_cards .card hr:before
    {
        left:-5px;
    }
    #file_cards .card .file_size
    {
        margin-top:60px;
        display: flex;
        justify-content: space-between;
    
    }
    </style>
    
    ';
	$data_n = array();
	$data_n["html_head"] = "";
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n['html_text'] = wrap_form($temp, '', '');
    $data_n["html_head"] = $head;
	return $data_n;
}