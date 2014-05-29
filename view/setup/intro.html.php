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

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?domain=setup&action=database" method="post">
        <label for="aLang"><?php echo SELECT_LANGUAGE; ?></label>
        <select id="aLang" name="aLang">
            <?php foreach($aLangs as $key => $lang) {?>
                <option value="<?php echo $key; ?>"><?php echo $lang; ?></option>
            <?php } ?>
        </select>

        <input type="submit" value="<?php echo NEXT_STEP; ?>">
    </form>
</div>