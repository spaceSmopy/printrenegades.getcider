<?php

  namespace WebpConverter\Regenerate;

  use WebpConverter\Media\Attachment;

  class Paths
  {
    /* ---
      Functions
    --- */

    public function getPaths()
    {
      $postIds = get_posts([
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
      ]);

      $list = $this->getPathsByAttachments($postIds);
      wp_send_json_success($list);
    }

    private function getPathsByAttachments($postIds)
    {
      $list = [];
      if (!$postIds) return $list;

      $attachment = new Attachment();
      foreach ($postIds as $postId) {
        $paths = $attachment->getAttachmentPaths($postId);
        if ($paths) $list[] = $paths;
      }
      return $list;
    }
  }