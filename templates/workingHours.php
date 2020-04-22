<div class="wrap">
    <h1>Working Hours</h1>
    <?php settings_errors();?>
    <ul class="nav nav-tabs">
        <li class="<?php echo !isset($_POST["edit_working_hours"]) ? 'active' : '' ?>"><a href="#tab-1">Working Hours</a></li>
        <li class="<?php echo isset($_POST["edit_working_hours"]) ? 'active' : '' ?>">
            <a href="#tab-2">
                <?php echo isset($_POST["edit_working_hours"]) ? 'Edit' : 'Add' ?> Working Hours
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_working_hours"]) ? 'active' : '' ?>" >
          <h3>Manage Working Hours</h3>
            <?php

            $options = get_option('torchlight_working_hours') ?: [];
            echo '<table class="table">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Monday</th>
                        <th class="text-center">Tuesday</th>
                        <th class="text-center">Wednesday</th>
                        <th class="text-center">Thursday</th>
                        <th class="text-center">Friday</th>
                        <th class="text-center">Saturday</th>
                        <th class="text-center">Sunday</th>
                        <th class="text-center">Holiday</th>
                        <th class="text-center">Actions</th></tr>';
            foreach ($options as $key => $option) {
                foreach ($option as $key2 => $value2) {
                    switch ($key2){
                        case 'monday':
                            $monday = $value2;
                            break;
                        case 'tuesday':
                            $tuesday = $value2;
                            break;
                        case 'wednesday':
                            $wednesday = $value2;
                            break;
                        case 'thursday':
                            $thursday = $value2;
                            break;
                        case 'friday':
                            $friday = $value2;
                            break;
                        case 'saturday':
                            $saturday = $value2;
                            break;
                        case 'sunday':
                            $sunday = $value2;
                            break;
                        case 'holiday':
                            $holiday = $value2;
                            break;
                    }
                }


                echo "
                <tr>
                    <td class='text-center'>{$option['affinity_site_id']}</td>
                    <td class='text-center'>{$monday}</td>
                    <td class='text-center'>{$tuesday}</td>
                    <td class='text-center'>{$wednesday}</td>
                    <td class='text-center'>{$thursday}</td>
                    <td class='text-center'>{$friday}</td>
                    <td class='text-center'>{$saturday}</td>
                    <td class='text-center'>{$sunday}</td>
                    <td class='text-center'>{$option['holiday']}</td>
                    <td class='text-center'>";

                echo '<form method="post" action="" class="inline-block">';
                echo '<input type="hidden" name="edit_working_hours" value="' . $option['affinity_site_id'] . '">';
                submit_button( 'Edit', 'primary small', '
                submit', false);
                echo '</form> ';


                echo '<form method="post" action="options.php" class="inline-block">';
                settings_fields( 'torch_working_hours_settings' );
                echo '<input type="hidden" name="remove" value="' . $option['affinity_site_id'] . '">';
                submit_button( 'Delete', 'delete small', 'submit', false, array(
                    'onclick' => 'return confirm("Are you sure you want to delete this hour?");'
                ));
                echo '</form></td></tr>';
            }

            echo '</table>';

            ?>
        </div>
        <div id="tab-2" class="tab-pane  <?php echo isset($_POST["edit_working_hours"]) ? 'active' : '' ?>">
            <h3>Create New Working hours</h3>
            <form action="options.php" method="post" class="forma">
                <?php
                settings_fields('torch_working_hours_settings');
                do_settings_sections('working_hours');
                submit_button();
                ?>
            </form>
        </div>
    </div>

</div>
<?php
