<?php

/*
Plugin Name: RestApiKey
Description: Plugin for using api-key for rest-api
Version: 1.0
Author: Grygorii Shevchenko
*/

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

/**
 * Disables public access to the WordPress /wp/v2/users/* api routes.
 *
 *
 * @param array            $result  Results data from API request.
 * @param \WP_REST_Server  $server  Server instance.
 * @param \WP_Rest_Request $request Incoming Request.
 *
 * @return array
 */
function check_key(array $result, \WP_REST_Server $server, \WP_Rest_Request $request)
{

  if ($request->get_header('api-key') != $_ENV['API_KEY']) {
    return [
      'success'  => false,
      'message' => __('Permission denied'),
    ];
  }

  return $result;
}

add_filter('rest_pre_echo_response', 'check_key', 10, 3);
