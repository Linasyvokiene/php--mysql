<?php

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = array("name" => "","email" => "", "feedback" => "");

if($_POST){
	if(strlen($name) == 0 || strlen($email) == 0 || strlen($feedback) == 0){
		if(strlen($name) == 0){
			$error['name'] = 'Error';
		}
		if(strlen($email) == 0){
			$error['email'] = 'Error';
		}
		if(strlen($feedback) == 0){
			$error['feedback'] = 'Error';
		}
	
	}else {

		$conn = new mysqli('localhost','root','','feedback'); 
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$name = $conn->real_escape_string($name);
			$email = $conn->real_escape_string($email);
			$feedback = $conn->real_escape_string($feedback);


		$saved = $conn->query("INSERT INTO feedback (name, email, feedback) 
		VALUES ('$name','$email','$feedback')");
		if($saved){
		header('Location: ' . $_SERVER['PHP_SELF'] . '?success=OK');
		}else{
		$error['database'] = "Error when saving";
		}
		}
		}

	if(strlen($success) == 0) {
?>

<!DOCTYPE html>
<html>
	<head>	
		<title>Feedback</title>
	</head>
	
<body>

	<h1>Form</h1>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<p>Name
		<input type="text" name="name" placeholder="Name" size="20" value="<?php echo $name; ?>"/><?php echo $error['name'];?> </p>
		<p>Email
		<input type="text" name="email" placeholder="Email" size="20" value="<?php echo $email; ?>" /><?php echo $error['email'];?>
		</p>
		<p>Your feedback<br><br>
        <textarea name ="feedback" placeholder = "Enter your Feedback" rows="4" cols="28"><?php echo $feedback; ?></textarea><?php echo $error['feedback'];?> </p>
        <p><?php echo $success; ?></p>
        <p><input type="submit" value="Submit"/></p>
	
    </form>

</body>
	
	
</html>

<?php
	}else {
		print "Ok";
	}
?>








