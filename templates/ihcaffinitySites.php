<div class="wrap">
    <h1>Ihc Affinity Sites</h1>
    <?php settings_errors();?>
    <ul class="nav nav-tabs">
        <li class="<?php echo !isset($_POST["edit_ihcaffinity_sites"]) ? 'active' : '' ?>"><a href="#tab-1">Your Custom Ihcaffinity Sites</a></li>
        <li class="<?php echo isset($_POST["edit_ihcaffinity_sites"]) ? 'active' : '' ?>">
            <a href="#tab-2">
                <?php echo isset($_POST["edit_ihcaffinity_sites"]) ? 'Edit' : 'Add' ?> Custom Ihcaffinity Sites
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_ihcaffinity_sites"]) ? 'active' : '' ?>" >
            <h3>Manage Working Hours</h3>
            <?php
            $options = get_option('torchlight_ihcaffinity_sites') ?: [];
            echo '<table class="table">
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Link</th>
                        <th class="text-center">Phone</th>
                        <th class="text-center">Logo</th>
                        <th class="text-center">Primary Color</th>
                        <th class="text-center">Secondary Color</th>
                        <th class="text-center">Tou And PP</th>
                        <th class="text-center">Working Hours</th>
                        <th class="text-center">Actions</th></tr>';

            foreach ($options as $key => $option) {

                echo "
                <tr>
                    <td class='text-center'>{$option['affinity_site_name']}</td>
                    <td class='text-center'>{$option['affinity_site_link']}</td>
                    <td class='text-center'>{$option['affinity_site_phone']}</td>
                    <td class='text-center'><img src='{$option['affinity_site_logo']}' alt='' style='width: auto;height: 50px;'></td>
                    <td class='text-center'>{$option['affinity_site_color_primary']}</td>
                    <td class='text-center'>{$option['affinity_site_color_secondary']}</td>
                    <td class='text-center'>{$option['affinity_site_tou_pp']}</td>
                    <td class='text-center'>{$option['affinity_site_working_hours']}</td>
                    <td class='text-center'>";

                echo '<form method="post" action="" class="inline-block">';
                echo '<input type="hidden" name="edit_ihcaffinity_sites" value="' . $option['affinity_site_name'] . '">';
                submit_button( 'Edit', 'primary small', 'submit', false);
                echo '</form> ';


                echo '<form method="post" action="options.php" class="inline-block">';
                settings_fields( 'torch_ihcaffinity_sites_settings' );
                echo '<input type="hidden" name="remove" value="' . $option['affinity_site_name'] . '">';
                submit_button( 'Delete', 'delete small', 'submit', false, array(
                    'onclick' => 'return confirm("Are you sure you want to delete this site?");'
                ));
                echo '</form></td></tr>';
            }

            echo '</table>';

            ?>
        </div>
        <div id="tab-2" class="tab-pane  <?php echo isset($_POST["edit_ihcaffinity_sites"]) ? 'active' : '' ?>">
            <h3>Create New Working hours</h3>
            <form action="options.php" method="post" enctype="multipart/form-data">
                <?php
                settings_fields('torch_ihcaffinity_sites_settings');
                do_settings_sections('ihcaffinity_sites');
                submit_button();
                ?>
            </form>
        </div>
    </div>

</div>




