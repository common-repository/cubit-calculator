<?php

namespace Cubit_Calculator;

defined('WPINC') || die();

class Plugin
{
    public function __construct($name, $version)
    {
        $this->name = $name;
    }

    private $name;
    public function get_name()
    {
        return $this->name;
    }

    private $version;
    public function get_version()
    {
        return $this->version;
    }

    public function run()
    {
        add_action('plugins_loaded', [$this, 'load_plugin_textdomain']);
    }

    public function load_plugin_textdomain()
    {
        load_plugin_textdomain($this->name, false, $this->name . '/languages');
    }
}
