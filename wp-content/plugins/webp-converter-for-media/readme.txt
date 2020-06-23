=== WebP Converter for Media ===
Contributors: mateuszgbiorczyk
Donate link: https://ko-fi.com/gbiorczyk/
Tags: webp, images, performance, compress, optimize
Requires at least: 5.0
Tested up to: 5.4
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Speed up your website by serving WebP images instead of standard formats JPEG, PNG and GIF.

== Description ==

Speed up your website by serving WebP images. By replacing files in standard JPEG, PNG and GIF formats with WebP format, you can save over a half of the page weight without losing quality.

When installing a plugin you do not have to do anything more. Your current images will be converted into a new format. Users will automatically receive new, much lighter images than the original ones.

As of today, nearly 80% of users use browsers that support the WebP format. The loading time of your website depends to a large extent on its weight. Now you can speed up it in a few seconds without much effort!

This will be a profit both for your users who will not have to download so much data, but also for a server that will be less loaded. Remember that a better optimized website also affects your Google ranking.

#### How does this work?

- By adding images to your media library, they are automatically converted and saved in a separate directory.
- If you have just installed the plugin, you can convert all existing images with one click.
- Converting to WebP format works for all image sizes. As WebP you will see all the images added to the media library.
- Images are converted using PHP `GD` or `Imagick` extension *(you can modify the compression level)*.
- When the browser tries to download an image file, the server verifies if it supports `image/webp` files and if the file exists.
- If everything is OK, instead of the original image, the browser will receive its equivalent in WebP format.
- **The plugin does not change image URLs, so there are no problems with saving the HTML code of website to the cache and time of its generation does not increase.** It does not matter if the image display as an `img` HTML tag or you use `background-image`. It works always!
- The name of the loaded image does not contain the WebP extension. Only the source of the loaded file changes to a WebP file. As a result, you always have one URL to a file. Regardless of whether the browser supports WebP or not.
- Image URLs are modified using the module `mod_rewrite` on the server, i.e. the same, and thanks to this we can use friendly links in WordPress. Additionally, the MIME type of the sent file is modified to `image/webp`.
- The final result is that your users download less than half of the data, and the website itself loads faster!

#### WebP images are the future!

Raise your website to a new level now! Install the plugin and enjoy the website that loads faster. Surely you and your users will appreciate it.

#### Support to the development of plugin

We spend hours working on the development of this plugin. Technical support also requires a lot of time, but we do it because we want to offer you the best plugin. We enjoy every new plugin installation.

