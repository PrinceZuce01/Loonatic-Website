<?php
  include_once 'staffs_crud.php';
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Loonatic Ordering System : Staffs</title>
  <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <?php include_once 'nav_bar.php'; ?>


  <div class="container-fluid">
    <?php
  if(isset($_SESSION['userlevel']) && $_SESSION['userlevel'] === "Admin") {
  }
  ?>
    <div class="col-xs-16 text-center">
  <br>
    <img src="loona.jpg" width="20%" height="20%">
</div>
    <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2>Insert New Staff</h2>
      </div>
      <div class="form-horizontal">

    <form action="staffs.php" method="post">
      <div class="form-group">
          <label for="staffid" class="col-sm-3 control-label">Staff ID</label>
          <div class="col-sm-9">

      
      <input name="sid" type="text" class="form-control" id="staffid" placeholder="Staff ID" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_num']; ?>"required> </div>
      </div>

      <div class="form-group">
          <label for="staffname" class="col-sm-3 control-label">Staff Name</label>
          <div class="col-sm-9">
      
      <input name="name" type="text" class="form-control" id="staffname" placeholder="Staff Name" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_name']; ?>"> </div>
      </div>

      <div class="form-group">
          <label for="staffdept" class="col-sm-3 control-label">Staff Department</label>
          <div class="col-sm-9">
      
       <select name="department" class="form-control" id="staffdept" placeholder="Staff Department" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_department']; ?>"required>
        <option value="">Please select</option>
        <option value="Cashier" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_department']=="Cashier") echo "selected"; ?>>Cashier</option>
        <option value="Promoter" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_department']=="Promoter") echo "selected"; ?>>Promoter</option>
        <option value="Stock Manager" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_department']=="Stock Manager") echo "selected"; ?>>Stock Manager</option>
        <option value="Sales Representative" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_department']=="Sales Representative") echo "selected"; ?>>Sales Representative</option>
      </select> </div>
      </div>

      <div class="form-group">
          <label for="staffstat" class="col-sm-3 control-label">Staff Status</label>
          <div class="col-sm-9">
      
       <select name="status" class="form-control" id="staffstat" placeholder="Staff Status" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_status']; ?>"required>
        <option value="">Please select</option>
        <option value="Full Time" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_status']=="Full Time") echo "selected"; ?>>Full Time</option>
        <option value="Part Time" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_status']=="Part Time") echo "selected"; ?>>Part Time</option>
       </select> </div>
      </div>

       <div class="form-group">
          <label for="staffphone" class="col-sm-3 control-label">Phone Number</label>
          <div class="col-sm-9">
      
      <input name="phone" type="text" class="form-control" id="staffphone" placeholder="Phone Number" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_phone']; ?>"> </div>
      </div>


      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
          <?php if (isset($_GET['edit'])) { ?>
          <input type="hidden" name="oldsid" value="<?php echo $editrow['fld_staff_num']; ?>">
          <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
          <?php } else { ?>
          <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</button>
          <?php } ?>
          <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
        </div>
      </div>
    </form>
    </div>
     </div>
</div>


    <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <div class="page-header">
        <h2>Staff List</h2>
      </div>
      <table class="table table-striped table-bordered">

      <tr>
        <td>Staff ID</td>
        <td>Staff Name</td>
        <td>Staff Department</td>
        <td>Staff Status</td>
        <td>Phone Number</td>
        <td></td>
      </tr>
      <?php
      // Read
      $per_page = 4;
      if (isset($_GET["page"]))
        $page = $_GET["page"];
      else
        $page = 1;
      $start_from = ($page-1) * $per_page;

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a181676_pt2 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>
      <tr>
        <td><?php echo $readrow['fld_staff_num']; ?></td>
        <td><?php echo $readrow['fld_staff_name']; ?></td>
        <td><?php echo $readrow['fld_staff_department']; ?></td>
        <td><?php echo $readrow['fld_staff_status']; ?></td>
        <td><?php echo $readrow['fld_staff_phone']; ?></td>
       
        <td>

          <?php
          if(isset($_SESSION['userlevel']) && $_SESSION['userlevel'] === "Admin") {
          ?>

          <a href="staffs.php?edit=<?php echo $readrow['fld_staff_num']; ?>"class="btn btn-success btn-xs" role="button">Edit</a>
          <a href="staffs.php?delete=<?php echo $readrow['fld_staff_num']; ?>" onclick="return confirm('Are you sure to delete?');"class="btn btn-danger btn-xs" role="button">Delete</a>
          <?php
          }
          ?>
        </td>
      </tr>
      <?php
      }
      $conn = null;
      ?>
    </table>
    </div>
    </div>
    </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>