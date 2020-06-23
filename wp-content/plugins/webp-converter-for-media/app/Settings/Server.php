<?php

  namespace WebpConverter\Settings;

  class Server
  {
    private $extensions = ['gd', 'imagick', 'core'];

    public function __construct()
    {
      add_filter('webpc_server_info', [$this, 'getContent']);
    }

    /* ---
      Functions
    --- */

    public function getContent($content = '')
    {
      ob_start();

      foreach ($this->extensions as $extension) {
        $this->getExtensionInfo($extension);
      }

      $content = ob_get_contents();
      ob_end_clean();
      return $content;
    }

    private function getExtensionInfo($extension)
    {
      ?>
        <h4><?= $extension; ?></h4>
      <?php
      if (!extension_loaded($extension)) :
        ?>
          <p>-</p>
        <?php
      else :
        $ext = new \ReflectionExtension($extension);
        $ext->info();
      endif;
    }
  }