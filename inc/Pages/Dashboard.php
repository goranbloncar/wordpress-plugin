<?php
/*
 * @package TorchlightPlugin
 */

namespace Inc\Pages;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;
use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;

class Dashboard extends BaseController
{
    public $settings;
    public $callbacks;
    public $callbacks_mngr;
    public $pages = [];

    public function register()
    {
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->callbacks_mngr = new ManagerCallbacks();
        $this->setPages();
        $this->setSettings();
        $this->setSections();
        $this->setFields();
        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
    }

    public function setPages()
    {
        $this->settings = new SettingsApi();

        $this->pages = [
            [
                'page_title' => 'Torchlight',
                'menu_title' => 'Torchlight',
                'capability' => 'manage_options',
                'menu_slug' => 'torchlight',
                'callback' => [$this->callbacks, 'adminDashboard'],
                'icon_url' => 'dashicons-store',
                'position' => 110
            ]
        ];
    }

    public function setSettings()
    {
        $args = [
            [
                'option_group' => 'torch_settings',
                'option_name' => 'torchlight' ,
                'callback' => [$this->callbacks_mngr, 'checkboxSanitize']
            ]
        ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => 'torch_admin_index',
                'title' => 'Settings Manager',
                'callback' => [ $this->callbacks_mngr, 'adminSectionManager'],
                'page' => 'torchlight'
            ],
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [];

        foreach ( $this->managers as $key=>$value) {
            $args[] = [
                'id' => $key,
                'title' => $value,
                'callback' => [ $this->callbacks_mngr, 'checkboxField'],
                'page' => 'torchlight',
                'section' => 'torch_admin_index',
                'args' => [
                    'option_name' => 'torchlight',
                    'label_for' => $key,
                    'class' => 'ui-toggle'
                ]
            ];
        }

        $this->settings->setFields($args);
    }
}