If you would like to appreciate it, you can [provide us a coffee](https://ko-fi.com/gbiorczyk/). **If every user bought at least one, we could work on the plugin 24 hours a day!**

#### Please also read the FAQ below. Thank you for being with us!

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/webp-converter-for-media` directory, or install plugin through the WordPress plugins screen directly.
2. Activate plugin through `Plugins` screen in WordPress Admin Panel.
3. Use `Settings -> Settings -> WebP Converter` screen to configure the plugin.
4. Click on the button `Regenerate All`.
5. Check if everything works fine.

That's all! Your website is already loading faster!

== Frequently Asked Questions ==

= How to get technical support? (before you ask for help) =

Please always adding your thread, **read all other questions in the FAQ of plugin and other threads in support forum first**. Perhaps someone had a similar problem and it has been resolved.

This will save time repeating the same issues many times and solving the same problems. If you do not find anything and you still have a problem, then contact us.

We will be grateful if you appreciate our time and try to find an answer that may already be somewhere. And if it's not here, please describe your problem to us.

Please remember one thing - we work on it in our free time, with passion. We will be grateful for keeping culture and patience. We are not always able to respond immediately.

We want to help everyone very much, but we need cooperation between both sides. This is very important. We may have a deal like this?

And most importantly - **do not leave the thread unanswered**. If you add a thread, follow when you get a reply. Then let us know if we have helped you or not. This helps us improve technical support.

When adding a thread, follow these steps and reply to each of them:

**1.** Do you have any error on the plugin settings page? If so, which one? Have you consulted your server administrator or developer? If not, please do it first.

**2.** URL of your website. If your site is not publicly available, add it to test environment.

**3.** Does your server meet the technical requirements described in the FAQ? Please send configuration of your server *(link to it can be found on the settings page of plugin in the section **"We are waiting for your message"**)* - please take a screenshot of the ENTIRE page and send it to me.

**4.** Do you use CDN? If so, please see the question **"Does the plugin support CDN?"** in plugin FAQ.

**5.** Check if in `/wp-content/uploads-webpc` directory are all files that should be converted.

If not, please enable `WP_DEBUG_LOG` in your `wp-config.php` *(more about debugging: [https://codex.wordpress.org/WP_DEBUG](https://codex.wordpress.org/WP_DEBUG))*. That's what you should have in this file:

`define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);`

Then follow these steps:

> 1. Go to administration panel and go to plugin settings page.
2. Run Google Chrome and enable Dev Tools *(F12)*.
3. Go to the Network tab and select filtering for `XHR` *(XHR and Fetch)*.
4. Click button `Regenerate All` on the plugin settings page *(do not close the console during this time)*.
5. Go to Dev Tools and find request that is marked in red. Click on them and go to `Preview` tab.
6. Take screenshot of all information presented there.
7. Please check also if you have any errors in `/wp-content/debug.log`?

Send a screenshot from console if an error occurred while converting images. Of you have errors in `/wp-content/debug.log` send their?

**6.** If in the previous step it turned out that you have files, please do the test, which is described in the FAQ in question `How to check if plugin works?`. Please send a screenshot of Devtools with test results.

**7.** Content of your `.htaccess` files from directories `/wp-content/uploads` and `/wp-content/uploads-webpc` *(pasting the code using the `CODE` shortcode in the editor)*.

**8.** What plugin version are you using? If it is not the latest then update and check everything again.

**9.** Used Wordpress version.

**10.** A list of all the plugins you use. Have you tried checking the plugin operation by turning off all others? If not, please try whenever possible.

Please remember to include the answers for all 10 questions by adding a thread. It is much easier and accelerate the solution of your problem.

And if we would help and would like to thank us, you can [provide us a coffee](https://ko-fi.com/gbiorczyk/).

= Error on plugin settings screen? =

If you have an error on the plugin settings screen, first of all please read it carefully. They are displayed when there is a problem with the configuration of your server or website.

The messages are designed to reduce the number of support requests that are repeated. It saves your and our time. If you have information in the message that you should contact the administrator of your server, please do so.

When contacting the administrator, give him all the information available in the message. If you still cannot solve the problem, please contact us.

We want to solve as many similar problems as possible automatically. This eliminates the need to wait for our response and you can try to solve the problem alone. This is very important for us.

= What are requirements of plugin? =

Practically every hosting meets these requirements. You must use PHP at least 7.0 and have the `GD` or `Imagick` extension installed. **The extension must support `WebP format`.**

They are required native PHP extensions, used among others by WordPress to generate thumbnails. Your server must also have the modules `mod_mime`, `mod_rewrite` and `mod_expires` enabled.

An example of the correct server configuration can be found [here](https://gbiorczyk.pl/webp-converter/serverinfo.png). Link to your current configuration can be found in the administration panel, on the management plugin page in the section **"We are waiting for your message"** *(or using the URL path: `/wp-admin/options-general.php?page=webpc_admin_page&action=server`)*.

**Note the items marked in red.** If your server does not meet the technical requirements, please contact your server Administrator.

Please do not add threads regarding server configuration in the support section. Surely the server Administrator will be able to do it best.

He is the most competent to solve such problems. Due to the huge amount of possible server environments, we are not able to help you with its configuration.

Also REST API must be enabled and work without additional restrictions. If you have a problem with it, please contact the Developer who created your website. He should easily find the issue with the REST API not working.

= What are restrictions? =

The size of the image is a limited. Its resolution cannot be bigger than `8192 x 8192px`. This is due to the limitations of the PHP library.

Please remember that **Safari and Internet Explorer do not support the WebP format**. Therefore, using these browsers you will receive original images.

You can find more about WebP support by browsers [here](https://caniuse.com/#feat=webp).

= Forced rewrites to WebP =

The plugin uses rules in the .htaccess file to redirect from the original image to an image in WebP format. Verifies whether the WebP file exists and whether your browser supports the WebP format. It does this every time you try to load an image.

When you enter from a WebP supporting device, it will redirect. However, when someone uses a browser that does not support WebP, the redirection will not work and you get the original file.

However, if you see corrupted images on browsers that do not support WebP, it means that your server uses cache for rewrites from the .htaccess file. Then the plugin will not work properly because the server instead of reading the rules from the .htaccess file every time uses its cache and does the redirection automatically.

How can you check it? When you turn off the plugin, the rewrites from the .htaccess file are removed, which means you should see the original images on every browser. If this is not the case and you see forced redirects to WebP files, it means that your server remembers the redirects you made earlier and uses cache.

In this situation, please contact your server administrator. Each configuration is different. It can be e.g. module `mod_pagespeed` or other similar. This functionality must be turned off so that the server reads and executes the rules from the .htaccess file each time the images are loaded. This cannot be ignored because it will cause problems.

= What to do after installing plugin? =

After installing the plugin, you should convert all existing images.

In the WordPress admin panel, on the `Settings -> WebP Converter` subpage there is a module that allows you to process all your images.

It uses the WordPress REST API by downloading addresses of all images and converting all files gradually.

This process may take few or more than ten minutes depending on the number of files.

**It should be done once after installing the plugin.** All images added later will be converted automatically.

= How to check if plugin works? =

When you have installed plugin and converted all images, follow these steps:

1. Run `Google Chrome` and enable `Dev Tools` *(F12)*.
2. Go to the `Network` tab and select filtering for `Img` *(Images)*.
3. Refresh your website page.
4. Check list of loaded images. Note `Type` column.
5. If value of `webp` is there, then everything works fine.
6. Remember that this plugin does not change URLs. This means that e.g. link will have path to .jpg file, but `.jpg.webp file will be loaded instead of original .jpg`.
7. In addition, you can check weight of website before and after using plugin. The difference will be huge!
8. More information: [here](https://gbiorczyk.pl/webp-converter/check-devtools.png)

Please remember that URLs will remain unchanged. The difference will be only in the Type of file. This does not mean that the plugin does not work.

If the file type is `WebP`, then everything is working properly. You can also turn off the plugin for a moment and check the weight of your website, then turn it on and test again. The difference should be visible.

Only images from the `/uploads` directory are converted. If you use other plugins that also save images in the `/uploads` directory then this may not work because this plugin may not be compatible with WebP Converter for Media. Read question `How to run manually conversion?` in the FAQ to learn more.

= Why are some images not in WebP? =

If the converted image in WebP format is larger than the original, the browser will use the original file. This converted file will be deleted. Therefore, you can also see files other than WebP on the list.

If you want to force the use of WebP files, uncheck the `Automatic removal of WebP files larger than original` option in the plugin settings. Then click on the `Regenerate All` button to convert all images again.

In addition, images may not be displayed in WebP format if they are files downloaded from the `/themes` directory or from a directory of another plugin that is not compatible.

Remember that this plugin supports images from the `/uploads` directory, i.e. files downloaded from the media library. Similarly, if your images are downloaded from another domain, i.e. from an external service.

When checking the operation of the plugin, e.g. in Dev Tools, pay attention to the path from which the files are downloaded.

= Where are converted images stored? =

All WebP images are stored in the `/wp-content/uploads-webpc/` directory. Inside the directory there is the same structure as in the original `uploads` directory. The files have original extensions in the name along with the new `.webp`.

In case the location of the original file is as follows: `/wp-content/uploads/2019/06/example.jpg` then its converted version will be in the following location: `/wp-content/uploads-webpc/2019/06/example.jpg.webp`.

Original images are not changed. If you remove plugins, only WebP files will be deleted. Your images are not changed in any way.

= How to change path to uploads? =

This is possible using the following types of filters to change default paths. It is a solution for advanced users. If you are not, please skip this question.

Path to the root installation directory of WordPress *(`ABSPATH` by default)*:

`add_filter('webpc_uploads_root', function($path) {
  return ABSPATH;
});`

Path to `/uploads` directory *(relative to the root directory)*:

`add_filter('webpc_uploads_path', function($path) {
  return 'wp-content/uploads';
});`

Directory path with converted WebP files *(relative to the root directory)*:

`add_filter('webpc_uploads_webp', function($path) {
  return 'wp-content/uploads-webpc';
});`

Prefix in URL of `/wp-content/` directory or equivalent *(used in .htaccess)*:

`add_filter('webpc_uploads_prefix', function($prefix) {
  return '/';
});`

For the following sample custom WordPress structure:

`...
├── web
    ...
    ├── app
    │   ├── mu-plugins
    │   ├── plugins
    │   ├── themes
    │   └── uploads
    ├── wp-config.php
    ...`

Use the following filters:

`add_filter('webpc_uploads_root', function($path) {
  return 'C:/WAMP/www/project/webp'; // your valid path
});
add_filter('webpc_uploads_path', function($path) {
  return 'app/uploads';
});
add_filter('webpc_uploads_webp', function($path) {
  return 'app/uploads-webpc';
});`
`add_filter('webpc_uploads_prefix', function($prefix) {
  return '/';
});`

After setting the filters go to `Settings -> WebP Converter` in the admin panel and click the `Save Changes` button. `.htaccess` files with appropriate rules should be created in the directories `/uploads` and `/uploads-webpc`.

= How to run manually conversion? =

By default, all images are converted when you click on the `Regenerate All` button. In addition, conversion is automatic when you add new files to your media library.

Remember that our plugin takes into account images generated by WordPress. There are many plugins that generate, for example, images of a different size or in a different version. Unfortunately, we are not able to integrate with any such plugin.

If you would like to integrate with your plugin, which generates images by yourself, you can do it. Our plugin provides the possibility of this type of integration. This works for all images in the `/uploads` directory.

It is a solution for advanced users. If you would like to integrate with another plugin, it's best to contact the author of that plugin and give him information about the actions available in our plugin. This will help you find a solution faster.

To manually start converting selected files, you can use the action to which you will pass an array with a list of paths *(they must be absolute server paths)*:

`do_action('webpc_convert_paths', $paths);`

An alternative method is to manually start converting the selected attachment by passing the post ID from the media library. Remember to run this action after registering all image sizes *(i.e. after running the `add_image_size` function)*:

`do_action('webpc_convert_attachment', $postId);`

In addition, you can edit the list of files that will be converted. For example, to add some to the exceptions. To do this, use the following filter, which by default returns a list of all paths:

`add_filter('webpc_attachment_paths', function($paths, $attachmentId) {
  return $paths;
}, 10, 2);`

Argument `$paths` is array of absolute server paths and `$attachmentId` is the post ID of attachment, added to the media library.

To delete manually converted files, use the following action, providing as an argument an array of absolute server paths to the files *(this will delete manually converted files)*:

`do_action('webpc_delete_paths', $paths);`

= How to change .htaccess rules? =

Manually editing the rules in the .htaccess file is a task only for experienced developers. Remember that the wrong rules can cause your website to stop working.

Below is a list of filters that allow you to modify all rules. Remember that it's best to use your own rule set rather than edit parts of exists. This will ensure greater failure-free after plugin update.

Returning an empty string will delete these rules the next time you save the plugin settings. You must do this after each filter edit.

Rules for redirects: *(returns rules for `mod_rewrite` module)*:

`add_filter('webpc_htaccess_mod_rewrite', function($rules) {
  return '';
});`

Rules for `image/webp` MIME type: *(returns rules for `mod_mime` module)*:

`add_filter('webpc_htaccess_mod_mime', function($rules) {
  return '';
});`

Rules for Browser Caching: *(returns rules for `mod_expires` module)*:

`add_filter('webpc_htaccess_mod_expires', function($rules) {
  return '';
});`

All rules from the files `/uploads/.htaccess` and `/uploads-webpc/.htaccess`: *(returns rules for modules: `mod_rewrite`, `mod_mime` and `mod_expires`)*:

`add_filter('webpc_htaccess_rules', function($rules, $path) {
  return '';
}, 10, 2);`

Argument `$path` is absolute server path for `.htaccess` file.

= What is Browser Caching? =

This option allows you to speed up page loading time for returning users because they do not need to re-download files from the server. The plugin allows this by using the module `mod_expires`. 

It is enabled by default. If you do not want to use this functionality, you can turn it off at any time.

= Does plugin support CDN? =

Unfortunately not. This is due to the logic of the plugin's operation. Plugins that enable integration with the CDN servers modify the HTML of the website, changing URLs for media files. This plugin does not modify URLs. Replacing URLs in the HTML code is not an optimal solution.

The main problem when changing URLs is cache. When we modify the image URL for WebP supporting browser, then use the browser without WebP support, it will still have the URL address of an image in .webp format, because it will be in the cache.

While in the case of the `img` tag you can solve this problem, in the case of `background-image` it is possible. We wanted full support so that all images added to the media library would be supported - no matter how they are displayed on the website.

Therefore in this plugin for browsers supporting the WebP format, only the source of the file is replaced by using the `mod_rewrite` module on the server. The URL for image remains the same. This solves the whole problem, but it is impossible to do when the files are stored on the CDN server.

If you are using a CDN server, find one that automatically converts images to WebP format and properly sends the correct image format to the browser.

= Configuration for Nginx =

Please edit the configuration file:

`/etc/nginx/mime.types`

and add this code:

`types {`
`  # ...

  image/webp webp;
}`

Then please find your configuration file in the path *(default is default file)*:

`/etc/nginx/sites-available/`

and add below code in this file:

`server {`
`  # ...

  location ~ /wp-content/uploads/(?<path>.+)\.(?<ext>jpe?g|png|gif)$ {
    if ($http_accept !~* "image/webp") {
      break;
    }
    add_header Vary Accept;
    expires 365d;
    try_files /wp-content/uploads-webpc/$path.$ext.webp $uri =404;
  }
}`

= Configuration for Multisite Network =

Yes, with one exception. In this mode it is not possible to automatically generate the contents of .htaccess files.

Please manually paste the following code **at the beginning of .htaccess file** in the `/wp-content/uploads` directory:

`# BEGIN WebP Converter`
`# ! --- DO NOT EDIT PREVIOUS LINE --- !`
`<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{DOCUMENT_ROOT}/wp-content/uploads-webpc/$1.jpg.webp -f
  RewriteRule (.+)\.jpg$ /wp-content/uploads-webpc/$1.jpg.webp [NC,T=image/webp,E=cache-control:private,L]
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{DOCUMENT_ROOT}/wp-content/uploads-webpc/$1.jpeg.webp -f
  RewriteRule (.+)\.jpeg$ /wp-content/uploads-webpc/$1.jpeg.webp [NC,T=image/webp,E=cache-control:private,Lp]
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{DOCUMENT_ROOT}/wp-content/uploads-webpc/$1.png.webp -f
  RewriteRule (.+)\.png$ /wp-content/uploads-webpc/$1.png.webp [NC,T=image/webp,E=cache-control:private,L]
</IfModule>`
`# ! --- DO NOT EDIT NEXT LINE --- !`
`# END WebP Converter`

