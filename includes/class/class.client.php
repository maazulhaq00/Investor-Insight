<?php

class client extends db2
{
    function show() {
        $sql = "SELECT * FROM client";
        $result = $this->result($sql);
        $temp = ''; 
    
        if ($_SESSION["users_name"] === "admin") {
            $temp .= '<div class="row">
                        <div class="col">
                            <a href="?action=new_currency"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> Add Currency</button></a>
                        </div>
                    </div> <br>';
        }
    
        $temp .= '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Client ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                        <td>' . ($i + 1) . '</td>
                        <td>' . htmlspecialchars($name) . '</td>
                        <td>' . htmlspecialchars($email) . '</td>
                        <td>' . htmlspecialchars($id) . '</td>';
            
            if ($_SESSION["users_name"] === "admin") {
                $temp .= '<td>
                            <a href="?action=edit_data&id=' . urlencode($id) . '"><button type="button" class="btn bg-gradient-warning"><i class="fa fa-sync"></i> Update Data</button></a>
                            <a href="?action=edit&id=' . urlencode($id) . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-edit"></i> Edit</button></a>
                            <a href="?action=email_send&id=' . $id . '"><button type="button" class="btn bg-gradient-info"><i class="fa fa-envelope"></i> Send Email</button></a>
                            <a href="?action=resend_email&id=' . $id . '"><button type="button" class="btn bg-gradient-secondary"><i class="fa fa-envelope"></i>Resend Email</button></a>
                            <a href="?action=delete_confirm&id=' . urlencode($id) . '"><button type="button" class="btn bg-gradient-danger"><i class="fa fa-trash"></i> Delete</button></a>
                          </td>';
            } elseif ($_SESSION["users_name"] === "MK_PC") {
                $temp .= '<td>
                            <a href="?action=edit_data&id=' . urlencode($id) . '"><button type="button" class="btn bg-gradient-warning"><i class="fa fa-sync"></i> Update Data</button></a>
                          </td>';
            } elseif ($_SESSION["users_name"] === "skypc_02") {
                $temp .= '<td>
                            <a href="?action=edit_data&id=' . urlencode($id) . '"><button type="button" class="btn bg-gradient-warning"><i class="fa fa-eye"></i> See Data</button></a>
                          </td>';
            } else {
                $temp .= '<td></td>';
            }
            
            $temp .= '</tr>';
        }
    
