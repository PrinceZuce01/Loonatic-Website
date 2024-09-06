<?php
  include_once 'products_crud.php';
  session_start();
?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Loonatic Ordering System : Products</title>
  <!-- Datatable plugin CSS file -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
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
        <h2>Create New Product</h2>
      </div>
      <div class="form-horizontal">
      
    
    <form action="products.php" method="post">
      <div class="form-group">
          <label for="productid" class="col-sm-3 control-label">Product ID</label>
          <div class="col-sm-9">
      <input name="pid" type="text" class="form-control" id="productid" placeholder="Product ID" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_num']; ?>" required> 
      </div>
        </div>
      <div class="form-group">
          <label for="productname" class="col-sm-3 control-label">Name</label>
          <div class="col-sm-9">
      <input name="name" type="text" class="form-control" id="productname" placeholder="Product Name" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_name']; ?>" required> 
      </div>
        </div>
        <div class="form-group">
          <label for="productprice" class="col-sm-3 control-label">Price</label>
          <div class="col-sm-9">
      <input name="price" type="text" class="form-control" id="productprice" placeholder="Product Price" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_price']; ?>" required> 
      </div>
        </div>
      <div class="form-group">
          <label for="producttype" class="col-sm-3 control-label">Type</label>
          <div class="col-sm-9">
      <select name="type" class="form-control" id="producttype" required>
        <option value="">Please select</option>
        <option value="Supplies" <?php if(isset($_GET['edit'])) if($editrow['fld_product_type']=="Supplies") echo "selected"; ?>>Supplies</option>
        <option value="Plotter" <?php if(isset($_GET['edit'])) if($editrow['fld_product_type']=="Plotter") echo "selected"; ?>>Plotter</option>
        <option value="Scanner" <?php if(isset($_GET['edit'])) if($editrow['fld_product_type']=="Scanner") echo "selected"; ?>>Scanner</option>
      </select> 
            </div>
          </div>

          <div class="form-group">
          <label for="productcolor" class="col-sm-3 control-label">Color</label>
          <div class="col-sm-9">
      <select name="color" class="form-control" id="productcolor" required>
        <option value="">Please select</option>
        <option value="Other" <?php if(isset($_GET['edit'])) if($editrow['fld_product_color']=="Other") echo "selected"; ?>>Other</option>
        <option value="Black" <?php if(isset($_GET['edit'])) if($editrow['fld_product_color']=="Black") echo "selected"; ?>>Black</option>
        <option value="White" <?php if(isset($_GET['edit'])) if($editrow['fld_product_color']=="White") echo "selected"; ?>>White</option>
      </select> 
      </div>
        </div>
      <div class="form-group">
          <label for="productbrand" class="col-sm-3 control-label">Brand</label>
          <div class="col-sm-9">
      <select name="brand" class="form-control" id="productbrand" required>
        <option value="">Please select</option>
        <option value="HP" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="HP") echo "selected"; ?>>HP</option>
        <option value="Epson" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Epson") echo "selected"; ?>>Epson</option>
        <option value="Canon" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Canon") echo "selected"; ?>>Canon</option>
        <option value="Other" <?php if(isset($_GET['edit'])) if($editrow['fld_product_brand']=="Other") echo "selected"; ?>>Other</option>
      </select> 
      </div>
        </div>

      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">

          <?php if (isset($_GET['edit'])) { ?>
          <input type="hidden" name="oldpid" value="<?php echo $editrow['fld_product_num']; ?>">
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
        <h2>Products List</h2>
      </div>

      <table id="table1" name="table1"class="table table-striped table-bordered" >
        <thead>
          <tr>
        <th>Product ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Type</th>
        <th>Color</th>
        <th>Brand</th>
        <th></th>
      </tr>
        </thead>
      
       
        <tbody>
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
        $stmt = $conn->prepare("SELECT * FROM tbl_products_a181676_pt2 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>   
      <tr>
        <td><?php echo $readrow['fld_product_num']; ?></td>
        <td><?php echo $readrow['fld_product_name']; ?></td>
        <td><?php echo $readrow['fld_product_price']; ?></td>
        <td><?php echo $readrow['fld_product_type']; ?></td>
        <td><?php echo $readrow['fld_product_color']; ?></td>
        <td><?php echo $readrow['fld_product_brand']; ?></td>
        <td>
          <button id="openBtn" type="button" class="btn btn-warning btn-xs openBtn" data-toggle="modal" data-target="#myModal" data-href="products_details.php?pid=<?php echo $readrow['fld_product_num']; ?>"  role="button">Details</button>

          <?php
          if(isset($_SESSION['userlevel']) && $_SESSION['userlevel'] === "Admin") {
          ?>

          <a href="products.php?edit=<?php echo $readrow['fld_product_num']; ?>" class="btn btn-success btn-xs" role="button">Edit</a>
          <a href="products.php?delete=<?php echo $readrow['fld_product_num']; ?>" onclick="return confirm('Are you sure to delete?');"class="btn btn-danger btn-xs" role="button">Delete</a>
          <?php
          }
          ?>
        </td>
      </tr>
      <?php } ?>

        </tbody>

      
      

      <!-- MODAL -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modals">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Product Details</h4>
                </div>
                <div class="modal-body">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                
                </div>

  </div>
  </div>
  </div>
  



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
            $stmt = $conn->prepare("SELECT * FROM tbl_products_a181676_pt2");
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
            <li><a href="products.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"products.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"products.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="products.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
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
  
  <script>
     $(document).ready(function(){
      $('.openBtn').on('click',function(){
         var dataURL = $(this).attr('data-href');
        $('.modal-body').load(dataURL,function(){
             $('#myModal').modal({show:true});
        });
     }); 
   });

    $('#table1').DataTable({
      "lengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, 'All']],
      "columnDefs": [
      { "width": "120px", "targets": 8 }
      ]
    });

  </script>

  
    


</html>