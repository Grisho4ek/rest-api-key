<?php

/*
Plugin Name: RestApiKey
Description: Plugin for using api-key for rest-api
Version: 1.0
Author: Grygorii Shevchenko
*/


namespace RestApiKey;

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
function check_key(array $result, \WP_REST_Server $server, \WP_Rest_Request $request): array
{

  if ($request->get_header('x-api-key') != $_ENV['API_KEY']) {
    return [
      'succes'  => false,
      'message' => __('bie'),
    ];
  }

  return $result;
}

add_filter('rest_pre_echo_response', 'RestApiKey\check_key', 10, 3);
