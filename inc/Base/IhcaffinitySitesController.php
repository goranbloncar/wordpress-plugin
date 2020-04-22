<?php
/*
 * @package TorchlightPlugin
 */
namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\IhcaffinitySitesCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class IhcaffinitySitesController extends BaseController
{
    public $callbacks;
    public $ihcaffinity_sites_callbacks;
    public $settings;
    public $subpages = [];

    public function register()
    {
        if( ! $this->activated('ihcaffinity_sites_manager') ) {
            return;
        }

        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->ihcaffinity_sites_callbacks = new IhcaffinitySitesCallbacks();
        $this->setSubpages();
        $this->setSettings();
        $this->setSections();
        $this->setFields();
        $this->settings->addSubPages($this->subpages)->register();
    }
    public function setSubpages(){
        $this->subpages = [
            [
                'parent_slug' => 'torchlight',
                'page_title' => 'Ihcaffinity sites',
                'menu_title' => 'Ihcaffinity sites',
                'capability' => 'manage_options',
                'menu_slug' => 'ihcaffinity_sites',
                'callback' => [$this->callbacks, 'adminIhcAffinitySites'],
            ]
        ];
    }

    public function setSettings()
    {
        $args = [
            [
                'option_group' => 'torch_ihcaffinity_sites_settings',
                'option_name' => 'torchlight_ihcaffinity_sites' ,
                'callback' => [$this->ihcaffinity_sites_callbacks, 'ihcaffinitySitesSanitize']
            ]
        ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => 'torch_ihcaffinity_sites_index',
                'title' => '',
                'callback' => [ $this->ihcaffinity_sites_callbacks, 'ihcaffinitySitesSectionManager'],
                'page' => 'ihcaffinity_sites'
            ]
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [
            [
                'id' => 'affinity_site_name',
                'title' => 'Name',
                'callback' => array( $this->ihcaffinity_sites_callbacks, 'textField' ),
                'page' => 'ihcaffinity_sites',
                'section' => 'torch_ihcaffinity_sites_index',
                'args' => [
                    'option_name' => 'torchlight_ihcaffinity_sites',
                    'label_for' => 'affinity_site_name',
                    'placeholder' => 'Affinity site Name'
                ]
            ],
            [
                'id' => 'affinity_site_link',
                'title' => 'Link',
                'callback' => array( $this->ihcaffinity_sites_callbacks, 'urlField' ),
                'page' => 'ihcaffinity_sites',
                'section' => 'torch_ihcaffinity_sites_index',
                'args' => [
                    'option_name' => 'torchlight_ihcaffinity_sites',
                    'label_for' => 'affinity_site_link',
                    'placeholder' => 'Link'
                ]
            ],
            [
                'id' => 'affinity_site_phone',
                'title' => 'Phone',
                'callback' => array( $this->ihcaffinity_sites_callbacks, 'phoneField' ),
                'page' => 'ihcaffinity_sites',
                'section' => 'torch_ihcaffinity_sites_index',
                'args' => [
                    'option_name' => 'torchlight_ihcaffinity_sites',
                    'label_for' => 'affinity_site_phone',
                    'placeholder' => 'Phone'
                ]
            ],
            [
                'id' => 'affinity_site_logo',
                'title' => 'Logo',
                'callback' => array( $this->ihcaffinity_sites_callbacks, 'imageField' ),
                'page' => 'ihcaffinity_sites',
                'section' => 'torch_ihcaffinity_sites_index',
                'args' => [
                    'option_name' => 'torchlight_ihcaffinity_sites',
                    'label_for' => 'affinity_site_logo',
                    'placeholder' => 'Logo'
                ]
            ],
            [
                'id' => 'affinity_site_color_primary',
                'title' => 'Primary Color',
                'callback' => array( $this->ihcaffinity_sites_callbacks, 'colorField' ),
                'page' => 'ihcaffinity_sites',
                'section' => 'torch_ihcaffinity_sites_index',
                'args' => [
                    'option_name' => 'torchlight_ihcaffinity_sites',
                    'label_for' => 'affinity_site_color_primary',
                    'placeholder' => '#ffffff'
                ]
            ],
            [
                'id' => 'affinity_site_color_secondary',
                'title' => 'Secondary Color',
                'callback' => array( $this->ihcaffinity_sites_callbacks, 'colorField' ),
                'page' => 'ihcaffinity_sites',
                'section' => 'torch_ihcaffinity_sites_index',
                'args' => [
                    'option_name' => 'torchlight_ihcaffinity_sites',
                    'label_for' => 'affinity_site_color_secondary',
                    'placeholder' => '#ffffff'
                ]
            ],
            [
                'id' => 'affinity_site_tou_pp',
                'title' => 'Privacy Policy And Terms of Use',
                'callback' => array( $this->ihcaffinity_sites_callbacks, 'selectTouPpField' ),
                'page' => 'ihcaffinity_sites',
                'section' => 'torch_ihcaffinity_sites_index',
                'args' => [
                    'option_name' => 'torchlight_ihcaffinity_sites',
                    'label_for' => 'affinity_site_tou_pp',
                    'placeholder' => 'Privacy Policy And Terms of Use'
                ]
            ],
            [
                'id' => 'affinity_site_working_hours',
                'title' => 'Working Hours Name',
                'callback' => array( $this->ihcaffinity_sites_callbacks, 'selectWorkingHoursField' ),
                'page' => 'ihcaffinity_sites',
                'section' => 'torch_ihcaffinity_sites_index',
                'args' => [
                    'option_name' => 'torchlight_ihcaffinity_sites',
                    'label_for' => 'affinity_site_working_hours',
                    'placeholder' => 'Working hours name'
                ]
            ],

        ];

        $this->settings->setFields($args);

    }

}
