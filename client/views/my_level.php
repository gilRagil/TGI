<?php 
    include "header.php";
    error_reporting('~Notice');
	$target = 2;
	require_once("../controllers/class.CtrlGlobal.php");
	$objCtrl = new CtrlGlobal();
	
	if ($_POST['act']=="")  $act = $_GET['act'];
	else $act = $_POST['act'];
	
	if ($_POST['level_id']=="")  $level_id = $_GET['x'];
	else $level_id = $_POST['level_id']; 
	if ($_POST['level_name']=="")  $level_name = $_GET['nama'];
	else $level_name = $_POST['level_name']; 
	if(!isset($act)) $act="find";

	$menu_name=$_POST['menu_name'];
	$nama_perk=$_POST['nama_perk'];
	$menu_id=$_POST['menu_id'];
	
	if($act=="save") {
		$objCtrl->delete('menu_level', array('level_id' => $level_id));
		$sql="select menu_header_name,c.menu_header_id,menu_id,menu_name ";
		$sql.=" from menu_header h,menu_child c  where h.menu_header_id=c.menu_header_id ";
		
		if($menu_name!="")
			$sql.=" AND menu_name like '%".$menu_name."%' ";
			
		$sql.=" order by c.menu_id ";	
		$row=$objCtrl->GetGlobalFilter($sql);
		$temp_menu="";
		$view_menu="";
		$edit_menu="";
		$del_menu="";
		foreach($row as $item):
			$temp_menu=$_POST['check'.$item['menu_id']];
			$view_menu=$_POST['view'.$item['menu_id']];
			$edit_menu=$_POST['edit'.$item['menu_id']];
			$del_menu=$_POST['del'.$item['menu_id']];
			if (isset($_POST['view'.$item['menu_id']])) {
				$view = "1";
			}else {
				$view = "0";
			}if (isset($_POST['edit'.$item['menu_id']])) {
				$edit = "1";
			}else {
				$edit = "0";
			}if (isset($_POST['del'.$item['menu_id']])) {
				$del = "1";
			}else {
				$del = "0";
			}
			if($temp_menu!="" || $view_menu!="" || $edit_menu!="" || $del_menu!="" || $level_id!="")
				$objCtrl->insert('menu_level', array('level_id' => $level_id,'menu_header_id' => $item['menu_header_id'],'menu_id' => $temp_menu,'view' => $view,'edit' => $edit,'del' => $del));
		endforeach;
		$msg="Edit Succeed ";
		$act="find";
	}
	
	if($act=="find") {
		$sql="select menu_header_name,c.menu_header_id,menu_id,menu_name, ";
		 $sql.=" (select l.view from menu_level l where l.menu_id=c.menu_id and l.level_id='".$level_id."') as view, ";
		 $sql.=" (select l.edit from menu_level l where l.menu_id=c.menu_id and l.level_id='".$level_id."') as edit, ";
		 $sql.=" (select l.del from menu_level l where l.menu_id=c.menu_id and l.level_id='".$level_id."') as del, ";
		 $sql.=" (select l.menu_id from menu_level l where l.menu_id=c.menu_id and l.level_id='".$level_id."') as menu_set ";
		$sql.=" from menu_header h,menu_child c  where h.menu_header_id=c.menu_header_id ";
		
		if($menu_name!="")
			$sql.=" AND menu_name like '%".$menu_name."%' ";
			
        $sql.=" order by menu_header_name "; 
		$row=$objCtrl->GetGlobalFilter($sql);
	}
