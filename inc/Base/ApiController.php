<?php
/*
 * @package TorchlightPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;

class  ApiController extends BaseController
{
    public function register()
    {
        add_action('rest_api_init', [$this, 'restApi']);
    }

    public function restApi() {
        register_rest_route( 'torchlight/v1', '/sites', array(
            'methods' => 'GET',
            'callback' =>  __CLASS__ . '::get_sites',
//            'permission_callback' => function($request){
//                return is_user_logged_in();
//            }
        ) );

        register_rest_route( 'torchlight/v1', '/hours', array(
            'methods' => 'GET',
            'callback' =>  __CLASS__ . '::get_hours',
//            'permission_callback' => function($request){
//                return is_user_logged_in();
//            }
        ) );

        register_rest_route( 'torchlight/v1', '/sites/(?P<site>[a-zA-Z0-9-]+)', array(
            'methods' => 'GET',
            'callback' =>  __CLASS__ . '::get_site',
//            'permission_callback' => function($request){
//                return is_user_logged_in();
//            }
        ) );

        register_rest_route( 'torchlight/v1', '/torch-input', array(
            'methods' => 'POST',
            'callback' =>  __CLASS__ . '::get_input',
        ) );

        register_rest_route( 'torchlight/v1', '/torch-date', array(
            'methods' => 'POST',
            'callback' =>  __CLASS__ . '::get_date',
        ) );
    }

    public function get_sites()
    {
       return get_option('torchlight_ihcaffinity_sites');
    }

    public function get_hours()
    {
        return get_option('torchlight_working_hours');
    }

    public function get_site($data)
    {
        $sites =  get_option('torchlight_ihcaffinity_sites');
        $hours =  get_option('torchlight_working_hours');
        $tous =  get_option('torchlight_tou_pp');
        $thesite = [];
        foreach ($sites as $key  => $site) {
            if($data['site'] === $key) {
                $thesite = $site;
                break;
            }
        }

        if (array_key_exists($thesite['affinity_site_working_hours'], $hours)) {
            $thesite['affinity_site_working_hours'] = $hours[$thesite['affinity_site_working_hours']];
        }
        if (array_key_exists($thesite['affinity_site_tou_pp'], $tous)) {
            $thesite['affinity_site_tou_pp'] = $tous[$thesite['affinity_site_tou_pp']];
        }

        if (empty($thesite)) {
            return new \WP_Error(
                'no_site',
                'invalid site',
                ['status' => 404]
            );
        }
        return $thesite;
    }

    public function get_input()
    {
        $nameP = $_POST['optionName'];
        $click = $_POST['click'];
        $option_name = 'torchlight_working_hours';
        $name_start =(str_replace("end","start",$nameP)) . '-' . $click;
        $name_end = $nameP . '-' . $click;
        $name_week = (str_replace("_end","",$nameP));

        $inputs = [
            0 => $nameP,
            1 => '<tr class="'.$name_end.'">
                    <th scope="row">
                        <label for="monday">Start</label>
                    </th>
                    <td>
                        <input type="time" class="regular-text" id="' . $name_start . '" name="' . $option_name . '[' . $name_week . '][]" value="00:00" placeholder=""  autocomplete="off"/>
                    </td>
                </tr>
                <tr class="'.$name_start.'">
                    <th scope="row">
                        <label for="monday">End</label>
                    </th>
                    <td>
                        <input type="time" class="regular-text" id="' . $name_end . '" name="' . $option_name . '[' . $name_week . '][]" value="00:00" placeholder=""  autocomplete="off"/>
                        <button  class="button button-small remove-wh" type="button" value="'.$name_start .' '.$name_end.'">x</button>
                    </td>
                </tr>
                '];
        return json_encode($inputs);
    }

    public function get_date()
    {
        $name = $_POST['optionName'];
        $click = $_POST['click'];
        $id = $name . '-' . $click;
        $option_name = 'torchlight_working_hours';
        $nameV = 'holiday';

        $inputs = [
            0 => $name,
            1 => '<tr class="'.$id.'">
                    <th scope="row">
                        <label for="'. $id .'">Holiday</label>
                    </th>
                    <td>
                        <input type="text" class="regular-text datepicker" id="' . $id . '" name="' . $option_name . '[' . $nameV . '][]" value=""   autocomplete="off"/>
                        <button  class="button button-small remove-wh" type="button" value="' . $id . '">x</button>
                    </td>
                </tr>
               
                '];
        return json_encode($inputs);
    }
}