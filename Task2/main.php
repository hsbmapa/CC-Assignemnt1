<?php
require __DIR__ . '/vendor/autoload.php';

session_start();

#checks if logged in
if (!isset($_SESSION['user'])) {
    echo "Please <a href='login'>login</a> first in order to access this page";
} else {
    $name = $_SESSION['user']['name'];
?>
    <html>

    <body>
        <h2>Hello <?php echo $name; ?></h2>
        <form action="/name" method="POST">
            <button type="submit">Change Name</button>
        </form>
        <form action="/password" method="POST">
            <button type="submit">Change Password</button>
        </form>
    <?php
}
    ?>
    </body>

    </html>