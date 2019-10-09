<?php
/**
 * File: error.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/10/9 3:05 下午
 * Description:
 */

use Tymon\JWTAuth\Exceptions\TokenInvalidException;

return [
    /*
    |--------------------------------------------------------------------------
    | Error Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during error for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'                  => 'failed.',
    'model_not_found'         => 'No query results.',
    'not_logged_in'           => 'Not logged in.',
    'token_invalid'           => 'Token Signature could not be verified.',
    'token_not_provided'      => 'Token not provided.',
    'method_not_allowed'      => 'Method Not Allowed.',
    'reg_failed'              => 'Registration failed.',
    'grant_role_failed'       => 'Grant roles failed.',
    'grant_permission_failed' => 'Grant permissions failed.',
    'update_failed'           => 'Updated failed.',
    'destroy_failed'          => 'Destroy failed.',
    'create_failed'           => 'created failed.',
    'not_found'               => 'Not Found.',
];
