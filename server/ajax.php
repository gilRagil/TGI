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

        case 'selectEmployee':
            $sql = "SELECT * FROM employees order by employees_id desc";
            $row = $objCtrl->GetGlobalFilter($sql);
            echo json_encode($row);
            break;
        case 'insertEmployee':
            $objCtrl->insert('employees',array(
                'employees_id' => $objCtrl->getGlobalID('EMP','employees_id','employees'), 
                'full_name' => $_GET['full_name'], 
                'photo' => $_GET['photo'], 
                'gender' => $_GET['gender'], 
                'religion' => $_GET['religion'], 
                'nik' => $_GET['nik'], 
                'address' => $_GET['address'], 
                'level' => $_GET['level'], 
                'contract_start_date' => $_GET['contract_start_date'], 
                'mobile_phone' => $_GET['mobile_phone'], 
                'email_office' => $_GET['email_office'], 
                'email_personal' => $_GET['email_personal'], 
                'entry_by' => $_SESSION['employees_id'], 
                'entry_date' => $_GET['entry_date']
            ));
            $sql = "SELECT * FROM employees order by employees_id desc";
            $row = $objCtrl->GetGlobalFilter($sql);
            echo json_encode($row);
            break;
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
    	default:
    		# code...
    		break;
    }
?>