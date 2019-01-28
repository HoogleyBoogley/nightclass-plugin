<?php
/*
Plugin Name: Night Class
Plugin URI: https://dev.hoogleyboogley.com/
Description: A WordPress plugin for the Wheeling JROTC website which displays the UOD and next night class.
Version: 1.0
Author: Danny Tran(@HoogleyBoogley)
Author URI: https://github.com/HoogleyBoogley
License: MIT
*/

add_action('admin_menu', 'DT_nightClassAdminMenu');
add_action('admin_init', 'DT_nightClass_settings');

// Initiate the admin page in the menu
function DT_nightClassAdminMenu() {
	add_menu_page('Night Class', 'Night Class', 'manage_options', 'dannytran/nightclass.php', 'DT_nightClass_optionsMenu', 'dashicons-businessman', 6);
}

// Create the plugin settings
function DT_nightClass_settings() {
	add_option("dt_nightClass_date", "", "", "yes");
	add_option("dt_nightClass_uod", "", "", "yes");
	add_option("dt_nightClass_activity", "", "", "yes");

	register_setting('DT_nightClass_settingsGroup', 'dt_nightClass_date');
	register_setting('DT_nightClass_settingsGroup', 'dt_nightClass_uod');
	register_setting('DT_nightClass_settingsGroup', 'dt_nightClass_activity');
}

// The options page
function DT_nightClass_optionsMenu() {

	if (!current_user_can('manage_options')) {
		wp_die("Permission denied!");
	}


	$dateValue = esc_attr(get_option('dt_nightClass_date'));
	$uodValue = esc_attr(get_option('dt_nightClass_uod'));
	$activityValue = esc_attr(get_option('dt_nightClass_activity'));

	?>
	<div class="wrap">
        <h2>Night Class Widget</h2>
        <span>By <a href="https://github.com/HoogleyBoogley">Danny Tran</a></span><br>

        <form method="POST" action="options.php" name="DT_nightClass_settingsGroup">
	        <?php settings_fields('DT_nightClass_settingsGroup'); ?>
	        <?php do_settings_sections('DT_nightClass_settingsGroup'); ?>


            <table class="form-table">
                <tr><td colspan="2"><hr></td></tr>


                <tr valign="top">
                    <th scope="row">Date of Next Night Class</th>
                    <td>
                        <input type="date" name="dt_nightClass_date" value="<?php echo $dateValue; ?>">
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Uniform of the Day</th>
                    <td>
                        <select name="dt_nightClass_uod">
                            <option value="NSUs" <?php if ($uodValue == 'NSUs') echo 'selected="selected"'; ?>>NSUs</option>
                            <option value="PT Gear" <?php if ($uodValue == 'PT Gear') echo 'selected="selected"'; ?>>PT Gear</option>
                            <option value="NSUs and SDBs" <?php if ($uodValue == 'NSUs and SDBs') echo 'selected="selected"'; ?>>NSUs and SDBs</option>
                            <option value="SDBs" <?php if ($uodValue == 'SDBs') echo 'selected="selected"'; ?>>SDBs</option>
                            <option value="Civilian" <?php if ($uodValue == 'Civilian') echo 'selected="selected"'; ?>>Civilian</option>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Night Class Activity</th>
                    <td>
                        <input type="text" name="dt_nightClass_activity" value="<?php echo $activityValue; ?>">
                    </td>
                </tr>

            </table>

            <?php
                submit_button();
            ?>
        </form>
    </div>
	<?php
}

// WIDGET;
