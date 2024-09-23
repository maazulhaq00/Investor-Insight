<?php

function allfiles()
{
    if (!is_login()) {
        return login();
        return user_not_logged_in();
    }
    $c = new client();
    $heading = 'Data Center';
    $head = '';
    $temp = '';
    $temp = '
    <div class="col-lg-12">
        <table class="table table-striped" >
            <tbody>';
            $temp .= $c->show_allfiles().'<p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500"></p>';
            $temp .= '
            </tbody>
        </table>
        
    </div>
    ';

    $head.= '';
    $data_n = array();
	$data_n["html_head"] = "";
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n['html_text'] = wrap_form($temp, '', '');
    $data_n["html_head"] = $head;
	return $data_n;

}




?>

