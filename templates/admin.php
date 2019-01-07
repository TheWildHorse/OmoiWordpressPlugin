<div class="wrap">
    <h1>Omoi Plugin</h1>
    <?php settings_errors(); ?>
    <?php
    if (get_option('company_id') == 0) {
        echo "<h4>In order to use this plugin, you need to register to our site. We'll handle the rest.</h4> 
                <a href=" . get_option('omoi_host') . "?wp_host=" . home_url() . "&wp_url=/wp-admin/admin.php?page=omoi class='button button-primary'>Register to Omoi</a>";
    } else {
        echo "<form method='post' action=" . esc_url( admin_url('admin-post.php') ) . ">";
        settings_fields('omoi_options_group');
        do_settings_sections('omoi_plugin');
        echo "        <input type='hidden' name='action' value='contact_form'>";
        submit_button();
        echo "</form>";
    }
    ?>
</div>

