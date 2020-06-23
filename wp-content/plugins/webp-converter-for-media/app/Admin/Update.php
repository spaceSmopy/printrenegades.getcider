<?php

  namespace WebpConverter\Admin;

  class Update
  {
    private $optionVersion  = 'webpc_latest_version';
    private $optionSettings = 'webpc_settings';

    public function __construct()
    {
      add_action('admin_init', [$this, 'runActionsAfterUpdate']);
    }

    /* ---
      Functions
    --- */

    public function runActionsAfterUpdate()
    {
      $version = get_option($this->optionVersion, '0.0.0');
      if ($version === WEBPC_VERSION) return;

      $this->saveOptionValue($this->optionSettings, $this->updateSettingsForOldVersions($version));
      $this->saveOptionValue($this->optionVersion, WEBPC_VERSION);

      do_action('webpc_rewrite_htaccess', true);
      flush_rewrite_rules(true);
    }

    private function updateSettingsForOldVersions($version)
    {
      $settings = apply_filters('webpc_get_values', []);

      if (version_compare($version, '1.1.2', '>')) return $settings;
      $settings['features'][] = 'only_smaller';

      $settings['features'] = array_unique($settings['features']);
      return $settings;
    }

    private function saveOptionValue($optionKey, $value)
    {
      if (get_option($optionKey, false) !== false) update_option($optionKey,  $value);
      else add_option($optionKey,  $value);
    }
  }