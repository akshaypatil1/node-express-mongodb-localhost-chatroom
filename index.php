<?php
	session_start();
	session_destroy();
	session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN</title>
</head>
<body>
	<form action="" method="post">        
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" required="required" name="login-name" class="login-name" id="login-name" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" required="required" name="login-password" class="login-password" id="login-password" /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" class="login-btn" name="loginbt" id="login-btn" value="LogIn" /></td>
            </tr>
        </table>
    </form>

</body>
</html>

<?php
	if(isset($_REQUEST['loginbt']))
	{
		
		$name = $_POST['login-name'];
		$password = $_POST['login-password'];
		if($password=='don' && ($name!='YG' && $name!='yg'))
		{
			$_SESSION['name'] = $name;
			/*echo "<script>window.location.href = 'http://www.google.com'</script>";
			*/
			header("Location: http://192.168.0.9/chat/chat.php");
		}
		else
		{
			echo "<script>alert('Somthing Missing');</script>";
			header("Location: http://192.168.0.9/chat/index.php");
			//echo 'bye';
		}
	}
	//else
	//echo 'haha';
	
?>
