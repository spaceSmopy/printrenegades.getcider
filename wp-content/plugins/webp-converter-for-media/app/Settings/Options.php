<?php

  namespace WebpConverter\Settings;

  class Options
  {
    public function __construct()
    {
      add_filter('webpc_get_options', [$this, 'getOptions']);
    }

    /* ---
      Functions
    --- */

    public function getOptions($options)
    {
      return [
        [
          'name'     => 'extensions',
          'type'     => 'checkbox',
          'label'    => __('List of supported files extensions', 'webp-converter'),
          'info'     => '',
          'values'   => [
            'jpg'  => '.jpg',
            'jpeg' => '.jpeg',
            'png'  => '.png',
            'gif'  => '.gif',
          ],
          'disabled' => $this->getDisabledValues('extensions'),
        ],
        [
          'name'     => 'method',
          'type'     => 'radio',
          'label'    => __('Conversion method', 'webp-converter'),
          'info'     => __('The configuration for advanced users.', 'webp-converter'),
          'values'   => [
            'gd'      => sprintf(__('%s (recommended)', 'webp-converter'), 'GD'),
            'imagick' => 'Imagick',
          ],
          'disabled' => $this->getDisabledValues('method'),
        ],
        [
          'name'     => 'features',
          'type'     => 'checkbox',
          'label'    => __('Extra features', 'webp-converter'),
          'info'     => __('The options allow you to enable new functionalities that will additionally speed up your website.', 'webp-converter'),
          'values'   => [
            'only_smaller' => __('Automatic removal of WebP files larger than original', 'webp-converter'),
            'mod_expires'  => __('Browser Caching for WebP files (saving images in browser cache memory)', 'webp-converter'),
          ],
          'disabled' => $this->getDisabledValues('features'),
        ],
        [
          'name'   => 'quality',
          'type'   => 'quality',
          'label'  => __('Images quality', 'webp-converter'),
          'info'   => __('Adjust the quality of the images being converted. Remember that higher quality also means larger file sizes. The recommended value is 85%.', 'webp-converter'),
          'values' => [
            '75'  => '75%',
            '80'  => '80%',
            '85'  => '85%',
            '90'  => '90%',
            '95'  => '95%',
            '100' => '100%',
          ],
          'disabled' => $this->getDisabledValues('quality'),
        ],
      ];
    }

    private function getDisabledValues($optionName)
    {
      $list = [];
      switch ($optionName) {
        case 'method':
          $methods = apply_filters('webpc_get_methods', []);
          if (!in_array('gd', $methods)) $list[] = 'gd';
          if (!in_array('imagick', $methods)) $list[] = 'imagick';
      }
      return $list;
    }
  }