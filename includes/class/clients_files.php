<?php
function clients_files()
{
    $a = new client();
    $heading = "Manage Client Files";
    $head = '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';
	switch($action)
    {
        case'clients_files':
            $temp = $a->clients_files();
            break;
        
        default:
            $temp = $a->clients_files();
    }
	$data_n["html_head"] = $head;
	$data_n["html_title"] = $heading;
	$data_n["html_text"] = $temp;
	return $data_n;
}