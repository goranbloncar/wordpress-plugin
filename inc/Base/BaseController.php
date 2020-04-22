<?php

/*
 * @package TorchlightPlugin
 */

namespace Inc\Base;

class BaseController
{
    public $plugin_path;
    public $plugin_url;
    public $plugin;
    public $basename;
    public $managers = [];

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin = plugin_basename(dirname(__FILE__, 3)) . '/torchlight.php';
        $this->basename = $_SERVER['SERVER_NAME'];

        $this->managers = [
            'working_hours_manager' => 'Activate Working Hours Manager',
            'ihcaffinity_sites_manager' => 'Activate Ihcaffinity Manager',
            'tou_pp_manager' => 'Activate Terms Of Use and Privacy Policy Manager',
        ];

    }

    public function activated(string $key)
    {
        $option = get_option( 'torchlight' );
        return isset($option[$key]) ? $option[$key] : false;
    }


}