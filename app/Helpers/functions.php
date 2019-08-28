<?php
/**
 * File: functions.php
 * Author: Seakee <seakee23@163.com>
 * Homepage: https://seakee.top
 * Date: 2018/8/24 16:31
 * Description:
 */


if (!function_exists('friendly_date')) {
	/**
	 * 生成友好时间形式
	 *
	 * @param $from
	 *
	 * @return false|string
	 */
	function friendly_date($from): string
	{
		static $now = NULL;
		$now == NULL && $now = time();
		!is_numeric($from) && $from = strtotime($from);
		$seconds = $now - $from;
		$minutes = floor($seconds / 60);
		$hours   = floor($seconds / 3600);
		$day     = round((strtotime(date('Y-m-d', $now)) - strtotime(date('Y-m-d', $from))) / 86400);
		if ($seconds == 0) {
			return '刚刚';
		}
		if (($seconds >= 0) && ($seconds <= 60)) {
			return "{$seconds}秒前";
		}
		if (($minutes >= 0) && ($minutes <= 60)) {
			return "{$minutes}分钟前";
		}
		if (($hours >= 0) && ($hours <= 24)) {
			return "{$hours}小时前";
		}
		if ((date('Y') - date('Y', $from)) > 0) {
			return date('Y-m-d', $from);
		}

		switch ($day) {
			case 0:
				return date('今天H:i', $from);
				break;

			case 1:
				return date('昨天H:i', $from);
				break;

			default:
				return "{$day} 天前";
				break;
		}
	}
}

if (!function_exists('is_mobile_number')) {
	/**
	 * 校验是否为中国手机号码（截止2018-09-29）
	 *
	 * @param string $number
	 *
	 * @return bool
	 */
	function is_mobile_number(string $number): bool
	{
		return preg_match('/^(\+?0?86\-?)?((13\d|14[579]|15[^4,\D]|16[6]|19[89]|17[135678]|18\d)\d{8}|170[059]\d{7})$/', $number);
	}
}

if (!function_exists('is_valid_name')) {
	/**
	 * 校验是否为有效的用户名
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	function is_valid_name(string $name): bool
	{
		return preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name);
	}
}

if (!function_exists('human_file_size')){
	/**
	 * 返回可读性更好的文件尺寸
	 *
	 * @param     $bytes
	 * @param int $decimals
	 *
	 * @return string
	 */
	function human_file_size($bytes, $decimals = 2): string
	{
		$size   = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
		$factor = floor((strlen($bytes) - 1) / 3);

		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
	}
}

if (!function_exists('filter_request_params')) {
	/**
	 * 获取指定key的输入值，并过滤空值项
	 *
	 * @param array                    $paramsKey
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	function filter_request_params(array $paramsKey, \Illuminate\Http\Request $request): array
	{
		foreach ($paramsKey as $key) {
			if ($request->filled($key)) {
				$data[$key] = $request->input($key);
			}
		}

		return $data ?? [];
	}
}

if (!function_exists('clear_cache')) {
	/**
	 * 清除指定key的缓存
	 *
	 * @param array|string  $key
	 * @param bool          $is_tags
	 */
	function clear_cache($key, $is_tags = false)
	{
		if ($is_tags){
			\Cache::tags($key)->flush();
		}

		if (is_array($key)){
			foreach ($key as $k){
				\Cache::forget($k);
			}
		} else {
			\Cache::forget($key);
		}
	}
}

/**
 * 过滤二维数组中重复的数组(以数组中某个键值为判断)
 *
 * @param array $array
 * @param       $key
 *
 * @return array
 */
if (!function_exists('array_filter_repeat')) {
    function array_filter_repeat($array, $key)
    {
        $i          = 0;
        $temp_array = [];
        $key_array  = [];

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i]  = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }

        return $temp_array;
    }
}
