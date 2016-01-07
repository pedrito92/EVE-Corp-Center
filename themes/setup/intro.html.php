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
		<input type="hidden" name="ECCSetup_step" value="database">

		<label for="ECCSetup_language"><?php echo SELECT_LANGUAGE; ?></label>
		<select id="ECCSetup_language" name="ECCSetup_language">
            <?php foreach($hLanguage as $key => $rLanguage) {?>
                <option value="<?php echo $key; ?>"><?php echo $rLanguage; ?></option>
            <?php } ?>
        </select>

        <input type="submit" value="<?php echo NEXT_STEP; ?>">
    </form>
</div>