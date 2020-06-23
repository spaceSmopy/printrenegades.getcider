<?php

  namespace WebpConverter\Settings;

  class Paths
  {
    private $pathSource = 'wp-content/uploads';
    private $pathOutput = 'wp-content/uploads-webpc';

    public function __construct()
    {
      add_filter('webpc_uploads_path',   [$this, 'getSourcePath'], 0, 2);
      add_filter('webpc_uploads_webp',   [$this, 'getOutputPath'], 0, 2);
      add_filter('webpc_uploads_path',   [$this, 'parsePath'], 100, 2);
      add_filter('webpc_uploads_webp',   [$this, 'parsePath'], 100, 2);
      add_filter('webpc_uploads_prefix', [$this, 'getPrefixPath'], 0);
    }

    /* ---
      Functions
    --- */

    public function getSourcePath($value, $skipRoot = false)
    {
      return $this->pathSource;
    }

    public function getOutputPath($value, $skipRoot = false)
    {
      return $this->pathOutput;
    }

    public function parsePath($value, $skipRoot = false)
    {
      if ($skipRoot) return trim($value, '\/');

      $path = apply_filters('webpc_uploads_root', ABSPATH);
      return $path . '/' . trim($value, '\/');
    }

    public function getPrefixPath($value)
    {
      $docDir   = realpath($_SERVER['DOCUMENT_ROOT']);
      $wpDir    = realpath(ABSPATH);
      $diffDir  = trim(str_replace($docDir, '', $wpDir), '\/');
      $diffPath = sprintf('/%s/', $diffDir);

      return str_replace('//', '/', $diffPath);
    }
  }