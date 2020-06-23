<?php

  namespace WebpConverter\Admin;

  class Assets
  {
    public function __construct()
    {
      add_filter('admin_enqueue_scripts', [$this, 'loadStyles']);
      add_filter('admin_enqueue_scripts', [$this, 'loadScripts']);
    }

    /* ---
      Functions
    --- */

    public function loadStyles()
    {
      wp_register_style('webp-converter', WEBPC_URL . 'public/build/css/styles.css', '', WEBPC_VERSION);
      wp_enqueue_style('webp-converter');
    }

    public function loadScripts()
    {
      wp_register_script('webp-converter', WEBPC_URL . 'public/build/js/scripts.js', 'jquery', WEBPC_VERSION, true);
      wp_enqueue_script('webp-converter');
    }
  }