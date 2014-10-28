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

    <form action="/setup/createAdmin" method="post">
        <?php echo MYSQL_CONNEXION; ?>

        <?php if(isset($erreur) && $erreur != '') {
            echo "<p>".$erreur."</p>";
        } ?>

        <input type="hidden" name="insertion" value="check">
        <br>
        <label for="adminEmail">Adresse e-mail</label>
        <input type="text" id="adminEmail" name="adminEmail" value="">
        <br>
        <label for="adminMdp">Mot de passe</label>
        <input type="password" id="adminMdp" name="adminMdp" value="">
        <br>
        <label for="adminMdp2">Confirmer le mot de passe</label>
        <input type="password" id="adminMdp2" name="adminMdp2" value="">
        <br>

            <input type="submit" value="<?php echo NEXT_STEP; ?>">
    </form>
</div>