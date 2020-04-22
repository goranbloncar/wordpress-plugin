<?php
/*
 * @package TorchlightPlugin
 */

namespace Inc;

use Inc\Base\ApiController;
use Inc\Base\ApiWorkingHours;
use Inc\Base\IhcaffinitySitesController;
use Inc\Base\TouPpController;
use Inc\Base\WorkingHoursController;

final class Init
{
    public static function get_services()
    {
        return [
            Pages\Dashboard::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            WorkingHoursController::class,
            IhcaffinitySitesController::class,
            TouPpController::class,
            ApiController::class,
        ];
    }

    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if(method_exists($service, 'register')){
                $service->register();
            }
        }
    }

    private static function instantiate($class)
    {
        return new $class();
    }
}

