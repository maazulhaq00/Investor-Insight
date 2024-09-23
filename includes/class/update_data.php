<?php
function update_data()
{
    $a = new client();
    $heading = "Manage Client Data";
    $head = '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';
	switch($action)
    {
        
        case'edit_data':
            $temp = $a->edit_data();
            break;
        case'email_send':
            $temp = $a->email_send();
            break;
        case'resend_email':
            $temp = $a->resend_email();
            break;
        case'new_currency':
            list($head, $temp) = $a->new_currency();
            break;
        case'new_sparklinedata':
            list($head, $temp) = $a->new_sparklinedata();
            break;
        case 'insert_data':
            $a->insert_data();
            break;
        case'new_graph1data':
            list($head, $temp) = $a->new_graph1data();
            break;
        case'new_graph2data':
            list($head, $temp) = $a->new_graph2data();
            break;
        case'new_graph3data':
            list($head, $temp) = $a->new_graph3data();
            break;
        case'new_graph4data':
            list($head, $temp) = $a->new_graph4data();
            break;
        case'new_invoice':
        case 'edit_invoice':
            list($head, $temp) = $a->new_invoice($_GET["id"]);
            break;
        case 'edit_sparklinedata':
            list($head, $temp) = $a->new_sparklinedata($_GET["id"]);
            break;
        case 'edit_graph1data':
            list($head, $temp) = $a->new_graph1data($_GET["id"]);
            break;
        case 'edit_graph2data':
            list($head, $temp) = $a->new_graph2data($_GET["id"]);
            break;
        case 'edit_graph3data':
            list($head, $temp) = $a->new_graph3data($_GET["id"]);
            break;
        case 'edit_graph4data':
            list($head, $temp) = $a->new_graph4data($_GET["id"]);
            break;
        case'edit':
        // case 'edit_invoice':
            list($head, $temp) = $a->edit($_GET["id"]);
            break;
        case 'update':
            $a->update();
            break;
        case 'delete':
            $a->delete();
            break;
        case 'delete_confirm':
            echo '<script>
            if(confirm("Are you sure you want to delete the record?"))
                location.href="'.page_name().'?action=delete&id='.$_GET['id'].'";
            else
                location.href="'.page_name().'";
            </script>';
            die;
            break;
        case 'insert_invoice':
            $a->insert_invoice();
            break;
        case 'insert_currency':
            $a->insert_currency();
            break;
        case 'update_invoice':
            $a->update_invoice();
            break;
            
        case 'update_sparklinedata':
            $a->update_sparklinedata();
            break;

        case 'update_graph1data':
            $a->update_graph1data();
            break; 
        case 'update_graph2data':
            $a->update_graph2data();
            break;
        case 'update_graph3data':
            $a->update_graph3data();
            break;
        case 'update_graph4data':
            $a->update_graph4data();
            break;      
        case'new_data_center':
        case 'data_center':
            list($head, $temp) = $a->data_center($_GET["id"]);
            break;
        case 'insert_data_center':
            $a->insert_data_center();
            break;
        case 'edit_data_center':
            list($head, $temp) = $a->data_center($_GET["id"]);
            break;
        case 'update_data_center':
            $a->update_data_center();
            break;
        case'see_sparklinedata':
            list($head, $temp) = $a->see_sparklinedata();
            break;  
        case'see_graph1dat':
            list($head, $temp) = $a->see_graph1data();
            break;
        case'see_graph2dat':
            list($head, $temp) = $a->see_graph2data();
            break;      
        case'see_graph3dat':
            list($head, $temp) = $a->see_graph3data();
            break; 
        case'see_graph4dat':
            list($head, $temp) = $a->see_graph4data();
            break;
        case'see_invoice':
            list($head, $temp) = $a->see_invoice();
            break;       
        case'see_data_center':
            list($head, $temp) = $a->see_data_center();
            break;
        default:
            $temp = $a->show();
    }
	$data_n["html_head"] = $head;
	$data_n["html_title"] = $heading;
	$data_n["html_text"] = $temp;
	return $data_n;
}