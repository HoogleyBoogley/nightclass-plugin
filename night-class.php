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
add_action( 'widgets_init', 'DT_NightClass_registerWidget' );

// ADMIN PAGE
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

// WIDGET
class DT_NightClass_Widget extends WP_Widget {
    public function __construct() {
	    $widget_options = array(
            'classname' => 'night_class_widget',
            'description' => 'Displays the UOD and date for the next NJROTC night class'
        );

	    parent::__construct('night_class_widget', 'Night Class Widget', $widget_options);
    }

    public function widget($args, $instance) {
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );
        $blog_title = get_bloginfo( 'name' );
        $tagline = get_bloginfo( 'description' );
        echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>

        <h3>Next Night Class:</h3>
        <p align="center"><strong><?php echo esc_attr(get_option('dt_nightClass_date')); ?></strong></p>
        <p align="center"><?php echo esc_attr(get_option('dt_nightClass_uod')); ?></p>
        <p align="center"><?php echo esc_attr(get_option('dt_nightClass_activity')); ?></p>

        <?php echo $args['after_widget'];
    }

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['dt_nightClass_date'] = strip_tags( $new_instance['dt_nightClass_date']);
		$instance['dt_nightClass_date'] = strip_tags( $new_instance['dt_nightClass_uod']);
		$instance['dt_nightClass_date'] = strip_tags( $new_instance['dt_nightClass_activity']);
		return $instance;
	}
}

function DT_NightClass_registerWidget() {
	register_widget('DT_NightClass_Widget');
}