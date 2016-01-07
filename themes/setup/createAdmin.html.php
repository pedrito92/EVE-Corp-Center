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
        <?php echo ADMIN_TEXT; ?>

        <?php if(isset($createAdmin['errorForm']) && $createAdmin['errorForm'] != '') {
            echo "<p>".$createAdmin['errorForm']."</p>";
        } ?>

        <input type="hidden" name="ECCSetup_createAdmin" value="true">
		<input type="hidden" name="ECCSetup_step" value="createAdmin">
        <br>
        <label for="ECCSetup_emailAdmin">Adresse e-mail</label>
        <input type="text" id="ECCSetup_emailAdmin" name="ECCSetup_emailAdmin" value="">
        <br>
        <label for="ECCSetup_passwdAdmin">Mot de passe</label>
        <input type="password" id="ECCSetup_passwdAdmin" name="ECCSetup_passwdAdmin" value="">
        <br>
        <label for="ECCSetup_confirmPasswdAdmin">Confirmer le mot de passe</label>
        <input type="password" id="ECCSetup_confirmPasswdAdmin" name="ECCSetup_confirmPasswdAdmin" value="">
        <br>

            <input type="submit" value="<?php echo NEXT_STEP; ?>">
    </form>
</div>