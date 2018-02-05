<?php
    error_reporting(0);
	session_start();
    $target = 1;
    require_once("controllers/class.CtrlGlobal.php");
    $objCtrl = new CtrlGlobal();
    //Params Global
        if($_GET['act'] == "") $act = $_POST['act'];
        else $act = $_GET['act'];
        if($_GET['id'] == "") $id = $_POST['id'];
        else $id = $_GET['id'];
        if($_GET['paramsSearch'] == "") $paramsSearch = $_POST['paramsSearch'];
        else $paramsSearch = $_GET['paramsSearch'];
        if($_GET['fromDate'] == "") $fromDate = $_POST['fromDate'];
        else $fromDate = $_GET['fromDate'];
        $temp=explode('-', $fromDate);
        $fromDate=$temp[0].$temp[1].$temp[2];
        if($_GET['untilDate'] == "") $untilDate = $_POST['untilDate'];
        else $untilDate = $_GET['untilDate'];
        $temp=explode('-', $untilDate);
        $untilDate=$temp[0].$temp[1].$temp[2];
    //END Global
    if($_SESSION['username'] !=""){
        switch ($act) {
            //INFO
            case 'getAppName':
                $sql = "SELECT app_name, app_motto FROM company_info";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            case 'handleIdentity':
                $row = array('full_name' => 'Arif Ragil','level_name' => 'Software Developer','photo' => 'pp.jpg');
                echo json_encode($row);
                break;
            case 'handleLeftmenu':
                echo json_encode($row);
                break;
            case 'cekMenu':
                $sql = "SELECT view, edit, del FROM menu_level WHERE level_id = '".$_SESSION['level_id']."' AND menu_id = '".$id."'";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            //END INFO
            //MASTER
            case 'selectLevel':
                $sql = "SELECT level_id, level_name FROM level";
                if($paramsSearch != ""){ 
                    $sql.="  WHERE level_name LIKE '%".$paramsSearch."%'";
                }
                $sql.="  order by level_id desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            case 'insertLevel':
                $objCtrl->insert('level',array(
                    'level_id' => $objCtrl->getGlobalID('LVL','level_id','level'), 
                    'level_name' => $_GET['level_name']
                ));
                $sql = "SELECT * FROM level order by level_id desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            case 'selectCurrency':
                $sql = "SELECT currency_code, currency_name FROM currency";
                if($paramsSearch != ""){ 
                    $sql.="  WHERE currency_name LIKE '%".$paramsSearch."%'";
                }
                $sql.="  order by currency_code desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            case 'insertCurrency':
                $objCtrl->insert('currency',array(
                    'currency_code' => $_GET['currency_de'], 
                    'currency_name' => $_GET['currency_name']
                ));
                $sql = "SELECT * FROM level order by level_id desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            //Employee
            case 'selectEmployee':
                $sql = "SELECT `employees_id`, `full_name`, `photo`, `gender`, `religion`, `nik`, `address`, e. `level_id`, `contract_start_date`, `mobile_phone`, `username`, `email_office`, `email_personal`,  l.level_name FROM employees e, level l WHERE e.level_id = l.level_id ";
                if($paramsSearch != ""){ 
                    $sql.="  AND e.nik LIKE '%".$paramsSearch."%' or nama LIKE '%".$paramsSearch."%' or level_name LIKE '%".$paramsSearch."%'";
                }
                $sql.= " order by employees_id desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                mysqli_close($con);
                break;
            case 'insertEmployee':
                $objCtrl->insert('employees',array(
                    'employees_id' => $objCtrl->getGlobalID('EMP','employees_id','employees'), 
                    'full_name' => $_GET['full_name'], 
                    'username' => $_GET['username'], 
                    'password' => password_hash($_GET['password'], PASSWORD_DEFAULT),
                    'photo' => $_GET['photo'], 
                    'gender' => $_GET['gender'], 
                    'religion' => $_GET['religion'], 
                    'nik' => $_GET['nik'], 
                    'address' => $_GET['address'], 
                    'level_id' => $_GET['level_id'], 
                    'contract_start_date' => $_GET['contract_start_date'], 
                    'mobile_phone' => $_GET['mobile_phone'], 
                    'email_office' => $_GET['email_office'], 
                    'email_personal' => $_GET['email_personal'], 
                    'entry_by' => $_SESSION['employees_id'], 
                    'entry_date' => $_GET['entry_date']
                ));
                $sql = "SELECT `employees_id`, `full_name`, `photo`, `gender`, `religion`, `nik`, `address`, e. `level_id`, `contract_start_date`, `mobile_phone`, `username`, `email_office`, `email_personal`,  l.level_name FROM employees e, level l WHERE e.level_id = l.level_id  order by employees_id desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            case 'editEmployee':
                $max_id = $objCtrl->getGlobalID('EMP','employees_id','employees');
                $objCtrl->update('employees',array(
                    'employees_id' => $max_id, 
                    'full_name' => $_GET['full_name'], 
                    'username' => $_GET['username'], 
                    'photo' => $_GET['photo'], 
                    'gender' => $_GET['gender'], 
                    'religion' => $_GET['religion'], 
                    'nik' => $_GET['nik'], 
                    'address' => $_GET['address'], 
                    'level_id' => $_GET['level_id'], 
                    'contract_start_date' => $_GET['contract_start_date'], 
                    'mobile_phone' => $_GET['mobile_phone'], 
                    'email_office' => $_GET['email_office'], 
                    'email_personal' => $_GET['email_personal'], 
                    'entry_by' => $_SESSION['employees_id'], 
                    'entry_date' => $_GET['entry_date']
                ),array('employees_id' => $_GET['xid']));
                if($_GET['password'] !=""){
                    $objCtrl->update('employees',array(
                        'password' => password_hash($_GET['password'], PASSWORD_DEFAULT)
                    ),array('employees_id' => $max_id));
                }
                $sql = "SELECT `employees_id`, `full_name`, `photo`, `gender`, `religion`, `nik`, `address`, e. `level_id`, `contract_start_date`, `mobile_phone`, `username`, `email_office`, `email_personal`,  l.level_name FROM employees e, level l WHERE e.level_id = l.level_id  order by employees_id desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            //Supplier
            case 'selectDataSupp':
                $sql = "SELECT * FROM supplier";
                if($paramsSearch != ""){ 
                    $sql.="  AND supplier_name LIKE '%".$paramsSearch."%' or supplier_address LIKE '%".$paramsSearch."%' or tgl_transaksi LIKE '%".$paramsSearch."%'";
                }
                if($fromDate != ""){
                    $sql.= " AND DATE_FORMAT(create_time,'%Y%m%d') >= '".$fromDate."' AND DATE_FORMAT(create_time, '%Y%m%d') <= '".$untilDate."'";
                }
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            case 'insertDataSupp':
                $objCtrl->insert('supplier', array(
                    'supplier_id' => $objCtrl->getNoTransID('SUP','supplier_id','supplier'),
                    'supplier_name' => $_POST['nama_customer'],
                    'supplier_addres' => $_POST['alamat_customer'],
                    'supplier_phone' => $_POST['telepon_customer'],
                    'del' => $_POST['telepon_customer'],
                    'create_time' => $_POST['telepon_customer'],
                    'update_time' => $_POST['telepon_customer']
                ));
                break;
            //Customer
            case 'selectDataCust':
                $sql = "SELECT *, if(tax_status = '2','Non Tax',if(tax_status = '0','Exclude','Include')) as tax_status, if(pkp_status = '0','Non PKP','PKP') as pkp_status FROM customer c WHERE 1=1 ";
                if($paramsSearch != ""){ 
                    $sql.="  AND customer_name LIKE '%".$paramsSearch."%' or address LIKE '%".$paramsSearch."%' or tax_status LIKE '%".$paramsSearch."%' or pkp_status LIKE '%".$paramsSearch."%' or phone LIKE '%".$paramsSearch."%'";
                }
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            case 'insertDataCust':
                $objCtrl->insert('customer', array(
                    'customer_id' => $objCtrl->getNoTransID('CUS','customer_id','customer'),
                    'customer_name' => $_GET['customer_name'],
                    'address' => $_GET['address'],
                    'address_shipping' => $_GET['address_shipping'],
                    'city' => $_GET['city'],
                    'country' => $_GET['country'],
                    'phone' => $_GET['phone'],
                    'email' => $_GET['email'],
                    'npwp' => $_GET['npwp'],
                    'tax_status' => $_GET['tax_status'],
                    'pkp_status' => $_GET['pkp_status'],
                    'currency_code' => $_GET['currency_code']
                ));
                $sql = "SELECT c.*, if(tax_status = '2','Non Tax',if(tax_status = '0','Exclude','Include')) as tax_status, if(pkp_status = '0','Non PKP','PKP') as pkp_status FROM customer c order by customer_id desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            case 'editDataCust':
                $objCtrl->update('customer', array(
                    'customer_name' => $_GET['customer_name'],
                    'address' => $_GET['address'],
                    'address_shipping' => $_GET['address_shipping'],
                    'city' => $_GET['city'],
                    'country' => $_GET['country'],
                    'phone' => $_GET['phone'],
                    'email' => $_GET['email'],
                    'npwp' => $_GET['npwp'],
                    'tax_status' => $_GET['tax_status'],
                    'pkp_status' => $_GET['pkp_status'],
                    'currency_code' => $_GET['currency_code']
                ),array('customer_id' => $_GET['xid']));
                $sql = "SELECT c.*, if(tax_status = '2','Non Tax',if(tax_status = '0','Exclude','Include')) as tax_status, if(pkp_status = '0','Non PKP','PKP') as pkp_status FROM customer c order by customer_id desc";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            //Item
            case 'selectItem':
                $sql="SELECT concat(kode_customer, nama_customer, alamat_customer) as name FROM customer WHERE id<='".$_POST['id1']."' id<='".$_POST['id2']."'";
                $row = $objCtrl->getName($sql);
                echo $row;
                break;
        
            case 'updateData':
                $objCtrl->update('customer', array(
                    'kode_customer' => $objCtrl->getNoTransID('PRD','kode_customer','customer'),
                    'nama_customer' => $_POST['nama_customer'],
                    'alamat_customer' => $_POST['alamat_customer'],
                    'telepon_customer' => $_POST['telepon_customer'],
                ), array('id_item' => $_POST['id_customer']));
                break;

            ////DELETE/////
            case 'DeleteEvent':
                $table = $_GET['table'];
                $primary_id = $_GET['primary_id'];
                $id = $_GET['id'];
                $objCtrl->delete($table, array(
                    $primary_id => $id
                ));
                break;
            ////View/////
            case 'ViewEvent':
                $table = $_GET['table'];
                $primary_id = $_GET['primary_id'];
                $id = $_GET['id'];
                $sql = "SELECT * FROM $table WHERE $primary_id = '".$id."'";
                $row = $objCtrl->GetGlobalFilter($sql);
                echo json_encode($row);
                break;
            default:
                # code...
                break;
        }
    }
?>