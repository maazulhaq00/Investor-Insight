<?php
// $id = $_SESSION['users_id'];
// echo $id;
function data_center()
{
    if (!is_login()) {
        return login();
        return user_not_logged_in();
    }
    $c = new client();
    $heading = 'Data Center';
    
    // <script src="https://cdn.tailwindcss.com"></script>
    $head = '';
    
    $temp = get_sidebar().'
        <div class="col-lg-8 col-md-7">
            <div class="px-4 sm:px-0">
                <h3 class="text-base font-semibold leading-7 text-gray-900">'.$heading.'</h3>';
    $temp .= $c->show_datacenter().'<p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500"></p>';
    $temp .= '
        </div>
        <div class="col-lg-12 col-md-12 text-center">
            <p>&nbsp;</p>
        </div>
    </div>';
    // debug_r($a);
    $temp .= '
        </div>
    </div>';
	$head .= '';
	$data_n = array();
	$data_n["html_head"] = "";
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n['html_text'] = wrap_form($temp, '', '');
    $data_n["html_head"] = $head;
	return $data_n;
}