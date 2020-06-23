<div class="notice notice-success is-dismissible" data-notice="webp-converter" data-url="<?= apply_filters('webpc_notice_url', ''); ?>">
  <div class="webpContent webpContent--notice">
    <h4>
      <?= __('Thank you for using our plugin WebP Converter for Media!', 'webp-converter'); ?>
    </h4>
    <p>
      <?= sprintf(
        __('Please let us know what you think about our plugin. It is important that we can develop this tool. Thank you for all the ratings, reviews and donates. If you have a technical problem, please before you add a review %scheck our FAQ%s or contact us if you did not find help there. We will try to help you!', 'webp-converter'),
        '<a href="https://wordpress.org/plugins/webp-converter-for-media/#faq" target="_blank">',
        '</a>'
      ); ?>
    </p>
    <div class="webpContent__buttons">
      <a href="https://wordpress.org/support/plugin/webp-converter-for-media/#new-post" target="_blank"
        class="webpContent__button webpButton webpButton--green">
        <?= __('Get help', 'webp-converter'); ?>
      </a>
      <a href="https://wordpress.org/support/plugin/webp-converter-for-media/reviews/#new-post" target="_blank"
        class="webpContent__button webpButton webpButton--green">
        <?= __('Add review', 'webp-converter'); ?>
      </a>
      <a href="https://ko-fi.com/gbiorczyk/" target="_blank"
        class="webpContent__button webpButton webpButton--green dashicons-heart">
        <?= __('Provide us a coffee', 'webp-converter'); ?>
      </a>
      <a href="#" target="_blank" data-permanently
        class="webpContent__button webpButton webpButton--blue">
        <?= __('I added review, do not show again', 'webp-converter'); ?>
      </a>
    </div>
  </div>
</div>