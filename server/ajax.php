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
        // supplier 
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