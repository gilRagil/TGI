 <?php 
    $target=2;
	require_once("../controllers/class.CtrlGlobal.php");
	$objCtrl = new CtrlGlobal();
    if($_SESSION['photo'] == "") $photo = "not_found.png";
        else $photo = $_SESSION['photo'];
 ?>
 <!-- Side Navbar -->
 <nav class="side-navbar">
 <!-- Sidebar Header-->
 <div class="sidebar-header d-flex align-items-center">
     <div class="avatar">
         <img src="../img/employee_photo/<?php echo $photo; ?>" style="width:50px;height:50px;" class="img-fluid rounded-circle">
     </div>
     <div class="title">
         <h1 class="h4"><?php echo $_SESSION['full_name']; ?></h1>
         <p><?php echo $_SESSION['level_name']; ?></p>
     </div>
 </div>
 <!-- Sidebar Navidation Menus-->
 <span class="heading">Main</span>
 <ul class="list-unstyled">
     <li class="active">
         <a href="dashboard.php">
             <i class="icon-home"></i>Dashboard </a>
     </li>
     <?php
        $sql ="select class_icon, menu_header_name,l.menu_header_id ";
        $sql.=" from menu_header h,menu_level l  where h.menu_header_id=l.menu_header_id  ";
        $sql.=' and level_id ="'.$_SESSION['level_id'].'"';	
        $sql.=" group by l.menu_header_id order by l.menu_header_id ";	
        $row=$objCtrl->GetGlobalFilter($sql);
        $baris = "";
        foreach($row as $item):
            $sql="select l.menu_id,c.menu_name,c.file_php ";
            $sql.=" from menu_child c,menu_level l where l.menu_id=c.menu_id ";
            $sql.=" and level_id  ='".$_SESSION['level_id']."' and l.menu_header_id=".$item['menu_header_id'];	
            $sql.=" order by c.menu_id ";	
            $row2=$objCtrl->GetGlobalFilter($sql);
            
            if(sizeof($row2) > 0) {
                $baris.= '<li>
                    <a href="#menu'.$item['menu_header_id'].'" aria-expanded="false" data-toggle="collapse">
                        <i class="'.$item['class_icon'].'"></i>'.$item['menu_header_name'].' </a>
                        <ul id="menu'.$item['menu_header_id'].'" class="collapse list-unstyled ">';
                
                foreach($row2 as $item2):
                    $baris.= '<li><a href="'.$item2['file_php'].'">'.$item2['menu_name'].'</a></li>';
                endforeach;
                
                $baris.= '</ul>';
            }
        
                $baris.= '</li>';
        endforeach;
        echo $baris;
    ?>
    
 </ul>
</nav>