        $temp .= '</tbody></table>';
        return wrap($temp, 'Select Client');
    }
    
    function delete()
    {
        $id = $_GET['id'];
        //remove files
        $sql = "select * from client_file where added_by_id = $id";
        $files = $this->result($sql);
        foreach ($files as $file) {
            unlink($file['file_path']);
        }
        // die;
        $sql = "delete from client_data where client_id = $id; delete from client_file where added_by_id = $id;delete from client where id = $id;";
        $this->sqlq($sql);
        alert('Updated Successfully.');
        redirect(page_name());
    }
    function update()
    {
        $id = $_GET['id'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        $currency = $_POST['currency'];
        // debug_r($_POST);

        $pic_upload = '';
        $profile_photo_upload = upload($_FILES['profile_photo_upload'], 'users_images');
        if ($profile_photo_upload) {
            $pic_upload .= ", profile_photo_upload = '$profile_photo_upload' ";
        }
        if ($password) {
            $pic_upload .= ", password = MD5('$password') ";
        }
        // debug_r($_POST);
        $sql = "update client set 
        name = '$name',
        email = '$email',
        status = '$status',
        currency = '$currency'
        $pic_upload
      WHERE 
        id = $id";
        $this->sqlq($sql);
        // debug_r($sql);
        alert('Updated Successfully.');
        redirect(page_name());
        // debug_r($sql);
    }
    function edit()
    {
        $back_url = 'update_data';
        $id = $_GET['id'];
        $client = get_tuple('client', $id, 'id');
        $heading = 'Edit Client: ' . $client['name'] . ' &lt;' . $client['email'] . ' &gt;';
        // debug_r($client);
        // $data = register('edit');
        $temp = '
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">' . $heading . $label_main . '</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
      <form class="" method="post" action="?action=update&id=' . $client['id'] . '" enctype="multipart/form-data">
      <div class="card-body">  
        <small class="text-red">Leave fields unchanged to remain previous values</small>
        ' . generate_textbox(['name' => 'name', 'value' => $client['name']]) . '
        ' . generate_textbox(['name' => 'password', 'value' => '']) . '
        ' . generate_upload('profile_photo_upload', $client['profile_photo_upload']) . '
        ' . generate_textbox(['name' => 'email', 'value' => $client['email']]) . '
        ' . generate_textbox(['name' => 'currency', 'value' => $client['currency']]) . '
        ' . generate_bool(['name' => 'status', 'value' => $client['status']], 'Status') . '
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
          <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
      </div>
    </form>';
        // $temp = wrap_form($temp, '', '');
        return [$head, $temp];
    }
    function show_invoices()
    {
        $id = $_SESSION['users_id'];
        // debug_r($_SESSION);
        $temp .= '
        <p></p>
        <div class="row">
            <div class="col">';
        $sql = "select * from invoice where client_id = $id order by dated desc";
        $result = $this->result($sql);
        $temp .= '<table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Month</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                ';
        foreach ($result as $i => $a) {
            // debug_r($a);
            extract($a);
            if (!$file_upload) continue;
            $temp .= '<tr>
            <td>' . ($i + 1) . '</td>
            <td>' . date("M, Y", mysql_to_timestamp($dated)) . '</td>
            <td>
                <a href="' . $file_upload . '">
                <a target="_blank" href="' . $file_upload . '">
                  <button type="submit" name="send_message" class="fnc_btn reverses"><span>Download Invoice<i class="bx bx-right-arrow-alt"></i></span></button>
                </a>
            </td>
        </tr>';
        }
        $temp .= '
            </tbody>
        </table>';
        return $temp;
    }
    function edit_data()
    {
        extract($this->check_client_id());
        $heading = 'Update Client Data (<em>' . $client['name'] . '</em>)';
        //update client monthly data
        
        $temp = '
        <div class="row">
            <div class="col">';
            if ($_SESSION["users_name"] == "admin" || $_SESSION["users_name"] == "MK_PC") {
                $temp = '<a href="?action=new_sparklinedata&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> Add Sparkline Data</button></a>
                        <a href="?action=new_graph1data&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> Add graph 1 Data</button></a>
                        <a href="?action=new_graph2data&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> Add Graph 2 Data</button></a>
                        <a href="?action=new_graph3data&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> Add Graph 3 Data</button></a>
                        <a href="?action=new_graph4data&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> Add Graph 4 Data</button></a>
                        <a href="?action=new_invoice&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-upload"></i> Add Invoice</button></a>
                        <a href="?action=data_center&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-upload"></i> Add Data Center</button></a>';
            } elseif ($_SESSION["users_name"] == "skypc_02") {
                $temp = '<a href="?action=see_sparklinedata&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> See Sparkline Data</button></a>
                        <a href="?action=see_graph1data&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> See graph 1 Data</button></a>
                        <a href="?action=see_graph2data&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> See Graph 2 Data</button></a>
                        <a href="?action=see_graph3data&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> See Graph 3 Data</button></a>
                        <a href="?action=see_graph4data&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-database"></i> See Graph 4 Data</button></a>
                        <a href="?action=see_invoice&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-upload"></i> See Invoice</button></a>
                        <a href="?action=see_data_center&id=' . $id . '"><button type="button" class="btn bg-gradient-success"><i class="fa fa-upload"></i> See Data Center</button></a>';
            } else {
                $temp = '';
            }
            
            $temp .= '</div></div>';
            return wrap($temp, $heading);
            
    }
    function see_sparklinedata()
    {
        // Extract client ID details
        extract($this->check_client_id());

        $sql = "SELECT * FROM client_data WHERE client_id = $id ORDER BY id DESC";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' 
    <h3>Sparkline Boxes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Date</th>
                <th>Total Fund Commitment</th>
                <th>Assets Under Management</th>
                <th>Holding Positions</th>
                <th>Number of Investors</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
            <td>' . ($i + 1) . '</td>
            <td>' . mysql_to_php_date($valuation_points) . '</td>
            <td>' . $total_fund_commitment . '</td>
            <td>' . $assets_under_management . '</td>
            <td>' . $holding_position . '</td>
            <td>' . $investor_count . '</td>
        </tr>';
        }

        $temp .= '
        </tbody>
    </table>
    </div>
    <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>';

        return [$head, $temp];
    }
    function see_graph1data()
    {
        extract($this->check_client_id());
        
        $sql = "select * from client_data where client_id = $id order by id desc";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Graph 1</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Fund NAV</th>
                        <th>TASI</th>
                        <th>SP_500</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($valuation_points) . '</td>
                <td>' . $fund_nav . '</td>
                <td>' . $tasi . '</td>
                <td>' . $sp_500 . '</td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function see_graph2data()
    {
        extract($this->check_client_id());
        
        $sql = "select * from client_data where client_id = $id order by id desc";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Graph 2</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Fund NAV</th>
                        <th>Dividend Per Share</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($valuation_points) . '</td>
                <td>' . $fund_nav . '</td>
                <td>' . $dividend_per_share . '</td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function see_graph3data()
    {
        extract($this->check_client_id());
        
        $sql = "select * from client_data where client_id = $id order by id desc";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Graph 3</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Realized Gain Or Loss</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($valuation_points) . '</td>
                <td>' . $realized_gain_or_loss . '</td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function see_graph4data()
    {
        extract($this->check_client_id());
       
        $sql = "select * from client_data where client_id = $id order by id desc";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Graph 4</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Dividend Per Share</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($valuation_points) . '</td>
                <td>' . $dividend_per_share . '</td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function see_invoice()
    {
        extract($this->check_client_id());
        
        $temp .= '
    <p></p>
    <div class="row">
        <div class="col">';
        $sql = "select * from invoice where client_id = $id order by id desc";
        $result = $this->result($sql);
        $temp .= '<table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            ';
        foreach ($result as $i => $a) {
            // debug_r($a);
            extract($a);
            $temp .= '<tr>
        <td>' . ($i + 1) . '</td>
        <td>' . mysql_to_php_date($dated) . '</td>
        <td>
            <a href="' . $file_upload . '">
            ' . (!$file_upload ? '' : '<a target="_blank" href="' . $file_upload . '"><button type="button" class="btn bg-gradient-warning">View</button></a>') . '
        </td>
    </tr>';
        }
        $temp .= '
        </tbody>
    </table>';
        return [$head, $temp];
    }
    function see_data_center()
    {
        extract($this->check_client_id());
        
        $sql = "SELECT * FROM data_center where client_id = $id";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Data Center</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($dated) . '</td>
                <td>' . $name . '</td>
                <td>' . $description . '</td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function new_invoice()
    {
        extract($this->check_client_id());
        $back_url = 'update_data?action=edit_data&id=' . $id;
        $label_main = 'New Invoice';
        $action = 'insert_invoice&client_id=' . $id;
        $insert_field = '';
        $invoice_id = $_GET["invoice_id"];
        if ($invoice_id) {
            $action = 'update_invoice&invoice_id=' . $invoice_id;
            $prev_data = get_tuple("invoice", $invoice_id, 'id');
            $label_main = 'Edit Invoice';
            // $insert_field = ''.generate_textbox(["name" => "roll_number", "value" => $prev_data["roll_number"]]).'';
            // debug_r($prev_data);
        } else
            $prev_data_id = 0;
        $heading = '' . $client['name'] . ' - ';
        //update client monthly data
        //'.($only_edit ? '' : generate_dropdown(["name" => "level_id", "value" => $prev_data["level_id"], 'filter'=> " WHERE programme_id = $programme_id"])).'
        list($temp_head, $temp_dated) = generate_date(['title' => 'Date of Invoice', "name" => "dated", "value" => ($prev_data["dated"] ? $prev_data["dated"] : "")]);
        $head .= $temp_head;
        $temp = '
      <div class="card">
        <div class="card-header">
        <h3 class="card-title">' . $heading . $label_main . '</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="form1" method="post" action="?action=' . $action . '" enctype="multipart/form-data">
          <div class="card-body">
            ' . $temp_dated . '
            ' . generate_upload("file_upload", $prev_data["file_upload"]) . '
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
              <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
          </div>
        </form>
      </div>
      <!-- /.card -->';
        //if no old data exists
        $temp .= '
    <p></p>
    <div class="row">
        <div class="col">';
        $sql = "select * from invoice where client_id = $id order by id desc";
        $result = $this->result($sql);
        $temp .= '<table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            ';
        foreach ($result as $i => $a) {
            // debug_r($a);
            extract($a);
            $temp .= '<tr>
        <td>' . ($i + 1) . '</td>
        <td>' . mysql_to_php_date($dated) . '</td>
        <td>
            <a href="' . $file_upload . '">
            ' . (!$file_upload ? '' : '<a target="_blank" href="' . $file_upload . '"><button type="button" class="btn bg-gradient-warning">View</button></a>') . '
            <a href="?action=edit_invoice&invoice_id=' . $id . '&id=' . $client_id . '"><button type="button" class="btn bg-gradient-success">Edit</button></a>
            <a href="?action=delete_confirm_invoice&id=' . $id . '"><button type="button" class="btn bg-gradient-danger align-right">Delete</button></a>
        </td>
    </tr>';
        }
        $temp .= '
        </tbody>
    </table>';
        return [$head, $temp];
    }
    function new_currency()
    {
        $back_url = 'update_data';
        $heading = 'Edit Client: ';
        $prev_data = [];
        // debug_r($client);
        // $data = register('edit');
        $temp = '
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">' . $heading . '</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
      <form class="" method="post" action="?action=insert_currency" enctype="multipart/form-data">
      <div class="card-body">  
        ' . generate_textbox(['name' => 'currency', 'value' => '']) . '
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
          <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
      </div>
    </form>
    </div>';
        $sql = "select * from currency";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= '
        <div class="card">
        <div class="card-header">
        <h3>Currency</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 30px">#</th>
                        <th>Currency</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $currency . '</td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            ';
        // $temp = wrap_form($temp, '', '');
        return [$head, $temp];
    }
    function insert_currency()
    {
        $currency = $_REQUEST['currency'];
        $sql = "INSERT INTO `currency` (`currency`) 
      VALUES ('$currency')";
        // debug_r($sql);
        $this->sqlq($sql);
        redirect('?action=new_currency');
    }
    function new_sparklinedata()
    {
        // Extract client ID details
        extract($this->check_client_id());

        $back_url = 'update_data?action=edit_data&id=' . $id;
        $label_main = 'New Data';
        $action = 'insert_data&client_id=' . $id;
        $sparklinedata_id = $_GET["sparklinedata_id"];
        $insert_field = '';

        // Check if sparklinedata_id is present
        if ($sparklinedata_id) {
            $action = 'update_sparklinedata&sparklinedata_id=' . $sparklinedata_id;
            $prev_data = get_tuple("client_data", $sparklinedata_id, 'id');
            $label_main = 'Edit Data';
            // Debug previous data if needed
            // debug_r($prev_data);
        } else {
            $prev_data_id = 0;
            $prev_data = []; // Ensure $prev_data is an array to avoid undefined index errors
        }

        $heading = $client['name'] . ' - ';

        // Generate date fields
        list($temp_head, $temp_students_date_of_birth) = generate_date(["name" => "valuation_points", "value" => ($prev_data["valuation_points"] ?? "")]);
        $head = $temp_head;

        $temp = '
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">' . $heading . $label_main . '</h3>
        </div>
        <form id="form1" method="post" action="?action=' . $action . '">
            <div class="card-body">
                ' . $temp_students_date_of_birth . '
                ' . generate_textbox(["name" => "total_fund_commitment", "value" => $prev_data["total_fund_commitment"] ?? ''], "Total Fund Commitment") . '
                ' . generate_textbox(["name" => "assets_under_management", "value" => $prev_data["assets_under_management"] ?? ''], "Assets Under Management") . '
                ' . generate_textbox(["name" => "holding_position", "value" => $prev_data["holding_position"] ?? ''], "Holding Positions") . '
                ' . generate_textbox(["name" => "investor_count", "value" => $prev_data["investor_count"] ?? ''], "Number Of Investor") . '
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
        </form>
    </div>';

        $head .= '
    <script>
        $(function () {
            // Validation and input masks initialization here
            $.validator.setDefaults({
                submitHandler: function (form) {
                    form.submit();
                }
            });
            $("#form1").validate({
                rules: {
                    total_fund_commitment: {
                        required: true
                    },
                    assets_under_management: {
                        required: true
                    },
                    investor_count: {
                        required: true
                    },
                    holding_position: {
                        required: true
                    },
                },
                messages: {
                    total_fund_commitment: {
                        required: "Please enter the total fund commitment"
                    }
                },
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    element.closest(".form-group").append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass("is-invalid");
                }
            });
        });
    </script>';

        $sql = "SELECT * FROM client_data WHERE client_id = $id ORDER BY id DESC";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' 
    <h3>Sparkline Boxes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Date</th>
                <th>Total Fund Commitment</th>
                <th>Assets Under Management</th>
                <th>Holding Positions</th>
                <th>Number of Investors</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
            <td>' . ($i + 1) . '</td>
            <td>' . mysql_to_php_date($valuation_points) . '</td>
            <td>' . $total_fund_commitment . '</td>
            <td>' . $assets_under_management . '</td>
            <td>' . $holding_position . '</td>
            <td>' . $investor_count . '</td>
            <td>
                <a href="?action=edit_sparklinedata&sparklinedata_id=' . $id . '&id=' . $client_id . '"><button type="button" class="btn bg-gradient-success">Edit</button></a>
                <button type="button" class="btn bg-gradient-danger align-right">Delete</button>
            </td>
        </tr>';
        }

        $temp .= '
        </tbody>
    </table>
    </div>
    <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>';

        return [$head, $temp];
    }
    function new_graph1data()
    {
        extract($this->check_client_id());
        $back_url = 'update_data?action=edit_data&id=' . $id;
        $label_main = 'New Graph 1';
        $action = 'insert_data&client_id=' . $id;
        $graph1data_id = $_GET["graph1data_id"];

        if ($graph1data_id) {
            $action = 'update_graph1data&graph1data_id=' . $graph1data_id;
            $prev_data = get_tuple("client_data", $graph1data_id, 'id');
            $label_main = 'Edit Data';
            // Debug previous data if needed
            // debug_r($prev_data);
        } else {
            $prev_data_id = 0;
            $prev_data = []; // Ensure $prev_data is an array to avoid undefined index errors
        }

        $heading = $client['name'] . ' - ';
        //update client monthly data
        //'.($only_edit ? '' : generate_dropdown(["name" => "level_id", "value" => $prev_data["level_id"], 'filter'=> " WHERE programme_id = $programme_id"])).'
        list($temp_head, $temp_students_date_of_birth) = generate_date(["name" => "valuation_points", "value" => ($prev_data["valuation_points"] ? $prev_data["valuation_points"] : "")]);
        $head .= $temp_head;
        $temp = '
        <div class="card">
          <div class="card-header">
          <h3 class="card-title">' . $heading . $label_main . '</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="form1" method="post" action="?action=' . $action . '" enctype="multipart/form-data">
            <div class="card-body">
              ' . $temp_students_date_of_birth . '
              ' . generate_textbox(["name" => "fund_nav", "value" => $prev_data["fund_nav"]], "Fund Nav") . '
              ' . generate_textbox(["name" => "tasi", "value" => $prev_data["tasi"]], "Tasi") . '
              ' . generate_textbox(["name" => "sp_500", "value" => $prev_data["sp_500"]], "SP_500") . '
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
          </form>
      </div>
      <!-- /.card -->';
        $head .= '<script>
       
        $(function () {
          // debugger;
          // students_age
          //Datemask dd/mm/yyyy
        //   $("#nic").inputmask("99999-9999999-9");
        //   $("#students_emergency_contact").inputmask("0999-9999999");
        //   $("#mothers_contact_number").inputmask("0999-9999999");
        //   $("#students_date_of_birth").inputmask("99/99/9999");
        //   $("#students_date_of_birth").on("change dp.change focusout", function (){ update_age() });
        //   $("#nic").on("change focusout", function (){ check_nic() });
          ';

        $head .= '
          $.validator.setDefaults({
            submitHandler: function (form) {
              form.submit();
            }
        });
        $("#form1").validate({
          rules: {
            fund_nav: {
                required: true
            },
            tasi: {
                required: true
            },
            sp_500: {
                required: true
            },
          },
          messages: {
            fund_nav: {
              required: "Please enter the students name",
              email: "Please enter the students name"
            }
          },
          errorElement: "span",
          errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
          }
        });
        });
        </script>';
        $sql = "select * from client_data where client_id = $id order by id desc";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Graph 1</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Fund NAV</th>
                        <th>TASI</th>
                        <th>SP_500</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($valuation_points) . '</td>
                <td>' . $fund_nav . '</td>
                <td>' . $tasi . '</td>
                <td>' . $sp_500 . '</td>
                <td>
                    <a href="?action=edit_graph1data&graph1data_id=' . $id . '&id=' . $client_id . '"><button type="button" class="btn bg-gradient-success">Edit</button></a>
                    <button type="button" class="btn bg-gradient-danger align-right">Delete</button>
                </td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function new_graph2data()
    {
        extract($this->check_client_id());
        $back_url = 'update_data?action=edit_data&id=' . $id;
        $label_main = 'New Graph 2';
        $action = 'insert_data&client_id=' . $id;
        $graph2data_id = $_GET["graph2data_id"];

        if ($graph2data_id) {
            $action = 'update_graph2data&graph2data_id=' . $graph2data_id;
            $prev_data = get_tuple("client_data", $graph2data_id, 'id');
            $label_main = 'Edit Data';
            // Debug previous data if needed
            // debug_r($prev_data);
        } else {
            $prev_data_id = 0;
            $prev_data = []; // Ensure $prev_data is an array to avoid undefined index errors
        }

        $heading = $client['name'] . ' - ';
        //update client monthly data
        //'.($only_edit ? '' : generate_dropdown(["name" => "level_id", "value" => $prev_data["level_id"], 'filter'=> " WHERE programme_id = $programme_id"])).'
        list($temp_head, $temp_students_date_of_birth) = generate_date(["name" => "valuation_points", "value" => ($prev_data["valuation_points"] ? $prev_data["valuation_points"] : "")]);
        $head .= $temp_head;
        $temp = '
        <div class="card">
          <div class="card-header">
          <h3 class="card-title">' . $heading . $label_main . '</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="form1" method="post" action="?action=' . $action . '" enctype="multipart/form-data">
            <div class="card-body">
              ' . $temp_students_date_of_birth . '
              ' . generate_textbox(["name" => "fund_nav", "value" => $prev_data["fund_nav"]], "Fund Nav") . '
              ' . generate_textbox(["name" => "dividend_per_share", "value" => $prev_data["dividend_per_share"]], "Dividend Per Share") . '
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
          </form>
      </div>
      <!-- /.card -->';
        $head .= '<script>
       
        $(function () {
          // debugger;
          // students_age
          //Datemask dd/mm/yyyy
        //   $("#nic").inputmask("99999-9999999-9");
        //   $("#students_emergency_contact").inputmask("0999-9999999");
        //   $("#mothers_contact_number").inputmask("0999-9999999");
        //   $("#students_date_of_birth").inputmask("99/99/9999");
        //   $("#students_date_of_birth").on("change dp.change focusout", function (){ update_age() });
        //   $("#nic").on("change focusout", function (){ check_nic() });
          ';

        $head .= '
          $.validator.setDefaults({
            submitHandler: function (form) {
              form.submit();
            }
        });
        $("#form1").validate({
          rules: {
            fund_nav: {
                required: true
            },
            tasi: {
                required: true
            },
            sp_500: {
                required: true
            },
          },
          messages: {
            fund_nav: {
              required: "Please enter the students name",
              email: "Please enter the students name"
            }
          },
          errorElement: "span",
          errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
          }
        });
        });
        </script>';
        $sql = "select * from client_data where client_id = $id order by id desc";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Graph 2</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Fund NAV</th>
                        <th>Dividend Per Share</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($valuation_points) . '</td>
                <td>' . $fund_nav . '</td>
                <td>' . $dividend_per_share . '</td>
                <td>
                    <a href="?action=edit_graph2data&graph2data_id=' . $id . '&id=' . $client_id . '"><button type="button" class="btn bg-gradient-success">Edit</button></a>
                    <button type="button" class="btn bg-gradient-danger align-right">Delete</button>
                </td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function new_graph3data()
    {
        extract($this->check_client_id());
        $back_url = 'update_data?action=edit_data&id=' . $id;
        $label_main = 'New Graph 3';
        $action = 'insert_data&client_id=' . $id;
        $graph3data_id = $_GET["graph3data_id"];

        if ($graph3data_id) {
            $action = 'update_graph3data&graph3data_id=' . $graph3data_id;
            $prev_data = get_tuple("client_data", $graph3data_id, 'id');
            $label_main = 'Edit Data';
            // Debug previous data if needed
            // debug_r($prev_data);
        } else {
            $prev_data_id = 0;
            $prev_data = []; // Ensure $prev_data is an array to avoid undefined index errors
        }

        $heading = $client['name'] . ' - ';
        //update client monthly data
        //'.($only_edit ? '' : generate_dropdown(["name" => "level_id", "value" => $prev_data["level_id"], 'filter'=> " WHERE programme_id = $programme_id"])).'
        list($temp_head, $temp_students_date_of_birth) = generate_date(["name" => "valuation_points", "value" => ($prev_data["valuation_points"] ? $prev_data["valuation_points"] : "")]);
        $head .= $temp_head;
        $temp = '
        <div class="card">
          <div class="card-header">
          <h3 class="card-title">' . $heading . $label_main . '</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="form1" method="post" action="?action=' . $action . '" enctype="multipart/form-data">
            <div class="card-body">
              ' . $temp_students_date_of_birth . '
              ' . generate_textbox(["name" => "realized_gain_or_loss", "value" => $prev_data["realized_gain_or_loss"]], "Realized Gain Or Loss") . '
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
          </form>
      </div>
      <!-- /.card -->';
        $head .= '<script>
       
        $(function () {
          // debugger;
          // students_age
          //Datemask dd/mm/yyyy
        //   $("#nic").inputmask("99999-9999999-9");
        //   $("#students_emergency_contact").inputmask("0999-9999999");
        //   $("#mothers_contact_number").inputmask("0999-9999999");
        //   $("#students_date_of_birth").inputmask("99/99/9999");
        //   $("#students_date_of_birth").on("change dp.change focusout", function (){ update_age() });
        //   $("#nic").on("change focusout", function (){ check_nic() });
          ';

        $head .= '
          $.validator.setDefaults({
            submitHandler: function (form) {
              form.submit();
            }
        });
        $("#form1").validate({
          rules: {
            fund_nav: {
                required: true
            },
            tasi: {
                required: true
            },
            sp_500: {
                required: true
            },
          },
          messages: {
            fund_nav: {
              required: "Please enter the students name",
              email: "Please enter the students name"
            }
          },
          errorElement: "span",
          errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
          }
        });
        });
        </script>';
        $sql = "select * from client_data where client_id = $id order by id desc";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Graph 3</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Realized Gain Or Loss</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($valuation_points) . '</td>
                <td>' . $realized_gain_or_loss . '</td>
                <td>
                    <a href="?action=edit_graph3data&graph3data_id=' . $id . '&id=' . $client_id . '"><button type="button" class="btn bg-gradient-success">Edit</button></a>
                    <button type="button" class="btn bg-gradient-danger align-right">Delete</button>
                </td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function new_graph4data()
    {
        extract($this->check_client_id());
        $back_url = 'update_data?action=edit_data&id=' . $id;
        $label_main = 'New Graph 4';
        $action = 'insert_data&client_id=' . $id;
        $graph4data_id = $_GET["graph4data_id"];

        if ($graph4data_id) {
            $action = 'update_graph4data&graph4data_id=' . $graph4data_id;
            $prev_data = get_tuple("client_data", $graph4data_id, 'id');
            $label_main = 'Edit Data';
            // Debug previous data if needed
            // debug_r($prev_data);
        } else {
            $prev_data_id = 0;
            $prev_data = []; // Ensure $prev_data is an array to avoid undefined index errors
        }

        $heading = $client['name'] . ' - ';
        //update client monthly data
        //'.($only_edit ? '' : generate_dropdown(["name" => "level_id", "value" => $prev_data["level_id"], 'filter'=> " WHERE programme_id = $programme_id"])).'
        list($temp_head, $temp_students_date_of_birth) = generate_date(["name" => "valuation_points", "value" => ($prev_data["valuation_points"] ? $prev_data["valuation_points"] : "")]);
        $head .= $temp_head;
        $temp = '
        <div class="card">
          <div class="card-header">
          <h3 class="card-title">' . $heading . $label_main . '</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="form1" method="post" action="?action=' . $action . '" enctype="multipart/form-data">
            <div class="card-body">
              ' . $temp_students_date_of_birth . '
              ' . generate_textbox(["name" => "dividend_per_share", "value" => $prev_data["dividend_per_share"]], "Dividend Per Share") . '
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
          </form>
      </div>
      <!-- /.card -->';
        $head .= '<script>
       
        $(function () {
          // debugger;
          // students_age
          //Datemask dd/mm/yyyy
        //   $("#nic").inputmask("99999-9999999-9");
        //   $("#students_emergency_contact").inputmask("0999-9999999");
        //   $("#mothers_contact_number").inputmask("0999-9999999");
        //   $("#students_date_of_birth").inputmask("99/99/9999");
        //   $("#students_date_of_birth").on("change dp.change focusout", function (){ update_age() });
        //   $("#nic").on("change focusout", function (){ check_nic() });
          ';

        $head .= '
          $.validator.setDefaults({
            submitHandler: function (form) {
              form.submit();
            }
        });
        $("#form1").validate({
          rules: {
            fund_nav: {
                required: true
            },
            tasi: {
                required: true
            },
            sp_500: {
                required: true
            },
          },
          messages: {
            fund_nav: {
              required: "Please enter the students name",
              email: "Please enter the students name"
            }
          },
          errorElement: "span",
          errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
          }
        });
        });
        </script>';
        $sql = "select * from client_data where client_id = $id order by id desc";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Graph 4</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Dividend Per Share</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($valuation_points) . '</td>
                <td>' . $dividend_per_share . '</td>
                <td>
                    <a href="?action=edit_graph4data&graph4data_id=' . $id . '&id=' . $client_id . '"><button type="button" class="btn bg-gradient-success">Edit</button></a>
                    <button type="button" class="btn bg-gradient-danger align-right">Delete</button>
                </td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }
    function check_client_id($id = '')
    {
        if (!$id) $id = $_GET["id"];
        if (!$id) {
            echo 'Error! Invalid URL. Contact System Administrator';
            die;
        }
        //check if client id exists
        $client = get_tuple('client', $id, 'id');
        if (!$client) {
            alert('Error! Invalid URL. Contact System Administrator');
            redirect(page_url());
        }
        return ['id' => $id, 'client' => $client];
    }
    function update_invoice()
    {
        $id = $_REQUEST['invoice_id'];
        $invoice = get_tuple('invoice', $id, 'id');
        $file_upload = upload($_FILES['file_upload'], 'file_upload');
        $dated = php_to_mysql_date($_REQUEST['dated']);
        $sql = "update `invoice`
      set `file_upload` = '$file_upload',
      `dated` = '$dated'
      WHERE id = $id;";
        // debug_r($sql);
        $this->sqlq($sql);
        alert("Invoice Updated");
        redirect('update_data?action=edit_data&id=' . $invoice['client_id']);
    }
    function update_sparklinedata()
    {
        $id = $_REQUEST['sparklinedata_id'];
        $sparklinedata = get_tuple('client_data', $id, 'id');
        $total_fund_commitment = $_REQUEST['total_fund_commitment'];
        $assets_under_management = $_REQUEST['assets_under_management'];
        $investor_count = $_REQUEST['investor_count'];
        $holding_position = $_REQUEST['holding_position'];
        $dated = php_to_mysql_date($_REQUEST['valuation_points']);
        $sql = "UPDATE `client_data` 
    SET `valuation_points`='$dated',
    `total_fund_commitment`='$total_fund_commitment',`assets_under_management`='$assets_under_management',
    `investor_count`='$investor_count',`holding_position`='$holding_position' WHERE id = $id";
        // debug_r($sql);
        $this->sqlq($sql);
        alert("Sparkline Data Updated");
        redirect('update_data?action=edit_data&id=' . $sparklinedata['client_id']);
    }
    function update_graph1data()
    {
        $id = $_REQUEST['graph1data_id'];
        $graph1data = get_tuple('client_data', $id, 'id');
        $fund_nav = $_REQUEST['fund_nav'];
        $tasi = $_REQUEST['tasi'];
        $sp_500 = $_REQUEST['sp_500'];
        $dated = php_to_mysql_date($_REQUEST['valuation_points']);
        $sql = "UPDATE `client_data` 
    SET `valuation_points`='$dated',
    `fund_nav`='$fund_nav',`tasi`='$tasi',
    `sp_500`='$sp_500' WHERE id = $id";
        // debug_r($sql);
        $this->sqlq($sql);
        alert("Graph 1 Data Updated");
        redirect('update_data?action=edit_data&id=' . $graph1data['client_id']);
    }
    function update_graph2data()
    {
        $id = $_REQUEST['graph2data_id'];
        $graph2data = get_tuple('client_data', $id, 'id');
        $fund_nav = $_REQUEST['fund_nav'];
        $dividend_per_share = $_REQUEST['dividend_per_share'];
        $dated = php_to_mysql_date($_REQUEST['valuation_points']);
        $sql = "UPDATE `client_data` 
    SET `valuation_points`='$dated',
    `fund_nav`='$fund_nav',
    `dividend_per_share`='$dividend_per_share' WHERE id = $id";
        // debug_r($sql);
        $this->sqlq($sql);
        alert("Graph 2 Data Updated");
        redirect('update_data?action=edit_data&id=' . $graph2data['client_id']);
    }
    function update_graph3data()
    {
        $id = $_REQUEST['graph3data_id'];
        $graph3data = get_tuple('client_data', $id, 'id');
        $realized_gain_or_loss = $_REQUEST['realized_gain_or_loss'];
        $dated = php_to_mysql_date($_REQUEST['valuation_points']);
        $sql = "UPDATE `client_data` 
    SET `valuation_points`='$dated',
    `realized_gain_or_loss`='$realized_gain_or_loss' WHERE id = $id";
        // debug_r($sql);
        $this->sqlq($sql);
        alert("Graph 3 Data Updated");
        redirect('update_data?action=edit_data&id=' . $graph3data['client_id']);
    }

    function update_graph4data()
    {
        $id = $_REQUEST['graph4data_id'];
        $graph4data = get_tuple('client_data', $id, 'id');
        $dividend_per_share = $_REQUEST['dividend_per_share'];
        $dated = php_to_mysql_date($_REQUEST['valuation_points']);
        $sql = "UPDATE `client_data` 
    SET `valuation_points`='$dated',
    `dividend_per_share`='$dividend_per_share' WHERE id = $id";
        // debug_r($sql);
        $this->sqlq($sql);
        alert("Graph 4 Data Updated");
        redirect('update_data?action=edit_data&id=' . $graph4data['client_id']);
    }
    function insert_invoice()
    {
        $client_id = $_REQUEST['client_id'];
        $client_data = $this->check_client_id($client_id);
        $client = $client_data['client'];
        $name = $client['name'];
        $file_upload = upload($_FILES['file_upload'], 'file_upload');
        $dated = php_to_mysql_date($_REQUEST['dated']);
        $sql = "INSERT INTO `invoice` (`name`, `client_id`, `file_upload`, `dated`) 
      VALUES
      ('$name', '$client_id', '$file_upload', '$dated');";
        // debug_r($sql);
        $this->sqlq($sql);
        redirect('?action=edit_data&id=' . $client_id);
    }
    function insert_data()
    {
        $client_id = $_REQUEST['client_id'];
        $client_data = $this->check_client_id($client_id);
        $client = $client_data['client'];
        // [client_id] => 1
        // [valuation_points] => 03/10/2023
        $valuation_points = php_to_mysql_date($_REQUEST['valuation_points']);
        // debug_r($valuation_points);
        $total_fund_commitment = $_REQUEST['total_fund_commitment'];
        $assets_under_management = $_REQUEST['assets_under_management'];
        $investor_count = $_REQUEST['investor_count'];
        $holding_position = $_REQUEST['holding_position'];
        $fund_nav = $_REQUEST['fund_nav'];
        $tasi = $_REQUEST['tasi'];
        $sp_500 = $_REQUEST['sp_500'];
        $realized_gain_or_loss = $_REQUEST['realized_gain_or_loss'];
        $dividend_per_share = $_REQUEST['dividend_per_share'];
        //`Valuation Points`, `FUND NAV`, `TASI`, `S&P 500`, `INVESTMENTS`, `CASH & CASH EQUIVALENT`, `OTHER ASSETS`, `Realized Gain/ (Loss)`, `Dividend`, `Dividend per share`, 
        $sql = "INSERT INTO `client_data` (`client_id`, `total_fund_commitment`, `assets_under_management`, `investor_count`, `holding_position`, `valuation_points`,`fund_nav`, `tasi`, `sp_500`, `realized_gain_or_loss`, `dividend_per_share`) 
        VALUES ($client_id, '$total_fund_commitment', '$assets_under_management', '$investor_count', '$holding_position', '$valuation_points', '$fund_nav', '$tasi', '$sp_500', '$realized_gain_or_loss', '$dividend_per_share');";
        $this->sqlq($sql);
        redirect('?action=edit_data&id=' . $client_id);
    }
    
    function get_line_data()
    {
        $infoboxes = ['Total Fund<br>Comittment',  'Assets<br>Under Management',  'Holding<br>Positions',  'Number of<br>Investors'];
        $client_id = $_SESSION["users_id"];
        // $client_id = 1;
        $sql = "select * from client_data where client_id = $client_id";
        // debug_r($sql);
        $result = $this->result($sql);
        // debug_r($result);
        $data = [];
        $data['infobox_headings'] = $infoboxes;
        $data['infobox'] = [];
        $data['dates'] = [];
        $data['client_id'] = [];

        // "01/15/2002", "01/16/2002", "01/17/2002", "01/18/2002", "01/19/2002", "01/20/2002"
        foreach ($result as $i => $a) {
            // debug_r($a);
            $data['dates'][] = mysql_to_php_date3($a['valuation_points']);
            $j = 0;
            $data['infobox'][$j++][$i] = $a['total_fund_commitment'];
            $data['infobox'][$j++][$i] = $a['assets_under_management'];

            $data['infobox'][$j++][$i] = $a['holding_position'];
            $data['infobox'][$j++][$i] = $a['investor_count'];
            //G1 - FUND NAV	TASI	S&P 500
            $data['infobox'][$j++][$i] = $a['fund_nav'];
            $data['infobox'][$j++][$i] = $a['tasi'];
            $data['infobox'][$j++][$i] = $a['sp_500'];
            // debug_r($a);
            //G2 - INVESTMENTS	CASH & CASH EQUIVALENT	OTHER ASSETS
            $data['infobox'][$j++][$i] = round($a['investments']);
            $data['infobox'][$j++][$i] = round($a['cash_and_cash_equivalent']);
            $data['infobox'][$j++][$i] = round($a['other_assets']);
            //G3 - Realized Gain/ (Loss)	| Dividend
            $data['infobox'][$j++][$i] = $a['realized_gain_or_loss'];
            $data['infobox'][$j++][$i] = $a['dividend'];
            // debug($a);
            //G4 - Dividend per share
            $data['infobox'][$j++][$i] = $a['dividend_per_share'];
        }


        $spark_line_data = '';
        $last_data = []; // Initialize last_data array


        if ($data['infobox']) {
            foreach ($infoboxes as $i => $a) {
                $series_data = [];
                foreach ($data['infobox'][$i] as $j => $value) {
                    // Ensure the date format is DD MMM YY for JavaScript processing
                    $date = date("d M y", strtotime($data['dates'][$j]));
                    $series_data[] = '{ x: "' . $date . '", y: ' . $value . ' }';
                }

                $spark_line_data .= '
            var spark' . ($i + 1) . ' = {
                chart: {
                    id: "spark' . ($i + 1) . '",
                    group: "sparks",
                    type: "line",
                    height: 80,
                    sparkline: {
                        enabled: true
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 1,
                        blur: 2,
                        opacity: 0.2
                    }
                },
                series: [{
                    data: [' . implode(',', $series_data) . ']
                }],
                stroke: {
                    curve: "smooth"
                },
                markers: {
                    size: 0
                },
                grid: {
                    padding: {
                        top: 20,
                        bottom: 10,
                        left: 80,
                        right: 50
                    }
                },
                colors: ["#fff"],
                tooltip: {
                    y: {
                        title: {
                            formatter: function(val) {
                                return "";
                            }
                        },
                        formatter: function(val) {
                            return val.toLocaleString(); // Formats number with commas
                        }
                    }
                }
            };';
            }
        }
        $last_index = count($data['infobox'][0]) - 1;
        foreach ($infoboxes as $i => $a) {
            $temp_last_val = update_round($data['infobox'][$i][$last_index]);
            $last_data[] = $temp_last_val;
        }

        $data['last_data'] = $last_data;
        $data['spark_line_data'] = $spark_line_data;

        return $data;
    }

    function show_datacenter()
    {
        $id = $_SESSION['users_id'];
        $temp .= '
    <p></p>
    <div class="row">
        <div class="col">';
        $sql = "select * from data_center where client_id = $id order by dated desc";
        $result = $this->result($sql);
        $temp .= '<table class="table table-bordered">
      <thead>
          <tr>
              <th style="width: 10px">S.No</th>
                <th>Report Date</th>
                <th>Description</th>
                <th>Action</th>
          </tr>
      </thead>
      <tbody>
          ';
        $count = 0;
        foreach ($result as $i => $a) {
            extract($a);
            if (!$file_upload) continue;
            $temp .= '<tr>
    <td>' . ($i + 1) . '</td>
    <td>' . date("F j, Y", mysql_to_timestamp($dated)) . '</td>
    <td>' . $description . '</td>
    <td>
        <a href="' . $file_upload . '">
        <a target="_blank" href="' . $file_upload . '">
          <button type="submit" name="send_message" class="fnc_btn reverses"><span>Download<i class="bx bx-right-arrow-alt"></i></span></button>
        </a>
    </td>
</tr>';
            $count++;
            if ($count >= 4) break;
        }
        $temp .= '
      </tbody>
  </table>';
        if (count($result) > 4) {
            $temp .= '<a href="allfiles"><button type="button"  class="fnc_btn reverses"><span>See All Files<i class="bx bx-right-arrow-alt"></i></span></button></a>';
        }
        return $temp;
    }

    function data_center()
    {
        extract($this->check_client_id());
        $back_url = 'update_data?action=edit_data&id=' . $id;
        $label_main = 'Data Center';
        $action = 'insert_data_center&client_id=' . $id;
        $data_center = $_GET["data_center_id"];

        if ($data_center) {
            $action = 'update_data_center&data_center_id=' . $data_center;
            $prev_data = get_tuple("data_center", $data_center, 'id');
            $label_main = 'Edit Data';
            // Debug previous data if needed
            // debug_r($prev_data);
        } else {
            $prev_data_id = 0;
            $prev_data = []; // Ensure $prev_data is an array to avoid undefined index errors
        }

        $heading = $client['name'] . ' - ';
        //update client monthly data
        //'.($only_edit ? '' : generate_dropdown(["name" => "level_id", "value" => $prev_data["level_id"], 'filter'=> " WHERE programme_id = $programme_id"])).'
        list($temp_head, $temp_dated) = generate_date(['title' => 'Date of Invoice', "name" => "dated", "value" => ($prev_data["dated"] ? $prev_data["dated"] : "")]);
        $head .= $temp_head;
        $temp = '
        <div class="card">
          <div class="card-header">
          <h3 class="card-title">' . $heading . $label_main . '</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="form1" method="post" action="?action=' . $action . '" enctype="multipart/form-data">
            <div class="card-body">
              ' . $temp_dated . '
              <label for="description">Description:</label><br>
                <input type="text" name="description" style="width: 100%;" value="'.$prev_data["description"].'" >
            ' . generate_upload("file_upload", $prev_data["file_upload"]) . '
              
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                <a href="' . $back_url . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
          </form>
      </div>
      <!-- /.card -->';
        
        $sql = "SELECT * FROM data_center where client_id = $id";
        // debug_r($sql);
        $result = $this->result($sql);
        $temp .= ' <h3>Data Center</h3>
        <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . mysql_to_php_date($dated) . '</td>
                <td>' . $name . '</td>
                <td>' . $description . '</td>
                <td>
                    <a href="?action=edit_data_center&data_center_id=' . $id . '&id=' . $client_id . '"><button type="button" class="btn bg-gradient-success">Edit</button></a>
                    <a href="' . $file_upload . '"><button type="button" class="btn bg-gradient-success">Download File</button></a>
                </td>
            </tr>';
        }
        $temp .= '
                </tbody>
            </table>';
        $temp .= '
                </div>
            </div>
            <a href="' . page_name() . '" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
            ';
        return [$head, $temp];
    }

    function email_send()
    {

        // Assuming $this->check_client_id() returns an associative array with 'name' and 'email' keys
        extract($this->check_client_id());
        $client_name = $client['name'];
        $client_email = $client['email']; // Assuming client email is available
        $label_main = 'Data Updated';

        // echo "$client_email";

        $email_body = '
        <div style="font-family: "Times New Roman", Times, serif; line-height: 1.6; color: #000;">
            <h3 style="color: #8b0000;">Dear ' . $client_name . ',</h3>
            <p>I hope this message finds you well.</p>
            <p>We are pleased to inform you that the most recent Net Asset Value (NAV) data for your account has been updated. You can now access these details through your portal. Please log in at your earliest convenience to review the updated information.</p>
            <p><a href="localhost/investor_insight/dash" style="color: #8b0000; text-decoration: none;">Log In to Your Account</a></p>
            <p>If you have any questions or need further assistance, please do not hesitate to reach out to us.</p>
            <p>Sincerely,</p>
            <p><strong>The Investor Insight Team</strong></p>
            <p><a href="localhost/investor_insight" style="color: #8b0000; text-decoration: none;"><b>localhost/investor_insight</b></a></p>
        </div>';

        $to = $client_email;
        $subject = $label_main;

        $msg = email($to, $subject, $email_body);

        if ($msg) {
            redirect('?action=update_data');
        } else {
            redirect('?action=update_data'); // error=1 is a flag to indicate that the email was not sent

        }
    }

    function resend_email()
    {
        // Assuming $this->check_client_id() returns an associative array with 'name' and 'email' keys
        extract($this->check_client_id());
        $client_name = $client['name'];
        $client_email = $client['email']; // Assuming client email is available
        $label_main = 'Data Updated';

        // echo "$client_email";

        $email_body = '
        <div style="font-family: "Times New Roman", Times, serif; line-height: 1.6; color: #000;">
            <h3 style="color: #8b0000;">Dear ' . $client_name . ',</h3>
            <p>I hope this message finds you well.</p>
            <p>I wanted to remind you that the most recent Net Asset Value (NAV) data for your account has been updated. You can access these details through your portal by logging in below.</p>
            <p><a href="https://investor_insight.com/dash" style="color: #8b0000; text-decoration: none;">Log In to Your Account</a></p>
            <p>If you have already reviewed the updated information, please disregard this message. Should you have any questions or need further assistance, feel free to reach out to us.</p>
            <p>Best regards,</p>
            <p><strong>The Investor InsightTeam</strong></p>
            <p><a href="https://investor_insight.com" style="color: #8b0000; text-decoration: none;"><b>https://investor_insight</b></a></p>
        </div>';

        $to = $client_email;
        $subject = $label_main;

        $msg = email($to, $subject, $email_body);

        if ($msg) {
            redirect('?action=update_data');
        } else {
            redirect('?action=update_data'); // error=1 is a flag to indicate that the email was not sent

        }
    }
    function update_data_center()
    {
        $id = $_REQUEST['data_center_id'];
        $description = $_REQUEST['description'];
        $data_center = get_tuple('data_center', $id, 'id');
        $file_upload = upload($_FILES['file_upload'], 'file_upload');
        $dated = php_to_mysql_date($_REQUEST['dated']);
        $sql = "update `data_center`
      set `file_upload` = '$file_upload',
      `dated` = '$dated',`description` = '$description'
      WHERE id = $id";
        // debug_r($sql);
        $this->sqlq($sql);
        alert("Data Center Updated");
        redirect('update_data?action=edit_data&id=' . $data_center['client_id']);
       
    }


    function insert_data_center()
    {
        $client_id = $_REQUEST['client_id'];
        $client_data = $this->check_client_id($client_id);
        $client = $client_data['client'];
        $name = $client['name'];
        $description = $_REQUEST['description'];
        $file_upload = upload($_FILES['file_upload'], 'file_upload');
        $dated = php_to_mysql_date($_REQUEST['dated']);
        $sql = "INSERT INTO `data_center`(`name`, `client_id`, `description`, `file_upload`, `dated`) 
      VALUES ('$name','$client_id','$description','$file_upload','$dated')";
        // debug_r($sql);
        $this->sqlq($sql);
        redirect('?action=edit-data&id=' . $client_id);
    }
    function show_allfiles()
    {
        $id = $_SESSION['users_id'];
        // debug_r($_SESSION);
        $temp .= '
            <style>
            #myTable{
            width: 1100px;
            display: block; 
            height: 500px;
            overflow-y: auto;

            }
            table {
                        width: 50%;
                        border-collapse: collapse;
                        margin: 25px 0;
                        font-size: 18px;
                        text-align: left;
                    }
                    th, td {
                        padding: 12px;
                        border: 1px solid #ddd;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    tr:hover {
                        background-color: #f5f5f5;
                    }
            table thead{
            position: sticky;
            top: 0;
                background-color: #f0f0f0;
                z-index: 1;
                text-align: center;
            }

            </style>


        <p></p>
        <div class="row">
            <div class="col">';
        $sql = "select * from data_center where client_id = $id order by dated desc";
        $result = $this->result($sql);
        $temp .= '    <label for="" style="font-size: 20px;font-weight: bold; color:black;" class="container-fluid">
                      <input type="search" id="searchBar" class="form-control" placeholder="Search......">
                  </label>
      <table class="table" id="myTable">
            <thead style="">
              <tr>
                <th scope="col" style="width: 50px">S.No</th>
                <th scope="col" style="width: 350px" >Report Date</th>
                <th scope="col" style="width: 350px" >Description</th>
                <th scope="col" style="width: 350px ">Action</th>
              </tr>
            </thead>
            <tbody style="text-align: center;">
                ';
        foreach ($result as $i => $a) {
            // debug_r($a);
            extract($a);
            if (!$file_upload) continue;

            $temp .= '<tr >
                          <td>' . ($i + 1) . '</td>
                          <td>' . date("F j, Y", mysql_to_timestamp($dated)) . '</td>
                          <td>' . $description . '</td>
                          
                          <td>
                              <a href="' . $file_upload . '">
                              <a target="_blank" href="' . $file_upload . '">
                                <button type="submit" name="send_message" class="fnc_btn reverses"><span>Download<i class="bx bx-right-arrow-alt"></i></span></button>
                              </a>
                          </td>
                      </tr>';
        }
        $temp .= '
            </tbody>
        </table>
        <button onclick="goBack()" class="fnc_btn reverses"><span>Back<i class="bx bx-left-arrow-alt"></i></span></button>
       <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
   <script>
   function goBack() {
  window.history.back();
}
   $("#searchBar").keyup(function() {

       let searchText = $(this).val().toLowerCase()

       $("tbody tr").filter(function() {

           let tbody = $(this).text().toLowerCase()

           if (tbody.indexOf(searchText) > -1) {
               $(this).show()
           } else {
               $(this).hide()
           }
       })

   })
</script>';
        return $temp;
    }
    function clients_files()
    {

        $sql = "SELECT cf.*, c.name AS client_name 
        FROM client_file cf
        INNER JOIN client c ON cf.added_by_id = c.id";
        $result = $this->result($sql);
        $temp = '<table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Client_name</th>
                    <th>File Decription</th>
                    <th>File Path</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ';
        foreach ($result as $i => $a) {
            extract($a);
            $temp .= '<tr>
            <td>' . ($i + 1) . '</td>
            <td>' . $client_name . '</td>
            <td>' . $name . '</td>
            <td>' . $file_path . '</td>
            <td>
                <a href="' . $file_path . '"><button type="button" class="btn bg-gradient-success">Download File</button></a>
            </td>
        </tr>';
        }
        $temp .= '
            </tbody>
        </table>';
        return wrap($temp, 'Download File');
    }
}
function update_round($val, $return_type = 1)
{
    //$return_type = 1  With Symbols
    //$return_type = 1  Without Symbols
    //$return_type = 1  With Symbols as array
    $symbol = '';
    if ($val / 1000000 > 1) {
        $val = round($val / 1000000, 2);
        $symbol = 'M';
    } elseif ($val / 1000 > 1) {
        $val = round($val / 1000, 2);
        $symbol = 'K';
    } elseif ($val / 100 > 1) {
        // $val = round($val/100, 2) .' H';
    }
    if ($return_type == 1) return $val . '' . $symbol;
    if ($return_type == 2) return $val;
    return [$symbol, $val];
}
