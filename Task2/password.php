<?php
require __DIR__ . '/vendor/autoload.php';

session_start();

use Google\Cloud\Datastore\DatastoreClient;

#checks if logged in
if (!isset($_SESSION['user'])) {
    echo "Please <a href='login'>login</a> first in order to access this page";
} else {
    $name = $_SESSION['user']['name']

?>

    <html>

    <body>
        <h2>Currently logged in as <?php echo $name ?></h2>
        <form action="/password" method="post">
            <label for="cpass"><b>Change Password</b></label>
            <input type="text" placeholder="Enter old password" name="oldPassword">
            <input type="text" placeholder="Enter new password" name="cpassword">
            <button type="submit">Change</button>
        </form>

    <?php

    #checks if there's post data
    if (array_key_exists('oldPassword', $_POST) && array_key_exists('cpassword', $_POST)) {

        # Your Google Cloud Platform project ID
        $projectId = 's3661741-task2';

        # Instantiates a client
        $datastore = new DatastoreClient(['projectId' => $projectId]);

        $oldPass = $_POST['oldPassword'];
        $cPassword = $_POST['cpassword'];

        $flag = false;

        #checking if text boxes are empty
        if ($oldPass != NULL && $cPassword != NULL) {
            
            $user = $datastore->lookup($_SESSION['userkey']);
            $pass = $user['password'];

            #check if the password entered is the same as in the database
            if ($oldPass == $pass) {

                #initialising the transaction
                $transaction = $datastore->transaction();
                $user['password'] = $cPassword;

                #update the datastore
                $transaction->update($user);
                $transaction->commit();

                $flag = true;

            } else {
                echo '<font color=red>Old user password is incorrect</font>';
            }

            if ($flag == true) {

                #update the user session
                $_SESSION['user'] = $user;
                echo '<font color=green>password changed successfully</font>';

                #redirect
                echo '<script language=javascript>window.location.href="/"</script>';
            }
        } else {
            echo '<font color=red>Old Password field cannnot be empty</font>';
        }
    }
}
    ?>
    </body>

    </html>