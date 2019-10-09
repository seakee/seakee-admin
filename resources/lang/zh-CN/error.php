<?php
/**
 * File: error.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/10/9 3:05 下午
 * Description:
 */

use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    'failed'                  => '失败。',
    'model_not_found'         => '没有查询到任何结果。',
    'token_invalid'           => '无法验证令牌签名。',
    'not_logged_in'           => '未登录。',
    'token_not_provided'      => '令牌没有提供。',
    'method_not_allowed'      => '请求方法不允许。',
    'reg_failed'              => '注册失败。',
    'grant_permission_failed' => '授权失败。',
    'grant_role_failed'       => '分配角色失败。',
    'update_failed'           => '更新失败。',
    'destroy_failed'          => '删除失败。',
    'creates_failed'          => '创建失败。',
    'not_found'               => '未找到。',
];
