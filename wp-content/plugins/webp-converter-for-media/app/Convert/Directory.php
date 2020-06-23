<?php

  namespace WebpConverter\Convert;

  class Directory
  {
    /* ---
      Functions
    --- */

    public function getPath($path, $createDirectory = false)
    {
      $pathSource = apply_filters('webpc_uploads_path', '', true);
      $pathOutput = apply_filters('webpc_uploads_webp', '', true);
      $newPath    = str_replace("/${pathSource}/", "/${pathOutput}/", $path) . '.webp';
      if (!$createDirectory) return $newPath;

      if (!$paths = $this->checkDirectories($newPath)) return $newPath;
      else if (!$this->makeDirectories($paths)) return null;
      else return $newPath;
    }

    private function checkDirectories($path)
    {
      $current = dirname($path);
      $paths   = [];
      while (!file_exists($current)) {
        $paths[] = $current;
        $current = dirname($current);
      }
      return $paths;
    }

    private function makeDirectories($paths)
    {
      $paths = array_reverse($paths);
      foreach ($paths as $path) {
        if (!is_writable(dirname($path))) return;
        mkdir($path);
      }
      return true;
    }
  }