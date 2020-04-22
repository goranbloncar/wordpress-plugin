<?php
/*
 * @package TorchlightPlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class WorkingHoursCallbacks
{

    public function workingHoursSectionManager()
    {
//        echo 'Manage hours on IhcAffinity sites';
    }

    public function workingHoursSanitize($input)
    {

        $output = get_option('torchlight_working_hours');

        if ( isset($_POST["remove"]) ) {
            unset($output[$_POST["remove"]]);

            return $output;
        }

        if ( count($output) == 0 ) {
            $output[$input['affinity_site_id']] = $input;

            return $output;
        }
        foreach ($input as $key => $value) {

            if ($key !== 'affinity_site_id') {
                $input[$key] = implode(',', $value);
            }
        }

        foreach ($output as $key => $value) {
            if ($input['post_type'] === $key) {
                $output[$key] = $input;
            } else {
                $output[$input['affinity_site_id']] = $input;
            }
        }


        return $output;
    }

    public function textField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if ( isset($_POST["edit_working_hours"]) ) {
            $input = get_option( $option_name );
            $value = $input[$_POST["edit_working_hours"]][$name];
        }

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required />';
    }

    public function numberStartField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '00:00';
        switch ($name){
            case (strpos($name,'monday') !== false ):
                $name_week = 'monday';
                break;
            case (strpos($name,'tuesday') !== false):
                $name_week = 'tuesday';
                break;
            case (strpos($name,'wednesday') !== false):
                $name_week = 'wednesday';
                break;
            case (strpos($name,'thursday') !== false):
                $name_week = 'thursday';
                break;
            case (strpos($name,'friday') !== false):
                $name_week = 'friday';
                break;
            case (strpos($name,'saturday') !== false):
                $name_week = 'saturday';
                break;
            case (strpos($name,'sunday') !== false):
                $name_week = 'sunday';
                break;
            case 'holiday':
                break;
        }
        if ( isset($_POST["edit_working_hours"]) ) {
            $input = get_option( $option_name );
            $value = $args['value'];
            $key = $args['key'];
        }
            echo '<input type="time" class="regular-text add-field" id="' . $name . '" name="' . $option_name . '[' . $name_week . '][]" value="' . $value . '" placeholder="' . $args['placeholder'] . '"  autocomplete="off"/>';
    }

    public function numberEndField($args)
    {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '00:00';
        switch ($name){
            case (strpos($name,'monday') !== false ):
                $name_week = 'monday';
                break;
            case (strpos($name,'tuesday') !== false):
                $name_week = 'tuesday';
                break;
            case (strpos($name,'wednesday') !== false):
                $name_week = 'wednesday';
                break;
            case (strpos($name,'thursday') !== false):
                $name_week = 'thursday';
                break;
            case (strpos($name,'friday') !== false):
                $name_week = 'friday';
                break;
            case (strpos($name,'saturday') !== false):
                $name_week = 'saturday';
                break;
            case (strpos($name,'sunday') !== false):
                $name_week = 'sunday';
                break;
            case 'holiday':
                break;
        }

        if ( isset($_POST["edit_working_hours"]) ) {
            $input = get_option( $option_name );
            $value = $args['value'];
        }

        echo '<input type="time" class="regular-text add-field" id="' . $name . '" name="' . $option_name . '[' . $name_week . '][]" value="' . $value . '" placeholder="' . $args['placeholder'] . '"  autocomplete="off"/>';
        echo '<button class="button button-primary button-small add-wh" type="button" value="' . $name . '">+</button>';
    }

    public function dateField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        $nameV = 'holiday';

        if ( isset($_POST["edit_working_hours"]) ) {
            $input = get_option( $option_name );
            $value = $args['value'];
        }
        echo '<input type="text" class="regular-text datepicker" id="' . $name . '" name="' . $option_name . '[' . $nameV . '][]" value="' . $value . '"   autocomplete="off"/>';
        echo '<button class="button button-primary button-small add-date" type="button" value="' . $name . '">+</button>';
    }
}
