<?php



add_action('admin_menu', 'paymantSettings');

if(!function_exists("opciones_de_admin")){
    function paymantSettings(){
       /* add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position)*/
        add_menu_page("Integration IQ", "Integration IQ-Instapago", "manage_options", "id_menu", "config_paymant");
    }

}

if(!function_exists("config_paymant")){

    function config_paymant(){
        ?>
        <div class="wrap">
            <hr>
            <h2>options</h2>
        </div>
        <form method="post" action="options.php">
            <?php
            settings_fields("IQGroup");
            do_settings_fields("id_menu", "buttonpaymant");
            
            ?>
            <table class="form-table">
                <tr valing="top">
                    <th scope="row">KeyId</th>
                    <td><input type="text" name="KeyId" id="KeyId" required pattern="[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}"  value="<?php echo get_option("KeyId")?>"/></td>
                </tr>
                <tr valing="top">
                    <th scope="row">PublicKeyId</th>
                    <td><input type="text" name="PublicKeyId" id="PublicKeyId" required pattern="[a-fA-F0-9]{32}"  value="<?php echo get_option("PublicKeyId") ?>"/></td>
                </tr>
                <tr valing="top">
                    <th scope="row">StatusId</th>
                    <td><input type="text" name="StatusId" id="StatusId" required pattern="[12]"  value="<?php echo get_option("StatusId") ?>"/></td>
                </tr>
            </table>
            <?php submit_button("Save Setting")?>
        </form>
        <?php
    } 

}

add_action("admin_init", "options_admin");

if(!function_exists("options_admin")){
    function options_admin(){
        register_setting("IQGroup" , "KeyId");
        register_setting("IQGroup" , "PublicKeyId");
        register_setting("IQGroup" , "StatusId");
    }
}