And the following code **at the beginning of .htaccess file** in the `/wp-content/uploads-webpc` directory:

`# BEGIN WebP Converter`
`# ! --- DO NOT EDIT PREVIOUS LINE --- !`
`<IfModule mod_mime.c>
  AddType image/webp .webp
</IfModule>
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/webp "access plus 1 year"
</IfModule>`
`# ! --- DO NOT EDIT NEXT LINE --- !`
`# END WebP Converter`

= Is the plugin completely free? =

Yes. The plugin is completely free.

However, working on plugins and technical support requires many hours of work. If you want to appreciate it, you can [provide us a coffee](https://ko-fi.com/gbiorczyk/). Thanks everyone!

Thank you for all the ratings and reviews.

If you are satisfied with this plugin, please recommend it to your friends. Every new person using our plugin is valuable to us.

This is all very important to us and allows us to do even better things for you!

== Screenshots ==

1. Screenshot of the options panel
2. Screenshot when regenerating images

== Changelog ==

= 1.2.6 (2020-05-28) =
* `[Fixed]` Removal of WebP files larger than original during upload

= 1.2.5 (2020-05-10) =
* `[Removed]` Link to plugin settings on Network Admin Screen for WordPress Multisite
* `[Fixed]` Path in RewriteRule for WordPress Multisite
* `[Changed]` Error messages in administration panel
* `[Added]` Support for `disable_functions` setting for using `set_time_limit` function
* `[Added]` Support for blocked function `file_get_contents`

= 1.2.4 (2020-04-24) =
* `[Changed]` Error messages in administration panel
* `[Added]` Action `webpc_delete_paths` to delete images by paths

= 1.2.3 (2020-04-15) =
* `[Added]` Blocking server cache for rewrite rules
* `[Added]` Detecting whether requests to images are processed by server bypassing Apache

= 1.2.2 (2020-04-08) =
* `[Changed]` Moving rules for modules `mod_mime` and `mod_expires` to `/uploads-webpc/.htaccess` file
* `[Changed]` New argument for filter `webpc_htaccess_rules` with server path of file

= 1.2.1 (2020-04-07) =
* `[Removed]` Filter `webpc_option_disabled`
* `[Fixed]` Converting images multiple times when uploading to media library
* `[Added]` Action `webpc_convert_paths` to convert images by paths
* `[Added]` Action `webpc_convert_attachment` to convert images by Post ID

= 1.2.0 (2020-04-05) =
* `[Changed]` Moving rules from .htaccess file in root directory of WordPress to `/wp-content/uploads` directory
* `[Added]` Ability to disable automatic removal of WebP files larger than original
* `[Added]` Error validation for a non-writable .htaccess file
* `[Added]` Filter `webpc_uploads_root` to change path for root installation directory of WordPress

= 1.1.2 (2020-03-03) =
* `[Added]` Zero padding at end for odd-sized WebP files using `GD` library

= 1.1.1 (2020-02-13) =
* `[Changed]` Unknown error handling when converting images
* `[Added]` Ability to skip converting existing images when `Regenerate All`
* `[Added]` Button for simple checking of server configuration

= 1.1.0 (2020-02-10) =
* `[Fixed]` Support for WordPress installation in subdirectory
* `[Fixed]` Error detecting WebP support by Imagick

= 1.0.9 (2020-01-03) =
* `[Added]` Limit of maximum image resolution limit using `GD` library

= 1.0.8 (2019-12-19) =
* `[Fixed]` File deletion for custom paths with converted WebP files
* `[Changed]` Rules management in .htaccess file when activating or deactivating plugin
* `[Added]` Error detection system in server configuration
* `[Added]` Blocking image conversion when `GD` or `Imagick` libraries are unavailable

= 1.0.7 (2019-12-17) =
* `[Changed]` Rewrite rules in .htaccess file
* `[Added]` Custom path support for original uploads files
* `[Added]` Custom path support for saving converted WebP files
* `[Added]` Filter `webpc_uploads_path` to change path for original uploads files
* `[Added]` Filter `webpc_uploads_webp` to change path for saving converted WebP files

= 1.0.6 (2019-11-06) =
* `[Changed]` Way of generating file path _(without `ABSPATH`)_
* `[Added]` Automatic deletion of converted files larger than original

= 1.0.5 (2019-09-16) =
* `[Added]` Information on available FAQ

= 1.0.4 (2019-07-11) =
* `[Changed]` Limits of maximum execution time

= 1.0.3 (2019-06-26) =
* `[Added]` Additional security rules

= 1.0.2 (2019-06-25) =
* `[Changed]` Error messages
* `[Added]` Tab in Settings page about server configuration

= 1.0.1 (2019-06-23) =
* `[Changed]` Securing access to REST API
* `[Added]` Error handler for undefined `GD` extension

= 1.0.0 (2019-06-16) =
* The first stable release

== Upgrade Notice ==

None.