<?php

/*
 * @package TorchlightPlugin
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\WorkingHoursCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

class WorkingHoursController extends BaseController
{
    public $callbacks;
    public $working_hours_callbacks;
    public $settings;
    public $subpages = [];
    public $working_hours_posts = [];

    public function register()
    {
        if( ! $this->activated('working_hours_manager') ) {
            return;
        }
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->working_hours_callbacks = new WorkingHoursCallbacks();
        $this->setSubpages();
        $this->setSettings();
        $this->setSections();
        $this->setFields();
        $this->settings->addSubPages($this->subpages)->register();
        //here we can activate/inactivate posts
//        $this->storeWorkingHoursPosts();
        if(! empty($this->working_hours_posts)) {
            add_action('init', [ $this, 'registerWorkingHours']);
        }
    }

    public function setSubpages(){
        $this->subpages = [
            [
                'parent_slug' => 'torchlight',
                'page_title' => 'Working Hours',
                'menu_title' => 'Working Hours',
                'capability' => 'manage_options',
                'menu_slug' => 'working_hours',
                'callback' => [$this->callbacks, 'adminWorkingHours'],
            ],
        ];
    }

    public function setSettings()
    {
        $args = [
            [
                'option_group' => 'torch_working_hours_settings',
                'option_name' => 'torchlight_working_hours' ,
                'callback' => [$this->working_hours_callbacks, 'workingHoursSanitize']
            ]
        ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => 'torch_working_hours_index',
                'title' => '',
                'callback' => [ $this->working_hours_callbacks, 'workingHoursSectionManager'],
                'page' => 'working_hours'
            ],
            [
                'id' => 'torch_working_hours_monday',
                'title' => 'Monday',
                'callback' => '',
                'page' => 'working_hours'
            ],
            [
                'id' => 'torch_working_hours_tuesday',
                'title' => 'Tuesday',
                'callback' => '',
                'page' => 'working_hours'
            ],
            [
                'id' => 'torch_working_hours_wednesday',
                'title' => 'Wednesday',
                'callback' => '',
                'page' => 'working_hours'
            ],
            [
                'id' => 'torch_working_hours_thursday',
                'title' => 'Thursday',
                'callback' => '',
                'page' => 'working_hours'
            ],
            [
                'id' => 'torch_working_hours_friday',
                'title' => 'Friday',
                'callback' => '',
                'page' => 'working_hours'
            ],
            [
                'id' => 'torch_working_hours_saturday',
                'title' => 'Saturday',
                'callback' => '',
                'page' => 'working_hours'
            ],
            [
                'id' => 'torch_working_hours_sunday',
                'title' => 'Sunday',
                'callback' => '',
                'page' => 'working_hours'
            ],
            [
                'id' => 'torch_working_holidays',
                'title' => 'Holidays',
                'callback' => '',
                'page' => 'working_hours'
            ],
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {

        if (isset($_POST['edit_working_hours'])) {
            $args = [];
            $all = get_option('torchlight_working_hours');
            $fields = $all[$_POST['edit_working_hours']];
            $args = [];
            foreach ($fields as $key => $field) {
                switch ($key) {
                    case 'affinity_site_id':
                        $args[] = [
                            'id' => 'affinity_site_id',
                            'title' => 'Affinity Site Id',
                            'callback' => array( $this->working_hours_callbacks, 'textField' ),
                            'page' => 'working_hours',
                            'section' => 'torch_working_hours_index',
                            'args' => [
                                'option_name' => 'torchlight_working_hours',
                                'label_for' => 'affinity_site_id',
                                'placeholder' => 'Affinity site id'
                            ]
                        ];
                        break;
                    case 'monday':
                        $mondays = explode(',', $field);
                        foreach ($mondays as $key2 => $monday) {
                            if($key2%2 == 0){
                                $monday_start = [
                                    'id' => 'monday_start_' . $key2,
                                    'title' => 'Start',
                                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_monday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'monday_start_' . $key2,
                                        'placeholder' => 'Monday',
                                        'value' => $monday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $monday_start);
                            } else {
                                $monday_end = [
                                    'id' => 'monday_end_' . $key2,
                                    'title' => 'End',
                                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_monday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'monday_end_' . $key2,
                                        'placeholder' => 'Monday',
                                        'value' => $monday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $monday_end);
                            }
                        }
                        break;
                    case 'tuesday':
                        $tuesdays = explode(',', $field);
                        foreach ($tuesdays as $key2 => $tuesday) {
                            if($key2%2 == 0) {
                                $tuesday_start = [
                                    'id' => 'tuesday_start_' . $key2,
                                    'title' => 'start',
                                    'callback' => array($this->working_hours_callbacks, 'numberStartField'),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_tuesday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'tuesday_start_' . $key2,
                                        'placeholder' => 'Tuesday',
                                        'value' => $tuesday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $tuesday_start);
                            } else {
                                $tuesday_end = [
                                    'id' => 'tuesday_end_' . $key2,
                                    'title' => 'end',
                                    'callback' => array($this->working_hours_callbacks, 'numberEndField'),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_tuesday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'tuesday_end_' . $key2,
                                        'placeholder' => 'Tuesday',
                                        'value' => $tuesday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $tuesday_end);
                            }
                        }
                        break;
                    case 'wednesday':
                        $wednesdays = explode(',', $field);
                        foreach ($wednesdays as $key2 => $wednesday) {
                            if($key2%2 == 0) {
                                $wednesday_start = [
                                    'id' => 'wednesday_start_' . $key2,
                                    'title' => 'Start',
                                    'callback' => array($this->working_hours_callbacks, 'numberStartField'),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_wednesday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'wednesday_start_' . $key2,
                                        'placeholder' => 'wednesday',
                                        'value' => $wednesday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $wednesday_start);
                            } else {
                                $wednesday_end = [
                                    'id' => 'wednesday_end_' . $key2,
                                    'title' => 'End',
                                    'callback' => array($this->working_hours_callbacks, 'numberEndField'),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_wednesday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'wednesday_end_' . $key2,
                                        'placeholder' => 'wednesday',
                                        'value' => $wednesday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $wednesday_end);
                            }
                        }
                        break;
                    case 'thursday':
                        $thursdays = explode(',', $field);
                        foreach ($thursdays as $key2 => $thursday) {
                            if($key2%2 == 0) {
                                $thursday_start = [
                                    'id' => 'thursday_start_' . $key2,
                                    'title' => 'Start',
                                    'callback' => array($this->working_hours_callbacks, 'numberStartField'),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_thursday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'thursday_start_' . $key2,
                                        'placeholder' => 'thursday',
                                        'value' => $thursday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $thursday_start);
                            } else {
                                $thursday_end = [
                                    'id' => 'thursday_end_' . $key2,
                                    'title' => 'End',
                                    'callback' => array($this->working_hours_callbacks, 'numberEndField'),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_thursday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'thursday_end_' . $key2,
                                        'placeholder' => 'thursday',
                                        'value' => $thursday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $thursday_end);
                            }
                        }
                        break;
                    case 'friday':
                        $fridays = explode(',', $field);
                        foreach ($fridays as $key2 => $friday) {
                            if($key2%2 == 0) {
                                $friday_start = [
                                    'id' => 'friday_start_' . $key2,
                                    'title' => '',
                                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_friday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'friday_start_' . $key2,
                                        'placeholder' => 'friday',
                                        'value' => $friday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $friday_start);
                            } else {
                                $friday_end = [
                                    'id' => 'friday_end_' . $key2,
                                    'title' => '',
                                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_friday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'friday_end_' . $key2,
                                        'placeholder' => 'friday',
                                        'value' => $friday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $friday_end);
                            }

                        }
                        break;
                    case 'saturday':
                        $saturdays = explode(',', $field);
                        foreach ($saturdays as $key2 => $saturday) {
                            if($key2%2 == 0) {
                                $saturday_start = [
                                    'id' => 'saturday_start_' . $key2,
                                    'title' => '',
                                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_saturday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'saturday_start_' . $key2,
                                        'placeholder' => 'saturday',
                                        'value' => $saturday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $saturday_start);
                            } else {
                                $saturday_end = [
                                    'id' => 'saturday_end_' . $key2,
                                    'title' => '',
                                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_saturday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'saturday_end_' . $key2,
                                        'placeholder' => 'saturday',
                                        'value' => $saturday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $saturday_end);
                            }

                        }
                        break;
                    case 'sunday':
                        $sundays = explode(',', $field);
                        foreach ($sundays as $key2 => $sunday) {
                            if($key2%2 == 0) {
                                $sunday_start = [
                                    'id' => 'sunday_start_' . $key2,
                                    'title' => '',
                                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_sunday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'sunday_start_' . $key2,
                                        'placeholder' => 'sunday',
                                        'value' => $sunday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $sunday_start);
                            } else {
                                $sunday_end = [
                                    'id' => 'sunday_end_' . $key2,
                                    'title' => '',
                                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                                    'page' => 'working_hours',
                                    'section' => 'torch_working_hours_sunday',
                                    'args' => [
                                        'option_name' => 'torchlight_working_hours',
                                        'label_for' => 'sunday_end_' . $key2,
                                        'placeholder' => 'sunday',
                                        'value' => $sunday,
                                        'key' => $key2
                                    ]
                                ];
                                array_push($args, $sunday_end);
                            }

                        }
                        break;
                    case 'holiday':
                        $holidays = explode(',', $field);
                        foreach ($holidays as $key2 => $holiday) {
                            $holiday = [
                                'id' => 'holiday' . $key2,
                                'title' => 'Holiday',
                                'callback' => array( $this->working_hours_callbacks, 'dateField' ),
                                'page' => 'working_hours',
                                'section' => 'torch_working_holidays',
                                'args' => [
                                    'option_name' => 'torchlight_working_hours',
                                    'label_for' => 'holiday' . $key2,
                                    'placeholder' => '',
                                    'value' => $holiday,
                                    'key' => $key2
                                ]
                            ];
                            array_push($args, $holiday);
                        }
                        break;
                    default:
                }
            }
        } else {
            $args = [
                [
                    'id' => 'affinity_site_id',
                    'title' => 'Affinity Site Id',
                    'callback' => array( $this->working_hours_callbacks, 'textField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_index',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'affinity_site_id',
                        'placeholder' => 'Affinity site id'
                    ]
                ],
                [
                    'id' => 'monday_start',
                    'title' => 'Start',
                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_monday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'monday_start',
                        'placeholder' => 'Monday Start'
                    ]
                ],
                [
                    'id' => 'monday_end',
                    'title' => 'End',
                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_monday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'monday_end',
                        'placeholder' => 'Monday End'
                    ]
                ],
                [
                    'id' => 'tuesday_start',
                    'title' => 'Start',
                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_tuesday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'tuesday_start',
                        'placeholder' => 'Tuesday Start'
                    ]
                ],
                [
                    'id' => 'tuesday_end',
                    'title' => 'Tuesday',
                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_tuesday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'tuesday_end',
                        'placeholder' => 'Tuesday'
                    ]
                ],
                [
                    'id' => 'wednesday_start',
                    'title' => 'Start',
                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_wednesday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'wednesday_start',
                        'placeholder' => 'Wednesday'
                    ]
                ],
                [
                    'id' => 'wednesday_end',
                    'title' => 'Wednesday',
                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_wednesday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'wednesday_end',
                        'placeholder' => 'Wednesday'
                    ]
                ],
                [
                    'id' => 'thursday_start',
                    'title' => 'Start',
                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_thursday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'thursday_start',
                        'placeholder' => 'Thursday'
                    ]
                ],
                [
                    'id' => 'thursday_end',
                    'title' => 'End',
                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_thursday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'thursday_end',
                        'placeholder' => 'Thursday'
                    ]
                ],
                [
                    'id' => 'friday_start',
                    'title' => 'Start',
                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_friday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'friday_start',
                        'placeholder' => 'Friday'
                    ]
                ],
                [
                    'id' => 'friday_end',
                    'title' => 'End',
                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_friday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'friday_end',
                        'placeholder' => 'Friday'
                    ]
                ],
                [
                    'id' => 'saturday_start',
                    'title' => 'Start',
                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_saturday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'saturday_start',
                        'placeholder' => 'Saturday'
                    ]
                ],
                [
                    'id' => 'saturday_end',
                    'title' => 'End',
                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_saturday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'saturday_end',
                        'placeholder' => 'Saturday'
                    ]
                ],
                [
                    'id' => 'sunday_start',
                    'title' => 'Start',
                    'callback' => array( $this->working_hours_callbacks, 'numberStartField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_sunday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'sunday_start',
                        'placeholder' => 'Sunday'
                    ]
                ],
                [
                    'id' => 'sunday_end',
                    'title' => 'End',
                    'callback' => array( $this->working_hours_callbacks, 'numberEndField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_hours_sunday',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'sunday_end',
                        'placeholder' => 'Sunday'
                    ]
                ],
                [
                    'id' => 'holiday',
                    'title' => 'Holiday',
                    'callback' => array( $this->working_hours_callbacks, 'dateField' ),
                    'page' => 'working_hours',
                    'section' => 'torch_working_holidays',
                    'args' => [
                        'option_name' => 'torchlight_working_hours',
                        'label_for' => 'holiday',
                        'placeholder' => ''
                    ]
                ],
            ];
        }


        $this->settings->setFields($args);

    }

    public function storeWorkingHoursPosts()
    {
        $options = get_option('torchlight_working_hours') ?: [];

//        foreach ($options as $option) {
//
//            $this->working_hours_posts[] = [
//                'post_type'             => $option['affinity_site_id'],
//                'name'                  => $option['affinity_site_id'],
//                'singular_name'         => $option['affinity_site_id'],
//                'menu_name'             => $option['affinity_site_id'],
//                'name_admin_bar'        => $option['affinity_site_id'],
//                'archives'              => $option['affinity_site_id'] . ' Archives',
//                'attributes'            => $option['affinity_site_id'] . ' Attributes',
//                'parent_item_colon'     => 'Parent ' . $option['affinity_site_id'],
//                'all_items'             => 'All ' . $option['affinity_site_id'],
//                'add_new_item'          => 'Add New ' . $option['affinity_site_id'],
//                'add_new'               => 'Add New',
//                'new_item'              => 'New ' . $option['affinity_site_id'],
//                'edit_item'             => 'Edit ' . $option['singular_name'],
//                'update_item'           => 'Update ' . $option['affinity_site_id'],
//                'view_item'             => 'View ' . $option['affinity_site_id'],
//                'view_items'            => 'View ' . $option['affinity_site_id'],
//                'search_items'          => 'Search ' . $option['affinity_site_id'],
//                'not_found'             => 'No ' . $option['affinity_site_id'] . ' Found',
//                'not_found_in_trash'    => 'No ' . $option['affinity_site_id'] . ' Found in Trash',
//                'featured_image'        => 'Featured Image',
//                'set_featured_image'    => 'Set Featured Image',
//                'remove_featured_image' => 'Remove Featured Image',
//                'use_featured_image'    => 'Use Featured Image',
//                'insert_into_item'      => 'Insert into ' . $option['affinity_site_id'],
//                'uploaded_to_this_item' => 'Upload to this ' . $option['affinity_site_id'],
//                'items_list'            => $option['affinity_site_id'] . ' List',
//                'items_list_navigation' => $option['affinity_site_id'] . ' List Navigation',
//                'filter_items_list'     => 'Filter' . $option['affinity_site_id'] . ' List',
//                'label'                 => $option['affinity_site_id'],
//                'description'           => $option['affinity_site_id'] . 'Custom Post Type',
//                'supports'              => array( 'title', 'editor', 'thumbnail' ),
//                'taxonomies'            => array( 'category', 'post_tag' ),
//                'hierarchical'          => false,
//                'public'                => isset($option['public']) ?: false,
//                'show_ui'               => true,
//                'show_in_menu'          => true,
//                'menu_position'         => 5,
//                'show_in_admin_bar'     => true,
//                'show_in_nav_menus'     => true,
//                'can_export'            => true,
//                'has_archive'           => isset($option['public']) ?: false,
//                'exclude_from_search'   => false,
//                'publicly_queryable'    => true,
//                'capability_type'       => 'post'
//            ];
//        }


//        $this->working_hours_posts = [
//            [
//            'post_type' => 'torch_products',
//            'name' => 'Products',
//            'singular_name' => 'Product',
//            'public' => true,
//            'has_archive' => true,
//            ],
//            [
//                'post_type' => 'goran_books',
//                'name' => 'Books',
//                'singular_name' => 'Book',
//                'public' => true,
//                'has_archive' => false,
//            ],
//        ];
    }
//    public function registerWorkingHours()
//    {
//        foreach ($this->working_hours_posts as $working_hours_post) {
//            register_post_type( $working_hours_post['post_type'],
//                [
//                    'labels' => [
//                        'name'                  => $working_hours_post['name'],
//                        'singular_name'         => $working_hours_post['singular_name'],
//                        'menu_name'             => $working_hours_post['menu_name'],
//                        'name_admin_bar'        => $working_hours_post['name_admin_bar'],
//                        'archives'              => $working_hours_post['archives'],
//                        'attributes'            => $working_hours_post['attributes'],
//                        'parent_item_colon'     => $working_hours_post['parent_item_colon'],
//                        'all_items'             => $working_hours_post['all_items'],
//                        'add_new_item'          => $working_hours_post['add_new_item'],
//                        'add_new'               => $working_hours_post['add_new'],
//                        'new_item'              => $working_hours_post['new_item'],
//                        'edit_item'             => $working_hours_post['edit_item'],
//                        'update_item'           => $working_hours_post['update_item'],
//                        'view_item'             => $working_hours_post['view_item'],
//                        'view_items'            => $working_hours_post['view_items'],
//                        'search_items'          => $working_hours_post['search_items'],
//                        'not_found'             => $working_hours_post['not_found'],
//                        'not_found_in_trash'    => $working_hours_post['not_found_in_trash'],
//                        'featured_image'        => $working_hours_post['featured_image'],
//                        'set_featured_image'    => $working_hours_post['set_featured_image'],
//                        'remove_featured_image' => $working_hours_post['remove_featured_image'],
//                        'use_featured_image'    => $working_hours_post['use_featured_image'],
//                        'insert_into_item'      => $working_hours_post['insert_into_item'],
//                        'uploaded_to_this_item' => $working_hours_post['uploaded_to_this_item'],
//                        'items_list'            => $working_hours_post['items_list'],
//                        'items_list_navigation' => $working_hours_post['items_list_navigation'],
//                        'filter_items_list'     => $working_hours_post['filter_items_list']
//                    ],
//                    'label'                     => $working_hours_post['label'],
//                    'description'               => $working_hours_post['description'],
//                    'supports'                  => $working_hours_post['supports'],
//                    'taxonomies'                => $working_hours_post['taxonomies'],
//                    'hierarchical'              => $working_hours_post['hierarchical'],
//                    'public'                    => $working_hours_post['public'],
//                    'show_ui'                   => $working_hours_post['show_ui'],
//                    'show_in_menu'              => $working_hours_post['show_in_menu'],
//                    'menu_position'             => $working_hours_post['menu_position'],
//                    'show_in_admin_bar'         => $working_hours_post['show_in_admin_bar'],
//                    'show_in_nav_menus'         => $working_hours_post['show_in_nav_menus'],
//                    'can_export'                => $working_hours_post['can_export'],
//                    'has_archive'               => $working_hours_post['has_archive'],
//                    'exclude_from_search'       => $working_hours_post['exclude_from_search'],
//                    'publicly_queryable'        => $working_hours_post['publicly_queryable'],
//                    'capability_type'           => $working_hours_post['capability_type']
//                ]
//            );
//        }
//    }
}