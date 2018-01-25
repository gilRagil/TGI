<?php
    error_reporting(0);
	session_start();
    $target = 1;
    require_once("controllers/class.CtrlGlobal.php");
    $objCtrl = new CtrlGlobal();
    if($_GET['act'] == "") $act = $_POST['act'];
    else $act = $_GET['act'];
    if($_GET['xid'] == "") $xid = $_POST['xid'];
    else $xid = $_GET['xid'];

    switch ($act) {
        case 'selectLevel':
            $sql = "SELECT level_id, level_name FROM level";
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
            // echo '[{"employees_id":"EMP0128","full_name":"Ntabs","photo":"","gender":"","religion":"","nik":"","address":"","level":"","contract_start_date":"0000-00-00","mobile_phone":"","email_office":"","email_personal":"","entry_by":"","entry_date":"0000-00-00 00:00:00","update_by":"","update_date":"0000-00-00 00:00:00"}]';
            $sql = "SELECT * FROM employees order by employees_id desc";
            $row = $objCtrl->GetGlobalFilter($sql);
            echo json_encode($row);
            break;
        case 'selectDataSupp':
            $sql = "SELECT * FROM supplier";
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
        case 'deleteData':
            $objCtrl->delete('customer', array(
                'nama_customer' => $_POST['nama'],
            ));
        case 'updateData':
            $objCtrl->update('customer', array(
                'kode_customer' => $objCtrl->getNoTransID('PRD','kode_customer','customer'),
                'nama_customer' => $_POST['nama_customer'],
                'alamat_customer' => $_POST['alamat_customer'],
                'telepon_customer' => $_POST['telepon_customer'],
            ), array('id_item' => $_POST['id_customer']));
            break;
    	default:
    		# code...
    		break;
    }
?>