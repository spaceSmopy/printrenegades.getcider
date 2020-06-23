<?php

  namespace WebpConverter\Media;

  class Htaccess
  {
    public function __construct()
    {
      add_action('webpc_rewrite_htaccess', [$this, 'addRewriteRulesToUploads'],     10, 1);
      add_action('webpc_rewrite_htaccess', [$this, 'addRewriteRulesToUploadsWebp'], 10, 1);
    }

    /* ---
      Functions
    --- */

    public function addRewriteRulesToUploads($isActive)
    {
      $path = apply_filters('webpc_uploads_path', '');
      if (!$isActive) return $this->saveRewritesInHtaccesss($path);

      $values = apply_filters('webpc_get_values', []);
      $rows   = [
        $this->getModRewriteRules($values),
      ];

      $content = $this->addCommentsToRules($rows);
      $content = apply_filters('webpc_htaccess_rules', $content, $path . '/.htaccess');
      $this->saveRewritesInHtaccesss($path, $content);
    }

    public function addRewriteRulesToUploadsWebp($isActive)
    {
      $path = apply_filters('webpc_uploads_webp', '');
      if (!$isActive) return $this->saveRewritesInHtaccesss($path);

      $values = apply_filters('webpc_get_values', []);
      $rows   = [
        $this->getModMimeRules($values),
        $this->getModExpiresRules($values),
      ];

      $content = $this->addCommentsToRules($rows);
      $content = apply_filters('webpc_htaccess_rules', $content, $path . '/.htaccess');
      $this->saveRewritesInHtaccesss($path, $content);
    }

    private function getModRewriteRules($settings)
    {
      $content = '';
      if (!$settings['extensions']) return $content;

      $path  = apply_filters('webpc_uploads_prefix', '/');
      $path .= apply_filters('webpc_uploads_webp', '', true);

      $content .= '<IfModule mod_rewrite.c>' . PHP_EOL;
      $content .= '  RewriteEngine On' . PHP_EOL;
      foreach ($settings['extensions'] as $ext) {
        $content .= '  RewriteCond %{HTTP_ACCEPT} image/webp' . PHP_EOL;
        $content .= "  RewriteCond %{DOCUMENT_ROOT}${path}/$1.${ext}.webp -f" . PHP_EOL;
        $content .= "  RewriteRule (.+)\.${ext}$ ${path}/$1.${ext}.webp [NC,T=image/webp,E=cache-control:private,L]" . PHP_EOL;
      }
      $content .= '</IfModule>';

      $content = apply_filters('webpc_htaccess_mod_rewrite', $content);
      return $content;
    }

    private function getModExpiresRules($settings)
    {
      $content = '';
      if (!in_array('mod_expires', $settings['features'])) return $content;

      $content .= '<IfModule mod_expires.c>' . PHP_EOL;
      $content .= '  ExpiresActive On' . PHP_EOL;
      $content .= '  ExpiresByType image/webp "access plus 1 year"' . PHP_EOL;
      $content .= '</IfModule>';

      $content = apply_filters('webpc_htaccess_mod_expires', $content);
      return $content;
    }

    private function getModMimeRules($settings)
    {
      $content = '';
      if (!$settings['extensions']) return $content;

      $content .= '<IfModule mod_mime.c>' . PHP_EOL;
      $content .= '  AddType image/webp .webp' . PHP_EOL;
      $content .= '</IfModule>';

      $content = apply_filters('webpc_htaccess_mod_mime', $content);
      return $content;
    }

    private function addCommentsToRules($rules)
    {
      if (!$rules) return '';

      $rows   = [];
      $rows[] = '';
      $rows[] = '# BEGIN WebP Converter';
      $rows[] = '# ! --- DO NOT EDIT PREVIOUS LINE --- !';
      $rows   = array_merge($rows, array_filter($rules));
      $rows[] = '# ! --- DO NOT EDIT NEXT LINE --- !';
      $rows[] = '# END WebP Converter';
      $rows[] = '';

      return implode(PHP_EOL, $rows);
    }

    private function saveRewritesInHtaccesss($pathDir, $rules = '')
    {
      $pathFile = $pathDir . '/.htaccess';

      $code = (is_readable($pathFile)) ? file_get_contents($pathFile) : '';
      $code = preg_replace('/((:?[\r\n|\r|\n]?)# BEGIN WebP Converter(.*?)# END WebP Converter(:?(:?[\r\n|\r|\n]+)?))/s', '', $code);
      if ($rules && $code) $code = PHP_EOL . $code;
      $code = $rules . $code;

      if (is_writable($pathDir)) file_put_contents($pathFile, $code);
    }
  }