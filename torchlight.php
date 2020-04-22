<?php
/*
 * @package TorchlightPlugin
 */
/*
Plugin Name: TorchlightPlugin
Plugin URI: https://torchlighttechnology.com
Description: Plugin for time and custom fields management
Version: 1.0.0
Author: Torchlight
License: GPLv2 or later
Text Domain: torchlight
 */

defined( 'ABSPATH' ) or die( 'Hey, you can\t access this file, you silly human!' );

if(file_exists(dirname(__FILE__) . '/vendor/autoload.php')){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function activate_torchlight_plugin()
{
    \Inc\Base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_torchlight_plugin');

function deactivate_torchlight_plugin()
{
    \Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_torchlight_plugin');

if(class_exists('Inc\\Init')){
    Inc\Init::register_services();
}