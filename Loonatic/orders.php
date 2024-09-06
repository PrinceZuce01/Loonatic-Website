<?php
  include_once 'orders_crud.php';
  session_start();
?>
 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Loonatic Ordering System : Orders</title>
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
        <h2>Insert New Order</h2>
      </div>
      <div class="form-horizontal">

    <form action="orders.php" method="post">
      <div class="form-group">
          <label for="staffid" class="col-sm-3 control-label">Order ID</label>
          <div class="col-sm-9">
      
      <input name="oid" type="text" class="form-control" id="orderid" placeholder="Order ID" readonly value="<?php if(isset($_GET['edit'])) echo $editrow['fld_order_num']; ?>"> </div>
      </div>

      <div class="form-group">
          <label for="staffid" class="col-sm-3 control-label">Order Date</label>
          <div class="col-sm-9">
      
      <input name="orderdate" type="text" class="form-control" id="orderdate" placeholder="Order Date" readonly value="<?php if(isset($_GET['edit'])) echo $editrow['fld_order_date']; ?>"> </div>
      </div>

      <div class="form-group">
          <label for="staffid" class="col-sm-3 control-label">Staff</label>
          <div class="col-sm-9">
      
      <select name="sid" class="form-control" id="staffid" placeholder="Staff ID" >
      <?php
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a181676_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $staffrow) {
      ?>
        <?php if((isset($_GET['edit'])) && ($editrow['fld_staff_num']==$staffrow['fld_staff_num'])) { ?>
          <option value="">Please select</option>
          <option value="<?php echo $staffrow['fld_staff_num']; ?>" selected><?php echo $staffrow['fld_staff_name']." ".$staffrow['fld_staff_phone'];?></option>
        <?php } else { ?>
          <option value="<?php echo $staffrow['fld_staff_num']; ?>"><?php echo $staffrow['fld_staff_name'];?></option>
        <?php } ?>
      <?php
      } // while
      $conn = null;
      ?> 
      </select> </div>
      </div>

      <div class="form-group">
          <label for="staffid" class="col-sm-3 control-label">Customer</label>
          <div class="col-sm-9">
      
      <select name="cid" class="form-control" id="custid" placeholder="Customer ID">
      <?php
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_customers_a181676_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $custrow) {
      ?>
        <?php if((isset($_GET['edit'])) && ($editrow['fld_customer_num']==$custrow['fld_customer_num'])) { ?>
          <option value="">Please select</option>
          <option value="<?php echo $custrow['fld_customer_num']; ?>" selected><?php echo $custrow['fld_customer_name']." ".$custrow['fld_customer_phone']?></option>
        <?php } else { ?>
          <option value="<?php echo $custrow['fld_customer_num']; ?>"><?php echo $custrow['fld_customer_name']?></option>
        <?php } ?>
      <?php
      } // while
      $conn = null;
      ?> 
      </select> </div>
      </div>
      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
      <?php if (isset($_GET['edit'])) { ?>
      <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
          <?php } else { ?>
            <input type="hidden" name="oid" value="<?php echo $editrow['fld_order_num']; ?>">
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
        <h2>Order List</h2>
      </div>
      <table class="table table-striped table-bordered">

      <tr>
        <td>Order ID</td>
        <td>Order Date</td>
        <td>Staff</td>
        <td>Customer</td>
        <td></td>
      </tr>
      <?php

      $per_page = 4;
      if (isset($_GET["page"]))
        $page = $_GET["page"];
      else
        $page = 1;
      $start_from = ($page-1) * $per_page;

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM tbl_orders_a181676_pt2 , tbl_staffs_a181676_pt2 , tbl_customers_a181676_pt2  WHERE ";
        $sql = $sql."tbl_orders_a181676_pt2.fld_staff_num = tbl_staffs_a181676_pt2.fld_staff_num and ";
        $sql = $sql."tbl_orders_a181676_pt2.fld_customer_num = tbl_customers_a181676_pt2.fld_customer_num";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $orderrow) {
      ?>
      <tr>
        <td><?php echo $orderrow['fld_order_num']; ?></td>
        <td><?php echo $orderrow['fld_order_date']; ?></td>
        <td><?php echo $orderrow['fld_staff_name'] ?></td>
        <td><?php echo $orderrow['fld_customer_name'] ?></td>
        <td>
          <a href="orders_details.php?oid=<?php echo $orderrow['fld_order_num']; ?>"class="btn btn-warning btn-xs" role="button">Details</a>
          <a href="orders.php?edit=<?php echo $orderrow['fld_order_num']; ?>"class="btn btn-success btn-xs" role="button">Edit</a>
          <?php
          if(isset($_SESSION['userlevel']) && $_SESSION['userlevel'] === "Admin") {
          ?>

          <a href="orders.php?delete=<?php echo $orderrow['fld_order_num']; ?>" onclick="return confirm('Are you sure to delete?');"class="btn btn-danger btn-xs" role="button">Delete</a>
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
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="jquery-3.5.1.min.js"></script>

  <!-- Datatable plugin JS library file -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
</body>
</html>