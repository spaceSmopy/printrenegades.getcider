<?php

  namespace WebpConverter\Action;

  use WebpConverter\Convert as ConvertMethod;
  use WebpConverter\Media\Attachment;

  class Convert
  {
    public function __construct()
    {
      add_action('webpc_convert_paths',      [$this, 'convertFilesByPaths']);
      add_action('webpc_convert_attachment', [$this, 'convertFilesByAttachment']);
    }

    /* ---
      Functions
    --- */

    public function convertFilesByPaths($paths)
    {
      $settings = apply_filters('webpc_get_values', []);

      if ($settings['method'] === 'gd') $convert = new ConvertMethod\Gd();
      else if ($settings['method'] === 'imagick') $convert = new ConvertMethod\Imagick();
      if (!isset($convert)) return false;

      foreach ($paths as $path) {
        if (!in_array(pathinfo($path, PATHINFO_EXTENSION), $settings['extensions'])) continue;

        $response = $convert->convertImage($path, $settings['quality']);
        if (!$response['success']) $this->addErrorToLog($response['message']);
      }
    }

    public function convertFilesByAttachment($postId)
    {
      $paths = (new Attachment())->getAttachmentPaths($postId);
      do_action('webpc_convert_paths', $paths);
    }

    private function addErrorToLog($message)
    {
      error_log(sprintf(
        'WebP Converter: %s',
        $message
      ));
    }
  }