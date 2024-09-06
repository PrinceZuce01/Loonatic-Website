<?php
  include_once 'customers_crud.php';
  session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Loonatic Ordering System : Customers</title>
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
        <h2>Insert New Customer</h2>
      </div>
      <div class="form-horizontal">
  
    <form action="customers.php" method="post">
      <div class="form-group">
          <label for="custid" class="col-sm-3 control-label">Customer ID</label>
          <div class="col-sm-9">
      
      <input name="cid" type="text" class="form-control" id="custid" placeholder="Customer ID" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_num']; ?>" required>
      </div>
      </div> 

      <div class="form-group">
          <label for="custname" class="col-sm-3 control-label">Customer Name</label>
          <div class="col-sm-9">
      
      <input name="name" type="text" class="form-control" id="custname" placeholder="Customer Name" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_name']; ?>" required> 
      </div>
      </div>

      <div class="form-group">
          <label for="custphone" class="col-sm-3 control-label">Phone Number</label>
          <div class="col-sm-9">
      
      <input name="phone" type="text" class="form-control" id="custphone" placeholder="Phone Number" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_phone']; ?>"> 
      </div>
      </div>

      <div class="form-group">
          <label for="custemail" class="col-sm-3 control-label">Email</label>
          <div class="col-sm-9">
      
      <input name="email" type="text" class="form-control" id="custemail" placeholder="Email" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_email']; ?>"> 
      </div>
      </div>

      <div class="form-group">
          <label for="custacc" class="col-sm-3 control-label">Account Number</label>
          <div class="col-sm-9">
     
      <input name="accnum" type="text" class="form-control" id="custacc" placeholder="Account Number" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_accnum']; ?>" required> 
      </div>
      </div>

      <div class="form-group">
          <label for="custpay" class="col-sm-3 control-label">Pay Way</label>
          <div class="col-sm-9">
      
      <select name="payway" type="text" class="form-control" id="custpay" placeholder="Pay Way" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_customer_payway']; ?>"required>
        <option value="">Please select</option>
        <option value="Maybank" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_payway']=="Maybank") echo "selected"; ?>>Maybank</option>
        <option value="Bank Islam" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_payway']=="Bank Islam") echo "selected"; ?>>Bank Islam</option>
        <option value="RHB Bank" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_payway']=="RHB Bank") echo "selected"; ?>>RHB Bank</option>
        <option value="BSN" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_payway']=="BSN") echo "selected"; ?>>BSN</option>
        <option value="Bank Amirul" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_payway']=="Bank Amirul") echo "selected"; ?>>Bank Amirul</option>
        <option value="100 Gecs" <?php if(isset($_GET['edit'])) if($editrow['fld_customer_payway']=="100 Gecs") echo "selected"; ?>>100 Gecs</option>
      </select>
      </div>
      </div> 
      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">


      <?php if (isset($_GET['edit'])) { ?>
      <input type="hidden" name="oldcid" value="<?php echo $editrow['fld_customer_num']; ?>">
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
        <h2>Customer List</h2>
      </div>
      <table class="table table-striped table-bordered">

      <tr>
        <td>Customer ID</td>
        <td>Customer Name</td>
        <td>Phone Number</td>
        <td>Email</td>
        <td>Account Number</td>
        <td>Pay Way</td>
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
          $stmt = $conn->prepare("SELECT * FROM tbl_customers_a181676_pt2 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>
      <tr>
        <td><?php echo $readrow['fld_customer_num']; ?></td>
        <td><?php echo $readrow['fld_customer_name']; ?></td>
        <td><?php echo $readrow['fld_customer_phone']; ?></td>
        <td><?php echo $readrow['fld_customer_email']; ?></td>
        <td><?php echo $readrow['fld_customer_accnum']; ?></td>
        <td><?php echo $readrow['fld_customer_payway']; ?></td>
        <td>
          <a href="customers.php?edit=<?php echo $readrow['fld_customer_num']; ?>" class="btn btn-success btn-xs" role="button">Edit</a>

          <?php
          if(isset($_SESSION['userlevel']) && $_SESSION['userlevel'] === "Admin") {
          ?>

          <a href="customers.php?delete=<?php echo $readrow['fld_customer_num']; ?>" onclick="return confirm('Are you sure to delete?');"class="btn btn-danger btn-xs" role="button">Delete</a>
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

    <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <nav>
          <ul class="pagination">
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_customers_a181676_pt2");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $total_records = count($result);
          }
          catch(PDOException $e){
                echo "Error: " . $e->getMessage();
          }
          $total_pages = ceil($total_records / $per_page);
          ?>
          <?php if ($page==1) { ?>
            <li class="disabled"><span aria-hidden="true">«</span></li>
          <?php } else { ?>
            <li><a href="customers.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"customers.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"customers.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="customers.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
          <?php } ?>
        </ul>
      </nav>
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