<?php
/*
 * @package TorchlightPlugin
 */

namespace Inc\Api\Callbacks;

class TouPpCallbacks
{

    public function touPpSectionManager()
    {
//        echo 'Manage Terms of Use and Privacy Policy';
    }

    public function touPpSanitize($input)
    {

        $output = get_option('torchlight_tou_pp');

        if ( isset($_POST["remove"]) ) {
            unset($output[$_POST["remove"]]);

            return $output;
        }

        if ( count($output) == 0 ) {
            $output[$input['site_id']] = $input;

            return $output;
        }

        if(isset($_POST['privacy_policy']) ){
            $_POST['torchlight_tou_pp']['privacy_policy'] = $_POST['privacy_policy'];
        }

        if(isset($_POST['terms_of_use']) ){
            $_POST['torchlight_tou_pp']['terms_of_use'] = $_POST['terms_of_use'];
        }

        foreach ($output as $key => $value) {
            if ($input['post_type'] === $key) {
                $output[$key] = $_POST['torchlight_tou_pp'];
            } else {
                $output[$input['site_id']] = $_POST['torchlight_tou_pp'];;
            }
        }
        return $output;
    }

    public function textField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if ( isset($_POST["edit_tou_pp"]) ) {
            $input = get_option( $option_name );
            $value = $input[$_POST["edit_tou_pp"]][$name];
        }

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required />';
    }


    public function textAreaField($args)
    {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if ( isset($_POST["edit_tou_pp"]) ) {
            $input = get_option( $option_name );
            $value = $input[$_POST["edit_tou_pp"]][$name];
        }
        $name = $args['textarea_name'];

        wp_editor( $value, $name, $settings = $args );
    }
}
