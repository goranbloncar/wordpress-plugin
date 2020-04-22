<div class="wrap">
    <h1>Torchlight Plugin</h1>
    <?php settings_errors();?>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Manage Settings</a></li>
        <li class="active"><a href="#tab-2">Release Button</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <form action="options.php" method="post">
                <?php
                settings_fields('torch_settings');
                do_settings_sections('torchlight');
                submit_button();
                ?>
            </form>
        </div>
        <div id="tab-2" class="tab-pane">
            <h1>Realse button to push all changes to AWS</h1>
<!--             <form method="post">-->
<!--                 <input type="hidden" name="GO" value="rebuild"><button>REBUILD</button></form>-->
        </div>
    </div>

</div>

<?php
///**
// * Plugin Name: AWS Rebuild
// * Plugin URI: https://rebuild
// * Description: Rebuild the Site
// * Version: 1.0
// * Author: Carl
// * Author URI: https://www.torchlighttechnology.com
// */
//add_action('admin_menu', 'aws_rebuild');
//function aws_rebuild(){
//    add_menu_page( 'AWS Rebuild', 'AWS Rebuild Site', 'manage_options', 'aws-rebuild', 'rebuild_init' );
//}
//function rebuild_init(){
//    if($_POST['GO'] == 'rebuild'){
//        echo '<h1>REBUILDING PET PLACE</h1>';
//        $url = 'https://t15i2bpr3h.execute-api.us-east-1.amazonaws.com/prod';
//        $data = array("name" => "pet-place-production");
//        $data_string = json_encode($data);
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'Content-Type: application/json',
//                'Content-Length: ' . strlen($data_string))
//        );
//        $result = curl_exec($ch);
//        print_r($result);
//    }
//    echo '<form method="post"><input type="hidden" name="GO" value="rebuild"><button>REBUILD</button></form>';
//}