?>
            <div class="content-inner" style="width:100%;" id="app">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">Setting Menu Level</h2>
                    </div>
                </header>
                <!-- Dashboard Cards Section -->
                <section class="dashboard-counts no-padding-bottom">
                    <?php
                        if($msg != '') {
                    ?>
                    <div id="notif-success" class="alert alert-success">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong><?php echo $msg; ?></strong>
                    </div>
                    <?php
                        }
                    ?>
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="frm_trans" name="frm_trans" class="form-horizontal">
                        <input type="text" id="menu_name_s" name="menu_name_s" class="form-control" value="<?php echo $menu_name_s;?>" />
                        <input type="hidden" id="level_id" name="level_id" class="form-control" value="<?php echo $level_id;?>" />
                        <input type="hidden" id="level_name" name="level_name" class="form-control" value="<?php echo $level_name;?>" />
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="25%">Header Menu</th>
                                                    <th width="25%">Sub Menu</th>
                                                    <th width="10%">Setting</th>
                                                    <th width="10%" >View</th>
                                                    <th width="10%">Edit</th>
                                                    <th width="10%">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $no=0;
                                                $temp="";
                                                foreach($row as $item):
                                                    $print_h=$item['menu_header_name'];
                                                    if($temp==$item['menu_header_name'])
                                                    	$print_h=""; 
                                            ?>
                                                <tr>
													<td align='left'><strong><?php echo $print_h; ?></strong></td>
													<td align='left'><?php echo $item['menu_name']; ?></td>
													<td align='center'>
                                                        <div class="i-checks">
                                                            <input checked="checked" name="check<?php echo $item['menu_id']; ?>" id="check<?php echo $item['menu_id']; ?>" value="<?php echo $item['menu_id']; ?>" type="checkbox" <?php if($item['menu_id'] == $item['menu_set'] ) echo "checked"; else echo ""; ?> class="checkbox-template" />
                                                        </div>
                                                    </td>
													<td>
                                                        <div class="i-checks">
                                                            <input checked="checked" name="view<?php echo $item['menu_id']; ?>" id="view<?php echo $item['menu_id']; ?>" value="<?php echo $item['menu_id']; ?>" type="checkbox"<?php if($item['view'] == "1" ) echo "checked"; else echo ""; ?> class="checkbox-template" />
														</div>  
                                                    </td>
                                                    <td>  
														<div class="i-checks">
                                                            <input checked="checked" name="edit<?php echo $item['menu_id']; ?>" id="edit<?php echo $item['menu_id']; ?>" value="<?php echo $item['menu_id']; ?>" type="checkbox"<?php if($item['edit'] == "1" ) echo "checked"; else echo ""; ?> class="checkbox-template" />
                                                        </div> 
                                                    </td>
                                                    <td>  
														<div class="i-checks">
                                                            <input checked="checked" name="del<?php echo $item['menu_id']; ?>" id="del<?php echo $item['menu_id']; ?>" value="<?php echo $item['menu_id']; ?>" type="checkbox"<?php if($item['del'] == "1" ) echo "checked"; else echo ""; ?> class="checkbox-template" />
                                                        </div>    
													</td>
												</tr>
                                            <?php 
                                                $temp=$item['menu_header_name'];
                                                $no++;
                                                endforeach;
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    
                                    <div class="col-lg-12" align="right">
                                        <button id="btn-submit" type="button" onclick="record();" class="btn btn-primary mr5">Submit</button>
                                        <input type="hidden" name="act" value="<?php echo $act;?>" />
                                        <input type="hidden" name="next" value="<?php echo $next;?>" />
                                        <button id="btn-cancel" type="button" onclick="cancelcek();" class="btn btn-default">Cancel</button>
                                    </div>
                                </div><!-- panel-footer -->
                            </div>
                        </div>
                    </form>
                </section>
                <!-- Feeds Section-->

                <!-- Page Footer-->
                <footer class="main-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Rumah Koding&copy; 2017</p>
                            </div>
                            <div class="col-sm-6 text-right">
                                <p>Created With Bismillah</p>
                                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- Javascript files-->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../vendor/popper.js/umd/popper.min.js"> </script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="../vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script>

			var shortcut = document.frm_trans;
       function record(){
            shortcut.act.value="save";
            shortcut.submit();
        }
        
        function find(){
            shortcut.act.value="find";
            shortcut.submit();	
        }
        
        function cancelcek(){
            window.opener.document.bookform.submit();
            window.close();
        }

    </script>
</body>
                              
</html>
<?php
	function killVars(){
		unset($_SESSION['uid']);
		unset($_POST);
	}
	$vars = array_keys(get_defined_vars());
		foreach($vars as $var) {
			if($var == '_SESSION' || $var == 'GLOBALS' || $var == '_POST' || $var == '_GET' || $var == '_COOKIE' || $var == '_FILES' || $var == '_REQUEST' || $var == '_SERVER' || $var == '_ENV')
				continue;
			unset($$var);
	}
?>