<?php
/**
 * Lapi\Response
 */
namespace Lapi\Response;

/**
 * Error
 */
class Error
{
    const CODE_BAD_REQUEST           = 400;//通常のエラー
    const CODE_UNAUTHORIZED          = 401;//認証エラー
    const CODE_FORBIDDEN             = 403;//アクセス権がない
    const CODE_NOT_FOUND             = 404;//リソースが見当たらない
    const CODE_NOT_ALLOWED           = 405;//定義されていないHTTPメソッド
    const CODE_INTERNAL_ERROR        = 500;//サーバの内部エラー

    const CODE_INVALID_PARAMETER     = 1000;//入力項目のバリデーションエラー
    const CODE_LACK_PARAMETER        = 1001;//入力項目の不足
    const CODE_UNREGISTERED_MAIL     = 1002;//登録されていないメール
    const CODE_INVALID_CONTROL_POINT = 1003;//不正なポイント操作
    const CODE_INVALID_ACCOUNT       = 1004;//存在しないアカウント
    const CODE_ALREADY_REGIST        = 1005;//すでに登録済みのアカウント
    const CODE_OVER_POINT            = 1006;//ポイント最大値を超える
    const CODE_SHORTAGE_POINT        = 1007;//ポイント最小値を下回る
    const CODE_INVALID_MODEL         = 1008;//不正なモデルを取得
    const CODE_FAILURE_OAUTH         = 1009;//OAuthに失敗
    const CODE_INVALID_OAUTH         = 1010;//不正な認証(OAuth)

    public static $urls = [
               self::CODE_BAD_REQUEST        => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_UNAUTHORIZED       => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_FORBIDDEN          => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_NOT_FOUND          => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_NOT_ALLOWED        => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_INTERNAL_ERROR     => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_INVALID_PARAMETER     => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_LACK_PARAMETER        => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_UNREGISTERED_MAIL     => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_INVALID_CONTROL_POINT => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_INVALID_ACCOUNT       => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_ALREADY_REGIST        => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_OVER_POINT            => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_SHORTAGE_POINT        => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_INVALID_MODEL         => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_FAILURE_OAUTH         => 'https://api.localinfos.platform.gochipon.com/v2/',
               self::CODE_INVALID_OAUTH         => 'https://api.localinfos.platform.gochipon.com/v2/',
    ];
}
