<?php
namespace Treasure\Models;

use Phalcon\Http\Client\Request;
use Phalcon\Http\Response\StatusCode;
use Gcl\Util\GJson;

class ApiConnector
{

    const API_TOKEN = '4ccpa83JdB29uWCVby7MAccj8a5pxh';
    /**
     * request用のモデルを返す
     * @param void
     * @return Phalcon\Http\Client\Request
     */
    public static function createProvider()
    {
        $provider  = Request::getProvider();
        $config = require APP_DIR.'/v1/config/config.d/config.php';
        $accountURL = $config[APPLICATION_ENV]['account_domain'];
        $provider->setBaseUri($accountURL);
        $provider->header->set('Accept', 'application/json');
        return $provider;
    }

    /**
     * アカウントAPIと連携しアカウント情報を取ってくる
     * @param string $loginToken
     * @param string $appCode
     * @return mixed
     */
    public static function authenticate($loginToken, $appCode)
    {
        $provider = self::createProvider();
        $response = $provider->post('login/token', ['login_token' => $loginToken,
                                                      'app_code' => $appCode,
                                                      'without_session' => true]);

        // 問題あれば
        if ($response->header->statusCode !== StatusCode::OK) {
            return false;
        }

        $loginData = GJson::unserialize($response->body);
        return ['account_id' => (int)$loginData['id'],
                'account_name' => $loginData['nickname'],
                'app_code' => $appCode];
    }

    /**
     * 住所登録済みか確認
     * @param int $accountdId
     * @return boolean
     */
    public static function canRegister($accountId)
    {
        $provider = self::createProvider();
        $url = sprintf('accounts/%d/addresses/main', $accountId);
        $response = $provider->get($url, ['api_token' => self::API_TOKEN]);
        if ($response->header->statusCode === StatusCode::OK) {
            $body =  GJson::unserialize($response->body);
            if ($body['id']) {
                return true;
            }
        }
        return false;
    }

    /**
     * ポイントを消費
     * @param int $accountdId
     * @param int $point
     * @return boolean
     */
    public static function consumePoint($accountId, $point)
    {
        $provider = self::createProvider();
        $pointId = 1; // ポイントのID。初期は1種類なので出し分けはしない
        $url = sprintf('accounts/%d/points/%d', $accountId, $pointId);

        $response = $provider->put($url, ['type' => 'consume',
                                          'value' => $point,
                                          'api_token' => self::API_TOKEN]);
        if ($response->header->statusCode === StatusCode::OK) {
            return true;
        }
        return false;
    }

    /**
     * アプリケーション一覧を返す
     * @param void
     * @return array
     */
    public static function getApplications()
    {
        $provider = self::createProvider();
        $response = $provider->get('applications', ['api_token' => self::API_TOKEN]);
        if ($response->header->statusCode === StatusCode::OK) {
            return GJson::unserialize($response->body);
        }
        throw new \Exception("api connect is failure");
        return false;
    }


    /**
     * 対象のアカウント名を返す
     * @param void
     * @return array
     */
    public static function getAccount($accountId)
    {
        $provider = self::createProvider();
        $response = $provider->get('accounts/'.$accountId, ['fields' => 'nickname', 'api_token' => self::API_TOKEN]);
        if ($response->header->statusCode === StatusCode::OK) {
            $account = GJson::unserialize($response->body);
            return $account;
        }
        throw new \Exception("api connect is failure");
        return false;
    }


    /**
     * 商品の発送対象のアカウントを取得
     * @param \Resultset $accounts
     * @return array
     */
    public static function getToolSendSet($accounts)
    {
        $accountIds = [];
        foreach ($accounts as $account) {
            $accountIds[] = $account->account_id;
        }

        $accountIdsWithComma = implode(',', $accountIds);
        $provider = self::createProvider();
        $response = $provider->get('addresses/search/account_ids='.$accountIdsWithComma, ['api_token' => self::API_TOKEN]);

        if ($response->header->statusCode === StatusCode::OK) {
            return GJson::unserialize($response->body);
        }
        throw new \Exception("api connect is failure");
    }
}
