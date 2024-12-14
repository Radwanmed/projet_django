<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="/univ_event/profil/php/login.css">
</head>
<body>
    <div class="form-container">
    	
    	<form class="signup-form" 
    	      action="php/login.php" 
    	      method="post">

    		<h4 class="form-title">LOGIN</h4><br>
    		
    		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
			</div>
		    <?php } ?>

		  <div class="form-group">
		    <label class="form-label">User name</label>
		    <input type="text" 
		           class="form-control"
		           name="uname"
		           value="<?php echo (isset($_GET['uname']))?$_GET['uname']:"" ?>">
		  </div>

		  <div class="form-group">
		    <label class="form-label">Password</label>
		    <input type="password" 
		           class="form-control"
		           name="pass">
		  </div>
		   
		  <button type="submit" class="btn btn-submit">Login</button>
		  <a href="index.php" class="btn-link">Sign Up</a>
		  <a href="/univ_event/profil/php/loginad.html" class="admin-button">Admin</a>
		</form>
    </div>
</body>
</html>
