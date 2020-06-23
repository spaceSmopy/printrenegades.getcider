<?php

  namespace WebpConverter\Regenerate;

  use WebpConverter\Convert\Directory as Directory;

  class Skip
  {
    public function __construct()
    {
      add_filter('webpc_attachment_paths', [$this, 'skipExistsImages']); 
    }

    /* ---
      Functions
    --- */

    public function skipExistsImages($paths)
    {
      $directory = new Directory();

      foreach ($paths as $key => $path) {
        $output = $directory->getPath($path, false);
        if (file_exists($output)) unset($paths[$key]);
      }
      return $paths;
    }
  }