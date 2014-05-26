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

    <form action="/?domain=setup&action=database" method="post">
        <?php echo MYSQL_CONNEXION; ?>

        <?php if(isset($erreur) && $erreur != '') {
           echo "<p>".$erreur."</p>";
        } ?>

        <?php if(isset($erreurPDO) && $erreurPDO != 'ok') {
            echo $erreurPDO;
        } else if(isset($erreurPDO) && $erreurPDO == 'ok') {
            echo MYSQL_ERROR_SUCCESS;
        }?>


        <input type="hidden" name="checkDatabase" value="check">
        <br>
        <label for="dbServeur"><?php echo MYSQL_HOST; ?></label>
        <input type="text" id="dbServeur" name="dbServeur" value="<?php echo $form['serveur']; ?>">
        <br>
        <label for="dbPort"><?php echo MYSQL_PORT; ?></label>
        <input type="text" id="dbPort" name="dbPort" value="<?php echo $form['port']; ?>">
        <br>
        <label for="dbUtilisateur"><?php echo MYSQL_USER; ?></label>
        <input type="text" id="dbUtilisateur" name="dbUtilisateur" value="<?php echo $form['utilisateur']; ?>">
        <br>
        <label for="dbMdp"><?php echo MYSQL_PASS; ?></label>
        <input type="password" id="dbMdp" name="dbMdp" value="<?php echo $form['mdp']; ?>">
        <br>
        <label for="dbNom"><?php echo MYSQL_DBNAME; ?></label>
        <input type="text" id="dbNom" name="dbNom" value="<?php echo $form['nomBase']; ?>">
        <br>

        <a href="/?domain=setup"><?php echo PREVIOUS_STEP; ?></a>
        <?php if(isset($erreurPDO) && $erreurPDO == 'ok') { ?>
            <a href="/?domain=setup&action=setupDatabase"><?php echo NEXT_STEP; ?></a>
        <?php } else { ?>
            <input type="submit" value="<?php echo NEXT_STEP; ?>">
        <?php } ?>
    </form>
</div>