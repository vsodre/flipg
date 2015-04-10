<?php
include_once 'include/database.php';
include_once 'include/operations.php';
 
sec_session_start();
 
 //check if the user is logged in
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>login page</title>
        <link rel="stylesheet" href="styles/style.css" />
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>
	  <div class="login-card">
		<h1>Login</h1><br>
        <form action="include/login.php" method="post" name="login_form">                      
            
			Email: <input type="text" name="email" />
			<br>
            Password: <input type="password" 
                             name="password" 
                             id="password"/>
			<br>
            <input type="submit" 
				   class="login login-submit"
                   value="Login" 
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>
		
		<?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Could not log into the system.</p>';
        }
        ?> 

<?php
	//Display different tools based on whether or not the user is logged in
        if (login_check($mysqli) == true) {
                        echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
 
            echo '<p>Do you want to change user? <a href="include/logout.php">Log out</a>.</p>';
        } else {
                        echo "<p>Click <a href='register.php'>here</a> to register.</p>";
                }
?>      
	</div>
    </body>
</html>