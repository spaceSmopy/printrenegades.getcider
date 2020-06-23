<?php

  namespace WebpConverter\Settings;

  class Values
  {
    private $config;

    public function __construct()
    {
      add_filter('webpc_get_values', [$this, 'getValues']);
    }

    /* ---
      Functions
    --- */

    public function getValues()
    {
      if ($this->config) return $this->config;

      $methods = apply_filters('webpc_get_methods', []);
      $value   = get_option('webpc_settings', [
        'extensions' => ['jpg', 'jpeg', 'png'],
        'method'     => ($methods) ? $methods[0] : '',
        'features'   => ['only_smaller', 'mod_expires'],
        'quality'    => 85,
      ]);
      $this->config = $value;
      return $value;
    }
  }