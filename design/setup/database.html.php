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

	<form action="/setup" method="post">
		<?php echo MYSQL_CONNEXION; ?>

		<?php if(isset($testConnection['errorForm']) && $testConnection['errorForm'] != '') {
			echo "<p>".$testConnection['errorForm']."</p>";
		} ?>

		<?php if(isset($testConnection['PDOreturn']) && $testConnection['PDOreturn'] !== true) {
			echo $testConnection['PDOreturn'];
		} else if(isset($testConnection['PDOreturn']) && $testConnection['PDOreturn'] === true) {
            echo MYSQL_ERROR_SUCCESS;
        }?>

		<?php if(isset($testConnection['PDOreturn']) && $testConnection['PDOreturn'] === true) { ?>
			<input type="hidden" name="ECCSetup_step" value="setupCore">
			<br>
			<label for="ECCSetup_database_server"><?php echo MYSQL_HOST; ?> :</label>
			<input type="text" id="ECCSetup_database_server" name="ECCSetup_database_server" value="<?php echo $testConnection['placeholderForm']['server'] ?>" readonly>
			<br>
			<label for="ECCSetup_database_port"><?php echo MYSQL_PORT; ?> :</label>
			<input type="text" id="ECCSetup_database_port" name="ECCSetup_database_port" value="<?php echo $testConnection['placeholderForm']['port']; ?>" readonly>
			<br>
			<label for="ECCSetup_database_username"><?php echo MYSQL_USER; ?> :</label>
			<input type="text" id="ECCSetup_database_username" name="ECCSetup_database_username" value="<?php echo $testConnection['placeholderForm']['username']; ?>" readonly>
			<br>
			<label for="ECCSetup_database_passwd"><?php echo MYSQL_PASS; ?> :</label>
			<input type="password" id="ECCSetup_database_passwd" name="ECCSetup_database_passwd" value="<?php echo $testConnection['placeholderForm']['passwd']; ?>" readonly>
			<br>
			<label for="ECCSetup_database_dbname"><?php echo MYSQL_DBNAME; ?> :</label>
			<input type="text" id="ECCSetup_database_dbname" name="ECCSetup_database_dbname" value="<?php echo $testConnection['placeholderForm']['dbname']; ?>" readonly>
			<br>
			<label for="ECCSetup_database_prefix"><?php echo MYSQL_PREFIX; ?> :</label>
			<input type="text" id="ECCSetup_database_prefix" name="ECCSetup_database_prefix" value="<?php echo $testConnection['placeholderForm']['prefix']; ?>" readonly>
			<br>
			<a href="javascript:history.back()"><?php echo PREVIOUS_STEP; ?></a>
			<input type="submit" value="<?php echo NEXT_STEP; ?>">
		<?php } else { ?>
			<input type="hidden" name="ECCSetup_step" value="database">
			<input type="hidden" name="ECCSetup_checkdatabase" value="true">
			<br>
			<label for="ECCSetup_database_server"><?php echo MYSQL_HOST; ?> :</label>
			<input type="text" id="ECCSetup_database_server" name="ECCSetup_database_server" value="<?php if(isset($_POST['ECCSetup_database_server'])){ echo $_POST['ECCSetup_database_server']; }else{ echo $placeholderForm['server']; } ?>">
			<br>
			<label for="ECCSetup_database_port"><?php echo MYSQL_PORT; ?> :</label>
			<input type="text" id="ECCSetup_database_port" name="ECCSetup_database_port" value="<?php if(isset($_POST['ECCSetup_database_port'])){ echo $_POST['ECCSetup_database_port']; }else{ echo $placeholderForm['port']; } ?>">
			<br>
			<label for="ECCSetup_database_username"><?php echo MYSQL_USER; ?> :</label>
			<input type="text" id="ECCSetup_database_username" name="ECCSetup_database_username" value="<?php if(isset($_POST['ECCSetup_database_username'])){ echo $_POST['ECCSetup_database_username']; }else{ echo $placeholderForm['username']; } ?>">
			<br>
			<label for="ECCSetup_database_passwd"><?php echo MYSQL_PASS; ?> :</label>
			<input type="password" id="ECCSetup_database_passwd" name="ECCSetup_database_passwd" value="">
			<br>
			<label for="ECCSetup_database_dbname"><?php echo MYSQL_DBNAME; ?> :</label>
			<input type="text" id="ECCSetup_database_dbname" name="ECCSetup_database_dbname" value="<?php if(isset($_POST['ECCSetup_database_dbname'])){ echo $_POST['ECCSetup_database_dbname']; }else{ echo $placeholderForm['dbname']; } ?>">
			<br>
			<label for="ECCSetup_database_prefix"><?php echo MYSQL_PREFIX; ?> :</label>
			<input type="text" id="ECCSetup_database_prefix" name="ECCSetup_database_prefix" value="<?php if(isset($_POST['ECCSetup_database_prefix'])){ echo $_POST['ECCSetup_database_prefix']; }else{ echo $placeholderForm['prefix']; } ?>">
			<br>

			<a href="/setup"><?php echo PREVIOUS_STEP; ?></a>
			<input type="submit" value="<?php echo NEXT_STEP; ?>">
		<?php } ?>
    </form>
</div>