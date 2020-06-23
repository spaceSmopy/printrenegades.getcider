<?php

  namespace WebpConverter\Settings;

  class Page
  {
    public function __construct()
    {
      add_action('admin_menu', [$this, 'addSettingsPage']);
    }

    /* ---
      Functions
    --- */

    public function addSettingsPage()
    {
      if (is_network_admin()) return;

      add_submenu_page(
        'options-general.php',
        'WebP Converter for Media',
        'WebP Converter',
        'manage_options',
        'webpc_admin_page',
        [$this, 'showSettingsPage']
      );
    }

    public function showSettingsPage()
    {
      new Save();
      require_once WEBPC_PATH . 'resources/views/settings.php';
    }
  }