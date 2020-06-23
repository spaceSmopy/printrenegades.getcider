<?php

  namespace WebpConverter\Settings;

  class Methods
  {
    public function __construct()
    {
      add_filter('webpc_get_methods', [$this, 'getAvaiableMethods']);
    }

    /* ---
      Functions
    --- */

    public function getAvaiableMethods()
    {
      $list = [];

      if (extension_loaded('gd') && function_exists('imagewebp')) {
        $list[] = 'gd';
      }
      if (extension_loaded('imagick') && class_exists('\Imagick')) {
        $formats = (new \Imagick)->queryformats();
        if (in_array('WEBP', $formats)) $list[] = 'imagick';
      }
      return $list;
    }
  }