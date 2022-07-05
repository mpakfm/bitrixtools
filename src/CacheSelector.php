<?php

namespace Mpak\Bitrixtools;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Data\Cache;
use RuntimeException;

class CacheSelector
{
    /** @var string */
    const DEFAULT_LID = 's1';
    /** @var int */
    const CACHE_TIME = 2592000;

    public static function getCacheTime()
    {
        if (defined('CACHETIME_MONTH')) {
            return CACHETIME_MONTH;
        }
        return self::CACHE_TIME;
    }

    public static function getIblock (string $code, string $iblockTypeId = '', $lid = null, $cacheTime = null)
    {
        if ($code == '') {
            throw new RuntimeException('IBlock CODE can not be empty');
        }

        if (!$lid || $lid == '') {
            $lid = self::DEFAULT_LID;
        }

        $cacheId  = 'GetBlockId_' . $code . '_' . $iblockTypeId . '_' . $lid;
        $cacheDir = 'CacheSelector';
        $result   = null;

        if (is_null($cacheTime)) {
            $cacheTime = static::getCacheTime();
        } else {
            $cacheTime = (int) $cacheTime;
        }
        $cache = Cache::createInstance();
        if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
            $result = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $filter = [
                'LID'            => $lid,
                'IBLOCK_TYPE_ID' => $iblockTypeId,
                'CODE'           => $code,
            ];
            $stmt = IblockTable::getRow([
                'filter' => $filter,
                'limit'  => 1,
                'cache'  => [
                    'ttl' => 0,
                ],
            ]);

            if (!$stmt) {
                $cache->abortDataCache();
            } else {
                $result = $stmt['ID'];
            }
            $cache->endDataCache($result);
        }
        return $result;
    }
}
