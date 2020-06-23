<?php

  namespace WebpConverter\Regenerate;

  class Endpoints
  {
    public $namespace = 'webp-converter/v1';

    public function __construct()
    {
      add_action('rest_api_init',             [$this, 'restApiEndpoints']);
      add_filter('webpc_rest_api_paths',      [$this, 'showApiPathsUrl']); 
      add_filter('webpc_rest_api_regenerate', [$this, 'showApiRegenerateUrl']); 
    }

    /* ---
      Functions
    --- */

    public function restApiEndpoints()
    {
      register_rest_route(
        $this->namespace,
        'paths',
        [
          'methods'  => \WP_REST_Server::ALLMETHODS,
          'permission_callback' => function() {
            return (isset($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'wp_rest')
              && current_user_can('manage_options'));
          },
          'callback' => [$this, 'getPaths'],
          'args'     => [
            'skip_converted' => [
              'description'       => 'Option to skip converted images (set `1` to enable)',
              'required'          => false,
              'default'           => false,
              'sanitize_callback' => function($value, $request, $param) {
                return ($value === '1') ? true : false;
              }
            ],
          ],
        ]
      );

      register_rest_route(
        $this->namespace,
        'regenerate',
        [
          'methods'  => \WP_REST_Server::ALLMETHODS,
          'permission_callback' => function() {
            return (isset($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'wp_rest')
              && current_user_can('manage_options'));
          },
          'callback' => [$this, 'convertImages'],
          'args'     => [
            'paths' => [
              'description'       => 'Array of file paths (server paths)',
              'required'          => true,
              'default'           => [],
              'validate_callback' => function($value, $request, $param) {
                return is_array($value) && $value;
              }
            ],
          ],
        ]
      );
    }

    public function getPaths($request)
    {
      $params = $request->get_params();
      if ($params['skip_converted']) new Skip();

      $data = (new Paths())->getPaths();
      if ($data !== false) return new \WP_REST_Response($data, 200);
      else return new \WP_Error('webpc_rest_api_error', null, ['status' => 405]);
    }

    public function convertImages($request)
    {
      $params = $request->get_params();
      $data   = (new Regenerate())->convertImages($params['paths']);
      if ($data !== false) return new \WP_REST_Response($data, 200);
      else return new \WP_Error('webpc_rest_api_error', null, ['status' => 405]);
    }

    public function showApiPathsUrl()
    {
      $nonce = wp_create_nonce('wp_rest');
      $url   = get_rest_url(null, $this->namespace . '/paths?_wpnonce=' . $nonce);
      return $url;
    }

    public function showApiRegenerateUrl()
    {
      $nonce = wp_create_nonce('wp_rest');
      $url   = get_rest_url(null, $this->namespace . '/regenerate?_wpnonce=' . $nonce);
      return $url;
    }
  }