<?php
/*
 * @package TorchlightPlugin
 */
namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\TouPpCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class TouPpController extends BaseController
{

    public $callbacks;
    public $tou_pp_callbacks;
    public $settings;
    public $subpages = [];

    public function register()
    {
        if( ! $this->activated('tou_pp_manager') ) {
            return;
        }
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->tou_pp_callbacks = new TouPpCallbacks();
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
                'page_title' => 'Terms of Use and Privacy Policy',
                'menu_title' => 'Terms of Use and Privacy Policy',
                'capability' => 'manage_options',
                'menu_slug' => 'tou_pp',
                'callback' => [$this->callbacks, 'adminTouPp'],
            ]
        ];
    }

    public function setSettings()
    {
        $args = [
            [
                'option_group' => 'torch_tou_pp_settings',
                'option_name' => 'torchlight_tou_pp' ,
                'callback' => [$this->tou_pp_callbacks, 'touPpSanitize']
            ]
        ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => 'torch_tou_pp_index',
                'title' => 'Terms of Use and Privacy Policy Manager',
                'callback' => [ $this->tou_pp_callbacks, 'touPpSectionManager'],
                'page' => 'tou_pp'
            ]
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [
            [
                'id' => 'site_id',
                'title' => 'Name',
                'callback' => array( $this->tou_pp_callbacks, 'textField' ),
                'page' => 'tou_pp',
                'section' => 'torch_tou_pp_index',
                'args' => [
                    'option_name' => 'torchlight_tou_pp',
                    'label_for' => 'site_id',
                    'placeholder' => 'Site name'
                ]
            ],
            [
                'id' => 'privacy_policy',
                'title' => 'Privacy Policy',
                'callback' => array( $this->tou_pp_callbacks, 'textareaField' ),
                'page' => 'tou_pp',
                'section' => 'torch_tou_pp_index',
                'args' => [
                    'option_name' => 'torchlight_tou_pp',
                    'textarea_name' => 'privacy_policy',
                    'textarea_rows' => 10,
                    'editor_height' => 300,
                    'label_for' => 'privacy_policy',
//                    'placeholder' => 'Privacy Policy',
//                    'textarea_rows' => 15,
                ]
            ],
            [
                'id' => 'terms_of_use',
                'title' => 'Terms Of Use',
                'callback' => array( $this->tou_pp_callbacks, 'textareaField' ),
                'page' => 'tou_pp',
                'section' => 'torch_tou_pp_index',
                'args' => [
                    'option_name' => 'torchlight_tou_pp',
                    'textarea_name' => 'terms_of_use',
                    'textarea_rows' => 10,
                    'editor_height' => 300,
                    'label_for' => 'terms_of_use',
//                    'placeholder' => 'Terms Of Use'
                ]
            ],
        ];

        $this->settings->setFields($args);

    }
}