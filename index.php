<!DOCTYPE html>
<html>
<body>
<div class="login">
	<h1>Employee Login</h1>
		<button name="employeeLogin" id="employeeLogin" class="btn btn-primary btn-block btn-large" onclick="window.location.href='/login/'">Sign in with Google</button>
	<h1>Client Login</h1>
	<form name="loginform" id="loginform" action="https://sgsadmin.com/wp-login.php" method="post">
		<input type="text" name="log" id="user_login" aria-describedby="login_error" class="input" value="" size="20" placeholder="Work E-Mail Address" required></label>
		<input type="password" name="pwd" id="user_pass" aria-describedby="login_error" class="input" value="" size="20" placeholder="Password" required></label>
		<input type="hidden" name="redirect_to" value="https://sgsadmin.com/wp-admin/">
		<input type="hidden" name="testcookie" value="1">
		<button type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-block btn-large">Log In</button>
	</form>

</div>
</body>
</html>

<?php
session_start();
    echo '<pre>' . var_export($_SESSION, true) . '</pre>';
?>