<div class="wrap">
    <h1>Terms of Use And Privacy Policy</h1>
    <?php settings_errors();?>
    <ul class="nav nav-tabs">
        <li class="<?php echo !isset($_POST["edit_tou_pp"]) ? 'active' : '' ?>"><a href="#tab-1">Custom Terms of Use and Privacy Policy</a></li>
        <li class="<?php echo isset($_POST["edit_tou_pp"]) ? 'active' : '' ?>">
            <a href="#tab-2">
                <?php echo isset($_POST["edit_tou_pp"]) ? 'Edit' : 'Add' ?> Custom Terms of Use and Privacy Policy
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_tou_pp"]) ? 'active' : '' ?>" >
            <h3>Manage Terms of Use and Privacy Policy</h3>
            <?php
            $options = get_option('torchlight_tou_pp') ?: [];
            echo '<table class="table">
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Privacy Policy</th>
                        <th class="text-center">TOU</th>
                        <th class="text-center">Actions</th></tr>';

            foreach ($options as $key => $option) {
                $pp = substr($option['privacy_policy'], 0, 100);
                $tou = substr($option['terms_of_use'], 0, 100);
                echo "
                <tr>
                    <td class='text-center'>{$option['site_id']}</td>
                    <td class='text-center'>{$pp}</td>
                    <td class='text-center'>{$tou}</td>
                    <td class='text-center'>";

                echo '<form method="post" action="" class="inline-block">';
                echo '<input type="hidden" name="edit_tou_pp" value="' . $option['site_id'] . '">';
                submit_button( 'Edit', 'primary small', 'submit', false);
                echo '</form> ';


                echo '<form method="post" action="options.php" class="inline-block">';
                settings_fields( 'torch_tou_pp_settings' );
                echo '<input type="hidden" name="remove" value="' . $option['site_id'] . '">';
                submit_button( 'Delete', 'delete small', 'submit', false, array(
                    'onclick' => 'return confirm("Are you sure you want to delete this Terms of Use?");'
                ));
                echo '</form></td></tr>';
            }

            echo '</table>';

            ?>
        </div>
        <div id="tab-2" class="tab-pane  <?php echo isset($_POST["edit_tou_pp"]) ? 'active' : '' ?>">
<!--            <h3>Create New Working hours</h3>-->
            <form action="options.php" method="post">
                <?php
                settings_fields('torch_tou_pp_settings');
                do_settings_sections('tou_pp');
                submit_button();
                ?>
            </form>
        </div>
    </div>

</div>

