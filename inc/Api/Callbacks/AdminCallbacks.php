<?php
/*
 * @package TorchlightPlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
    public function adminDashboard() {
        return require_once($this->plugin_path . '/templates/admin.php');
    }

    public function adminWorkingHours() {
        return require_once($this->plugin_path . '/templates/workingHours.php');
    }

    public function adminIhcAffinitySites() {
        return require_once($this->plugin_path . '/templates/ihcaffinitySites.php');
    }

    public function adminTouPp() {
        return require_once($this->plugin_path . '/templates/touPp.php');
    }
}