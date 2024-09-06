<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
}

include_once 'database.php';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
 
    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a181676_pt2 where user_name = :uid");
    $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
    $uid = $_POST['uid'];
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

  }
 
  catch(PDOException $e)
  {
    echo '<script>
    window.onload=function() {
      alert("Login Failed. You have entered an invalid User ID or password.");
    };
    </script>';
  }

  if($row != null) {
    if($row['password'] == $_POST['upass']) {

      $_SESSION['uid'] = $row['user_name'];
      $_SESSION['name'] = $row['fld_staff_name'];
      $_SESSION['userlevel'] = $row['user_lvl'];
      $_SESSION['loggedin'] = true;

      header("Location: index.php");
    }
    else {
      echo '<script>
      window.onload=function() {
        alert("Login Failed. You have entered an invalid User ID or password.");
      };
      </script>';
    }
  }
  else {
    echo '<script>
    window.onload=function() {
      alert("Login Failed. You have entered an invalid User ID or password.");
    };
    </script>';
  }

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Loonatic Ordering System : Login</title>
	<!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      body {
        background: url(FCBackgroundImage.png) no-repeat center center fixed; 
        background-size: cover;
        overflow: hidden;
      }
      img {
        display: block;
        margin: auto;
        width: 100%;
        height: 100%;
      }
      #container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        width: 400px;
        height: 300px;
        border-radius: 5px;
        background: rgba(3,3,3,0.25);
        box-shadow: 1px 1px 50px #000;
        display: block;
      }
      /* Heading */
      h2  {
        font-family: 'Open Sans Condensed', sans-serif;
        position: relative;
        margin-top: 0px;
        text-align: center;
        font-size: 30px;
        color: #ddd;
        text-shadow: 3px 3px 10px #000;
      }
      .close-btn{
        position: absolute;
        cursor: pointer;
        font-family: 'Open Sans Condensed', sans-serif;
        line-height: 18px;
        top: 3px;
        right: 3px;
        width: 20px;
        height: 20px;
        text-align: center;
        border-radius: 10px;
        opacity: .2;
        -webkit-transition: all 2s ease-in-out;
        -moz-transition: all 2s ease-in-out;
        -o-transition: all 2s ease-in-out;
        transition: all 0.2s ease-in-out;
      }

      .close-btn:hover{
        opacity: .5;
      }

      label {
        font-family: 'Open Sans Condensed', sans-serif;
        text-decoration: none;
        position: relative;
        width: 100%;
        display: block;
        margin: 9px auto;
        font-size: 17px;
        color: #fff;
        padding: 8px;
        border-radius: 6px;
        border: none;
        background: rgba(3,3,3,.1);
        -webkit-transition: all 2s ease-in-out;
        -moz-transition: all 2s ease-in-out;
        -o-transition: all 2s ease-in-out;
        transition: all 0.2s ease-in-out;
      }
      /* Inputs */
      #userid {
        font-family: 'Open Sans Condensed', sans-serif;
        text-decoration: none;
        position: relative;
        width: 100%;
        display: block;
        margin: 9px auto;
        font-size: 17px;
        color: #fff;
        padding: 8px;
        border-radius: 6px;
        border: none;
        background: rgba(3,3,3,.1);
        -webkit-transition: all 2s ease-in-out;
        -moz-transition: all 2s ease-in-out;
        -o-transition: all 2s ease-in-out;
        transition: all 0.2s ease-in-out;
      }
      #userpassword {
        font-family: 'Open Sans Condensed', sans-serif;
        text-decoration: none;
        position: relative;
        width: 100%;
        display: block;
        margin: 9px auto;
        font-size: 17px;
        color: #fff;
        padding: 8px;
        border-radius: 6px;
        border: none;
        background: rgba(3,3,3,.1);
        -webkit-transition: all 2s ease-in-out;
        -moz-transition: all 2s ease-in-out;
        -o-transition: all 2s ease-in-out;
        transition: all 0.2s ease-in-out;
      }

      input:focus{
        outline: none;
        box-shadow: 3px 3px 10px #333;
        background: rgba(3,3,3,.18);
      }

      /* Placeholders */
      ::-webkit-input-placeholder {
        color: #ddd;
      }
      :-moz-placeholder {
        /* Firefox 18- */
          color: red;
      }
      ::-moz-placeholder {
        /* Firefox 19+ */
        color: red;
      }
      :-ms-input-placeholder {
        color: #333;
      }
      #btnlogin {
        font-family: 'Open Sans Condensed', sans-serif;
        text-align: center;
        padding: 4px 8px;
      }

      button:hover{
        opacity: 0.7;
      }
    </style>
</head>
<body>
  <div class="container-fluid" id="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12" id="col">
      <div class="page-header">
        <h2>Login</h2>
        <span class="close-btn">
          <img src="https://cdn4.iconfinder.com/data/icons/miu/22/circle_close_delete_-128.png" onclick="window.location='index.php'"></img>
        </span>
      </div>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form-horizontal">
        <div class="form-group">
          <label for="userid" class="col-sm-3 control-label">ID</label>
          <div class="col-sm-9">
            <input name="uid" type="text" class="form-control" id="userid" placeholder="User ID" required>
          </div>
        </div>
        <div class="form-group">
          <label for="userpassword" class="col-sm-3 control-label">Password</label>
          <div class="col-sm-9">
            <input name="upass" type="password" class="form-control" id="userpassword" placeholder="User Password" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-5 col-sm-9">
            <button class="btn btn-default" type="submit" name="login" id="btnlogin">Login</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>