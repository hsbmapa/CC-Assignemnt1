<?php
require __DIR__ . '/vendor/autoload.php';

session_start();

use Google\Cloud\Datastore\DatastoreClient;
?>

<html>

<body>
	<form action="/login" method="post">
		<label for="uname"><b>Username</b></label>
		<input type="text" placeholder="Enter Username" name="username">

		<label for="psw"><b>Password</b></label>
		<input type="password" placeholder="Enter Password" name="password">

		<button type="submit">Login</button>
	</form>
	<?php
	if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
		
		/*"Entities, Properties, and Keys  |  Cloud Datastore Documentation", Google Cloud, 2020. [Online]. 
		Available: https://cloud.google.com/datastore/docs/concepts/entities#datastore-datastore-basic-entity-php. 
		[Accessed: 24- Mar- 2020].*/

		# Your Google Cloud Platform project ID
		$projectId = 's3661741-task2';

		# Instantiates a client
		$datastore = new DatastoreClient(['projectId' => $projectId]);

		# Obtain username and password value from html form
		$receivedUsername = $_POST['username'];
		$receivedPassword = $_POST['password'];

		$flag = false;

		#checking if username and password area empty
		if ($receivedUsername != NULL && $receivedPassword != NULL) {

			#getting key from logged user
			$key = $datastore->key('user', $receivedUsername);
			$user = $datastore->lookup($key);
			$pass = $user['password'];

			#check if user exists
			if (!is_null($user)) {
				if ($receivedPassword == $pass) {
					$flag = true;
					echo '<font color=green>login successful</font>';
				}
			}
			if ($flag == true) {

				#creating session for user and key
				$_SESSION['user'] = $user;
				$_SESSION['userkey'] = $key;

				#redirect
				echo '<script language=javascript>window.location.href="/main"</script>';
			} else {
				echo '<font color=red>User name or password is invalid</font>';
			}
		} else {
			echo '<font color=red>User name and Password field cannnot be empty</font>';
		}
	}
	?>
</body>

</html>
