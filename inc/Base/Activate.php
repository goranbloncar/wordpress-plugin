<?php
/*
 * @package TorchlightPlugin
 */

namespace Inc\Base;

class Activate
{
    public static function activate()
    {
        flush_rewrite_rules();
        $default = [];
        if(! get_option('torchlight')) {
            update_option('torchlight', $default);
        }

//        delete_option($option);

        if(! get_option('torchlight_working_hours')) {
            update_option('torchlight_working_hours', $default);
        }

        if(! get_option('torchlight_ihcaffinity_sites')) {
            update_option('torchlight_ihcaffinity_sites', $default);
        }

        if(! get_option('torchlight_tou_pp')) {
            update_option('torchlight_tou_pp', $default);
        }

    }
}
