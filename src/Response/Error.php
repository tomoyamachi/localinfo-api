<?php
/**
 * Papi\Response
 */
namespace Papi\Response;

/**
 * Error
 */
class Error
{

    const FAILED_SAVE_MODEL          = 'Failed: Save model';
    const INVALID_HTTP_METHOD        = 'Invalid: Method Not Allowed';
    const INVALID_REQUEST_PARAMETER  = 'Invalid: Request Parameter %s';
    const REQUIRED_REQUEST_PARAMETER = 'Required: Request Parameter %s';

    /**
     * Errorの基本
     */
    public static function getContent($code, $message)
    {
        $response = [
            'error' => [
                'code' => (int) $code,
                'message' => $message
            ]
        ];
        return $response;
    }

    /**
     * failedSaveModel
     * モデルの保存失敗
     *
     * {
     *     'error': {
     *         'code': 500,
     *         'message': 'Failed: Save model'
     *     }
     * }
     */
    public static function failedSaveModel()
    {
        return self::getContent(500, self::FAILED_SAVE_MODEL);
    }

    /**
     * invalidHttpMethod
     * HTTPメソッドが無効
     *
     * {
     *     'error': {
     *         'code': 405,
     *         'message': 'Invalid: Http Method'
     *     }
     * }
     */
    public static function invalidHttpMethod()
    {
        return self::getContent(405, self::INVALID_HTTP_METHOD);
    }

    /**
     * invalidRequestParameter
     * リクエストされた値が無効
     *
     * {
     *     'error': {
     *         'code': 404,
     *         'message': 'Invalid: Request Parameter %s'
     *     }
     * }
     */
    public static function invalidRequestParameter($name)
    {
        return self::getContent(404, sprintf(self::INVALID_REQUEST_PARAMETER, $name));
    }

    /**
     * requiredRequestParameter
     * リクエストされた値が無効
     *
     * {
     *     'error': {
     *         'code': 400,
     *         'message': 'Required: Request Parameter %s'
     *     }
     * }
     */
    public static function requiredRequestParameter($name)
    {
        return self::getContent(400, sprintf(self::REQUIRED_REQUEST_PARAMETER, $name));
    }
}
