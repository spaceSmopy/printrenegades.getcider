<?php if ($errors = apply_filters('webpc_server_errors', [])) : ?>
  <div class="webpPage__widget">
    <h3 class="webpPage__widgetTitle webpPage__widgetTitle--error">
      <?= __('Server configuration error', 'webp-converter'); ?>
    </h3>
    <div class="webpContent">
      <?php if (in_array('path_uploads', $errors)) : ?>
        <p>
          <?= sprintf(
            __('The path for /uploads files does not exist %s(function is_dir() returns false)%s. Use filters %s or %s to set the correct path. The current using path is: %s. Please read the plugin FAQ to learn more.', 'webp-converter'),
            '<em>',
            '</em>',
            '<strong>webpc_uploads_root</strong>',
            '<strong>webpc_uploads_path</strong>',
            '<strong>' . apply_filters('webpc_uploads_path', '') . '</strong>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('path_htaccess', $errors)) : ?>
        <p>
          <?= sprintf(
            __('Unable to create or edit .htaccess file %s(function is_readable() or is_writable() returns false)%s. Change directory permissions. The current using path of file is: %s. Please contact your server administrator.', 'webp-converter'),
            '<em>',
            '</em>',
            '<strong>' . apply_filters('webpc_uploads_path', '') . '/.htaccess</strong>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('path_webp', $errors)) : ?>
        <p>
          <?= sprintf(
            __('The path for saving converted WebP files does not exist and cannot be created %s(function is_writable() returns false)%s. Use filters %s or %s to set the correct path. The current using path is: %s. Please read the plugin FAQ to learn more.', 'webp-converter'),
            '<em>',
            '</em>',
            '<strong>webpc_uploads_root</strong>',
            '<strong>webpc_uploads_webp</strong>',
            '<strong>' . apply_filters('webpc_uploads_webp', '') . '</strong>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('path_duplicated', $errors)) : ?>
        <p>
          <?= sprintf(
            __('The paths for /uploads files and for saving converted WebP files are the same. Change them using filters %s or %s. The current path for them is: %s.', 'webp-converter'),
            '<strong>webpc_uploads_path</strong>',
            '<strong>webpc_uploads_webp</strong>',
            '<strong>' . apply_filters('webpc_uploads_path', '') . '</strong>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('rest_api', $errors)) : ?>
        <p>
          <?= sprintf(
            __('The REST API on your website is not available. Please verify this and try again. Pay special attention to the filters: %s, %s and %s.', 'webp-converter'),
            '<a href="https://developer.wordpress.org/reference/hooks/rest_enabled/" target="_blank">rest_enabled</a>',
            '<a href="https://developer.wordpress.org/reference/hooks/rest_jsonp_enabled/" target="_blank">rest_jsonp_enabled</a>',
            '<a href="https://developer.wordpress.org/reference/hooks/rest_authentication_errors/" target="_blank">rest_authentication_errors</a>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('methods', $errors)) : ?>
        <p>
          <?= sprintf(
            __('On your server is not installed %sGD%s or %sImagick%s library, or installed extension does not support WebP format. Check your server configuration %shere%s and try again. Please contact your server administrator.', 'webp-converter'),
            '<strong>',
            '</strong>',
            '<strong>',
            '</strong>',
            '<a href="' . sprintf('%s&action=server', menu_page_url('webpc_admin_page', false)) . '">',
            '</a>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('bypassing_apache', $errors)) : ?>
        <p>
          <?= sprintf(
            __('Requests to images are processed by your server bypassing Apache. When loading images, rules from the .htaccess file are not executed. Check the redirects for %s.png file%s %s(for which the redirection does not work)%s and for %s.png2 file%s %s(for which the redirection works correctly)%s. Change the server settings to stop ignoring the rules in the .htaccess file. Please contact your server administrator.', 'webp-converter'),
            '<a href="' . WEBPC_URL . 'public/img/icon-before.png" target="_blank">',
            '</a>',
            '<em>',
            '</em>',
            '<a href="' . WEBPC_URL . 'public/img/icon-before.png2" target="_blank">',
            '</a>',
            '<em>',
            '</em>'
          ); ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>