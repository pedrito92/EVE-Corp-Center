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
	<form action="/setup" method="post">
		<input type="hidden" name="ECCSetup_step" value="createAdmin">
		<input type="submit" value="<?php echo NEXT_STEP; ?>">
    </form>
</div>