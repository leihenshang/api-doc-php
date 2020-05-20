<?php


namespace App\Helper;

/**
 * 帮助类-输出提示
 * Class Helper
 * @package App\Helper
 */
class Helper
{
    /**
     * success
     * @param null $data
     * @param int $code
     * @param string $msg
     * @return array
     */
    public static function success($data = null, int $code = 0, string $msg = '')
    {

        return [
            'msg' => $msg,
            'code' => $code,
            'data' => $data
        ];
    }

    /**
     * failed
     * @param string $msg
     * @param int $code
     * @param null $data
     * @return array
     */
    public static function failed(string $msg = '', int $code = 1, $data = null)
    {
        return [
            'msg' => $msg,
            'code' => $code,
            'data' => $data
        ];
    }
}