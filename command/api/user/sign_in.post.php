<?php



return api_permission('', function ( $param) {
    return api_check_callback($param,array (
  'name' => 'string',
  'password' => 'string',
  'client_id' => 'int',
  'client_token' => 'string',
),'model\User::signIn');});

