<?php
require __DIR__ . '/vendor/autoload.php';

session_start();

use Google\Cloud\Datastore\DatastoreClient;

#Checks if logged in
if (!isset($_SESSION['user'])) {
    echo "Please <a href='login'>login</a> first in order to access this page";
} else {
    $name = $_SESSION['user']['name']

?>

    <html>

    <body>
        <h2>Currently logged in as <?php echo $name ?></h2>
        <form action="/name" method="post">
            <label for="cuname"><b>Change Username</b></label>
            <input type="text" placeholder="Enter new username" name="cusername">
            <button type="submit">Change</button>
        </form>

    <?php

    #check if there's post data
    if (array_key_exists('cusername', $_POST)) {

        # Your Google Cloud Platform project ID
        $projectId = 's3661741-task2';

        # Instantiates a client
        $datastore = new DatastoreClient(['projectId' => $projectId]);

        $cUsername = $_POST['cusername'];

        $flag = false;

        #Check if new username isn't empty
        if ($cUsername != NULL) {

            #initialising transaction and retreiving user from the datastore
            $transaction = $datastore->transaction();
            $user = $datastore->lookup($_SESSION['userkey']);
            $user['name'] = $cUsername;

            #updating the datastore
            $transaction->update($user);
            $transaction->commit();

            $flag = true;
        } else {
            echo '<font color=red>User name field cannnot be empty</font>';
        }
        if ($flag == true) {

            #update user session
            $_SESSION['user'] = $user;

            #redirect
            echo '<script language=javascript>window.location.href="/main"</script>';
        }
    }
}
    ?>
    </body>

    </html>