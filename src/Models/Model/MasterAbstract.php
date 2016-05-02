<?php
namespace Treasure\Models\Model;

/**
 * マスター系のデータ
 */
class MasterAbstract extends \Api\Models\ModelAbstract
{
    protected static $apcCache = array();

    public static function find($parameters = [])
    {
        // Create an unique key based on the parameters
        $key = self::getCacheKeyStatic($parameters);
        if (!isset(self::$apcCache[$key])) {
            // We're using APC as second cache
            if (apc_exists($key)) {
                $data = apc_fetch($key);
                // Store the result in the memory cache
                self::$apcCache[$key] = $data;
                return $data;
            }

            // There are no memory or apc cache
            $data = parent::find($parameters);

            // Store the result in the memory cache
            self::$apcCache[$key] = $data;

            // Store the result in APC
            apc_store($key, $data);
            return $data;
        }

        // Return the result in the cache
        return self::$apcCache[$key];
    }

    public static function findFirst($parameters = [])
    {
        // Create an unique key based on the parameters
        $key = self::getCacheKeyStatic($parameters);
        if (!isset(self::$apcCache[$key])) {
            // We're using APC as second cache
            if (apc_exists($key)) {
                $data = apc_fetch($key);
                // Store the result in the memory cache
                self::$apcCache[$key] = $data;
                return $data;
            }

            // There are no memory or apc cache
            $data = parent::findFirst($parameters);

            // Store the result in the memory cache
            self::$apcCache[$key] = $data;

            // Store the result in APC
            apc_store($key, $data);
            return $data;
        }

        // Return the result in the cache
        return self::$apcCache[$key];
    }

}
