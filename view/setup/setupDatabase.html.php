<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 25/05/2014
 * Time: 11:47
 */
?>

<div>
    <h2><?php echo WELCOME_SETUP; ?></h2>

    <p><?php echo MYSQL_INSTALL_SUCCESS; ?></p>
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?domain=setup&action=createAdmin"><?php echo NEXT_STEP; ?></a>
</div>