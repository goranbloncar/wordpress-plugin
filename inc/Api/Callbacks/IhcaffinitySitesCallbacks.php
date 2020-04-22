<?php
/*
 * @package TorchlightPlugin
 */

namespace Inc\Api\Callbacks;

class IhcaffinitySitesCallbacks
{

    public function ihcaffinitySitesSectionManager()
    {
//        echo 'Manage IhcAffinity sites';
    }

    public function ihcaffinitySitesSanitize($input)
    {
        $output = get_option('torchlight_ihcaffinity_sites');
        if (isset($_POST["remove"])) {
            unset($output[$_POST["remove"]]);

            return $output;
        }

        if (count($output) == 0) {
            $output[$input['affinity_site_name']] = $input;

            return $output;
        }

        foreach ($output as $key => $value) {
            if ($input['post_type'] === $key) {
                $output[$key] = $input;
            } else {
                $output[$input['affinity_site_name']] = $input;
            }
        }
        return $output;
    }

    public function textField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if (isset($_POST["edit_ihcaffinity_sites"])) {
            $input = get_option($option_name);
            $value = $input[$_POST["edit_ihcaffinity_sites"]][$name];
        }

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '"  />';
    }

    public function phoneField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if (isset($_POST["edit_ihcaffinity_sites"])) {
            $input = get_option($option_name);
            $value = $input[$_POST["edit_ihcaffinity_sites"]][$name];
        }

        echo '<input type="tel" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '"  />';
    }

    public function urlField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if (isset($_POST["edit_ihcaffinity_sites"])) {
            $input = get_option($option_name);
            $value = $input[$_POST["edit_ihcaffinity_sites"]][$name];
        }

        echo '<input type="url" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '"  />';
    }

    public function colorField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if (isset($_POST["edit_ihcaffinity_sites"])) {
            $input = get_option($option_name);
            $value = $input[$_POST["edit_ihcaffinity_sites"]][$name];
        }

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$"/>';
    }

    public function imageField($args)
    {

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if (isset($_POST["edit_ihcaffinity_sites"])) {
            $input = get_option($option_name);
            $value = $input[$_POST["edit_ihcaffinity_sites"]][$name];
        }

        echo '<input type="text" class="regular-text image-upload" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '"  />';
        echo '<button type="button" class="button button-primary image-upload">Select Image</button>';
    }

    public function selectTouPpField($args)
    {
        $touPp = get_option('torchlight_tou_pp');

        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];
        $selected = false;
        if (isset($_POST["edit_ihcaffinity_sites"])) {
            $input = get_option($option_name);
            $value = $input[$_POST["edit_ihcaffinity_sites"]][$name];
            $id = $input[$_POST["edit_ihcaffinity_sites"]]['affinity_site_name'];
            $selected = isset($input[$id][$name]) ? 'selected':false;
        }

        echo '<div class="' . $classes . '">
                <select id="' . $name . '" name="' . $option_name . '[' . $name . ']">
                  <option value="">Select</option>';
        foreach ($touPp as $key => $value) {
            echo '<option value="'.$value['site_id'].'" ' . $selected . '>'.$value['site_id'].'</option>';
        }
         echo     '</select><label for="' . $name . '"><div></div></label></div>';
    }

    public function selectWorkingHoursField($args)
    {
        $workingHours = get_option('torchlight_working_hours');
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];
        $selected = false;
        if (isset($_POST["edit_ihcaffinity_sites"])) {
            $input = get_option($option_name);
            $value = $input[$_POST["edit_ihcaffinity_sites"]][$name];
            $id = $input[$_POST["edit_ihcaffinity_sites"]]['affinity_site_name'];
            $selected = isset($input[$id][$name]) ? 'selected':false;
        }

        echo '<div class="' . $classes . '">
                <select id="' . $name . '" name="' . $option_name . '[' . $name . ']">
                  <option value="">Select</option>';
        foreach ($workingHours as $key => $value) {
            echo '<option value="'.$value['affinity_site_id'].'" '.$selected.'>'.$value['affinity_site_id'].'</option>';
        }
        echo     '</select><label for="' . $name . '"><div></div></label></div>';
    }
}
