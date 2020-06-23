<?php

  namespace WebpConverter\Settings;

  class Errors
  {
    private $list = null;

    public function __construct()
    {
      add_filter('webpc_server_errors', [$this, 'getServerErrors']);
    }

    /* ---
      Functions
    --- */

    public function getServerErrors()
    {
      if ($this->list !== null) return $this->list;

      $list = [
        'path_uploads'     => ($this->ifUploadsPathExists() !== true),
        'path_htaccess'    => ($this->ifHtaccessIsWriteable() !== true),
        'path_webp'        => ($this->ifWebpPathExists() !== true),
        'path_duplicated'  => ($this->ifPathsAreDifferent() !== true),
        'rest_api'         => ($this->ifRestApiIsEnabled() !== true),
        'methods'          => ($this->ifMethodsAreAvailable() !== true),
        'bypassing_apache' => ($this->ifBypassingApacheIsActive() === true),
      ];

      $this->list = array_keys(array_filter($list));
      return $this->list;
    }

    private function ifUploadsPathExists()
    {
      $path = apply_filters('webpc_uploads_path', '');
      return (is_dir($path) && ($path !== ABSPATH));
    }

    private function ifHtaccessIsWriteable()
    {
      $pathDir  = apply_filters('webpc_uploads_path', '');
      $pathFile = $pathDir . '/.htaccess';
      if (file_exists($pathFile)) return (is_readable($pathFile) && is_writable($pathFile));
      else return is_writable($pathDir);
    }

    private function ifWebpPathExists()
    {
      $path = apply_filters('webpc_uploads_webp', '');
      return (is_dir($path) || is_writable(dirname($path)));
    }

    private function ifPathsAreDifferent()
    {
      $pathUploads = apply_filters('webpc_uploads_path', '');
      $pathWebp    = apply_filters('webpc_uploads_webp', '');
      return ($pathUploads !== $pathWebp);
    }

    private function ifRestApiIsEnabled()
    {
      return ((apply_filters('rest_enabled', true) === true)
        && (apply_filters('rest_jsonp_enabled', true) === true)
        && (apply_filters('rest_authentication_errors', true) === true));
    }

    private function ifMethodsAreAvailable()
    {
      $config  = apply_filters('webpc_get_values', []);
      $methods = apply_filters('webpc_get_methods', []);
      return (isset($config['method']) && in_array($config['method'], $methods));
    }

    private function ifBypassingApacheIsActive()
    {
      $ctx = stream_context_create([
        'http' => [
          'timeout' => 1,
        ],
      ]);
      $filePng = @file_get_contents(WEBPC_URL . 'public/img/icon-before.png', false, $ctx);
      if ($filePng === false) return false;

      $filePng2 = @file_get_contents(WEBPC_URL . 'public/img/icon-before.png2', false, $ctx);
      if ($filePng2 === false) return false;

      return (strlen($filePng) < strlen($filePng2));
    }
  }