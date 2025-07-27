<?php


namespace Cms\Helpers;


use Cassandra\Collection;
use Illuminate\Database\Eloquent\Builder;

class RedisHelper
{
    public static $secret     = 'fetvi';
    public static $redisCache = true;

    /**
     * Generates Unique key for caching based on function name
     *
     * @param string $funcName
     * @param string $additional
     * @return string
     */
    public static function generateKey(string $funcName, $additional = ''): string
    {
        $additional = is_array($additional) ? http_build_query($additional) : $additional;
        return $funcName . '_' . lang() . '_' . $additional . '_' . md5(self::$secret);
    }
    /**
     * Checks if passed key exists in redis storage
     *
     * @param string $key
     * @return boolean
     */
    public static function exists(string $key = NULL): bool
    {
        if (is_null($key)) {
            return false;
        }

        return app('redis')->exists($key);
    }
    /**
     * Alias of exists
     *
     * @return boolean
     */
    public static function has(string $key = NULL)
    {
        if(is_null($key)) {
            return false;
        }

        return self::exists($key);
    }

    /**
     * forgets passed key in redis storage
     *
     * @param string $key
     * @return void
     */
    public static function forget(string $key = NULL)
    {
        if(is_null($key)) {
            return true;
        }

        return app('redis')->del($key);
    }
    /**
     * returns value by key in object format
     *
     * @param string $key
     * @return JSON
     */
    public static function get(string $key)
    {
        return json_decode(self::getRaw($key), true);
    }

    /**
     * returns raw data from redis cache by key
     *
     * @param string $key
     * @param string $Type
     * @return any
     */
    public static function getRaw(string $key = NULL, $Type = 'JSON')
    {
        if(is_null($key)) {
            return false;
        }
        if ($Type == 'ARRAY'){
            return json_decode(app('redis')->get($key), true);
        }
        return app('redis')->get($key);
    }
    /**
     * Sets passed key to passed value in redis storage.
     * value will be transformed to json if it's array or object.
     *
     * @param string $key
     * @param [any] $value
     * @return boolean
     */
    public static function set(string $key, $value, $time = NULL): bool
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        if(is_null($time)) {
            $time = config('local.redis.CACHE_DURATION', 12);
        }

        app('redis')->set($key, $value);
        app('redis')->expire($key, $time);

        return true;
    }

    public static function wrap(string $name, $func, $duration = 3600) {
        $key = self::generateKey($name);
        if(self::has($key)) {
            return self::get($key);
        }

        $result = $func();

        self::set($key, $result, $duration);

        return $result;
    }

}
