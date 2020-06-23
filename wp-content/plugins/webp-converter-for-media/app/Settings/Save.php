<?php

  namespace WebpConverter\Settings;

  class Save
  {
    public function __construct()
    {
      $this->saveConfig();
    }

    /* ---
      Functions
    --- */

    private function saveConfig()
    {
      if (!isset($_POST['webpc_save']) || !isset($_REQUEST['_wpnonce'])
        || !wp_verify_nonce($_REQUEST['_wpnonce'], 'webpc-save')) return;

      $values = $this->getValues();
      $this->saveOption('webpc_settings', $values);
      do_action('webpc_rewrite_htaccess', true);
    }

    private function getValues()
    {
      $options = apply_filters('webpc_get_options', []);
      $values  = [];
      foreach ($options as $key => $option) {
        $name          = $option['name'];
        $values[$name] = isset($_POST[$name]) ? $_POST[$name] : (($option['type'] === 'checkbox') ? [] : null);
      }
      $values = $this->sanitizeValues($values);
      return $values;
    }

    private function sanitizeValues($values)
    {
      foreach ($values as $index => $value) {
        if (is_array($value)) $values[$index] = array_map('sanitize_text_field', $value);
        else $values[$index] = sanitize_text_field($value);
      }
      return $values;
    }

    private function saveOption($key, $value)
    {
      if (get_option($key, false) !== false) update_option($key, $value);
      else add_option($key, $value);
    }
  }