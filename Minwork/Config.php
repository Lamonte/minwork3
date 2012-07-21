<?php
namespace Minwork;

/**
 * Config Items
 * 
 * Get config items from the config without having to
 * use globals in our other class methods
 */
class Config {

    /**
     * Config::Item
     *
     * Return the defined config setting if config setting is set
     * @param string $item_name
     * @return string
     */
    public static function Item($item_name) {
        global $config, $conf;

        //lets check if the config item was set
        if(isset($conf) && isset($config[$conf][$item_name])) {
            return $config[$conf][$item_name];
        }

        return null;
    }
}