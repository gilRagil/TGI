<?php 
  error_reporting('~Notice');
	session_start();
  $target="1";
  require_once("controllers/class.CtrlGlobal.php");
  $objCtrl = new CtrlGlobal();	
  if($_GET['msg'] != "") $msg = $_GET['msg'];
  else $msg = "";

  if($_GET['x']=="out") {
    unset($_SESSION['username']);
    unset($_SESSION['level']);		
    session_destroy();
  }else if($_SESSION['username'] != "")
  {
    header("Location: http://".$_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],"/")+1)."views/dashboard.php");
  }else{
    if(isset($_POST['username'])) {
      $sql="select e.*, l.level_name from employees e, level l where l.level_id = e.level_id AND e.username='".$_POST['username']."'";
      $row=$objCtrl->GetGlobalFilter($sql);
      if(sizeof($row)==0) {
        $msg="Username tidak tersedia!";
      } else {
        foreach($row as $item){
          if(password_verify($_POST['password'],$item['password'])){
            require_once("function_logout.php");
            echo $item['password'];
			      session_start();	
            $_SESSION['employees_id'] = $item['employees_id'];
            $_SESSION['full_name'] = $item['full_name'];
            $_SESSION['level_name'] = $item['level_name'];
            $_SESSION['photo'] = $item['photo'];
            $_SESSION['gender'] = $item['gender'];
            $_SESSION['religion'] = $item['religion'];
            $_SESSION['nik'] = $item['nik'];
            $_SESSION['address'] = $item['address'];
            $_SESSION['level_id'] = $item['level_id'];
            $_SESSION['contract_start_date'] = $item['contract_start_date'];
            $_SESSION['mobile_phone'] = $item['mobile_phone'];
            $_SESSION['username'] = $item['username'];
            $_SESSION['email_office'] = $item['email_office'];
            $_SESSION['email_personal'] = $item['email_personal'];
            $_SESSION['folder']=substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
            login_validate();
			      header("Location: http://".$_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],"/")+1)."views/dashboard.php");
          }else {
            $msg="Password kurang tepat!";
          }
        }
      }
    }
  }
  $sql = "SELECT * FROM company_info";
  $row = $objCtrl->GetGlobalFilter($sql);
  foreach($row as $item){
    session_start();
    $_SESSION['app_name'] = $item['app_name'];
    $_SESSION['company_name'] = $item['company_name'];
    $_SESSION['office_building'] = $item['office_building'];
    $_SESSION['address'] = $item['address'];
    $_SESSION['city'] = $item['city'];
    $_SESSION['post'] = $item['post'];
    $_SESSION['country'] = $item['country'];
    $_SESSION['phone'] = $item['phone'];
    $_SESSION['fax'] = $item['fax'];
    $_SESSION['npwp'] = $item['npwp'];
    $_SESSION['pkp'] = $item['pkp'];
    $_SESSION['logo'] = $item['logo'];
    $_SESSION['signature_1'] = $item['signature_1'];
    $_SESSION['signature_2'] = $item['signature_2'];
    $_SESSION['signature_3'] = $item['signature_3'];
    $_SESSION['update_time'] = $item['update_time'];
    $_SESSION['foto_signature_1'] = $item['foto_signature_1'];
    $_SESSION['foto_signature_2'] = $item['foto_signature_2'];
    $_SESSION['foto_signature_3'] = $item['foto_signature_3'];
    $_SESSION['app_icon'] = $item['app_icon'];
    $_SESSION['app_logo'] = $item['app_logo'];
    $_SESSION['app_title'] = $item['app_title'];
    $_SESSION['app_motto'] = $item['app_motto'];
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $_SESSION['app_title']; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700"> -->
    <link rel="stylesheet" href="css/fontgoogle.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/<?php echo $_SESSION['app_logo']; ?>">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1><?php echo $_SESSION['app_name']; ?></h1>
                  </div>
                  <p><?php echo $_SESSION['app_motto']; ?></p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div id="login" class="col-lg-6 bg-white">
            <?php if($msg != ""){ ?>
              <div class="alert alert-success text-center" v-if="successMessage">
                <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                <span class="glyphicon glyphicon-check"></span> <?php echo $msg; ?>
              </div>
            <?php } ?>
              <form method="post" id="bookform" name="bookform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form d-flex align-items-center">
                  <div class="content">
                      <div class="form-group">
                        <input id="username" type="text" name="username" required="" class="input-material" >
                        <label for="login-username" class="label-material">User Name</label>
                      </div>
                      <div class="form-group">
                        <input id="password" type="password" name="password" required="" class="input-material" >
                        <label for="login-password" class="label-material">Password</label>
                      </div><button id="login" class="btn btn-primary" type="submit">Login</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <!-- Javascript files-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
  </body>
</html>
