<?php

namespace Tests\Tools;

use Bitrix\Main\Loader;
use Mpakfm\Bitrixtools\Tools\CacheSelector;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sprint\Migration\HelperManager;

class CacheSelectorTest extends TestCase
{
    public static $iblockType = 'test';
    public static $iblockCode = 'test-ib';
    public static $iblockName = 'test name';

    public static function setUpBeforeClass(): void
    {
        if (!Loader::includeModule('sprint.migration')) {
            throw new RuntimeException('need to install module sprint.migration');
        }

        $helper = HelperManager::getInstance();

        $helper->Iblock()->addIblockTypeIfNotExists([
            'ID'               => self::$iblockType,
            'SECTIONS'         => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER'  => '',
            'IN_RSS'           => 'N',
            'SORT'             => '500',
            'LANG'             => [
                'ru' => [
                    'NAME'         => 'Test',
                    'SECTION_NAME' => '',
                    'ELEMENT_NAME' => '',
                ],
                'en' => [
                    'NAME'         => 'Test',
                    'SECTION_NAME' => '',
                    'ELEMENT_NAME' => '',
                ],
            ],
        ]);
        $helper->Iblock()->addIblockIfNotExists([
            'IBLOCK_TYPE_ID' => self::$iblockType,
            'LID'            => [
                0 => 's1',
            ],
            'CODE'                => self::$iblockCode,
            'API_CODE'            => '',
            'REST_ON'             => 'N',
            'NAME'                => self::$iblockName,
            'ACTIVE'              => 'Y',
            'SORT'                => '500',
            'LIST_PAGE_URL'       => '#SITE_DIR#/content/index.php?ID=#IBLOCK_ID#',
            'DETAIL_PAGE_URL'     => '#SITE_DIR#/content/detail.php?ID=#ELEMENT_ID#',
            'SECTION_PAGE_URL'    => '#SITE_DIR#/content/list.php?SECTION_ID=#SECTION_ID#',
            'CANONICAL_PAGE_URL'  => '',
            'PICTURE'             => null,
            'DESCRIPTION'         => '',
            'DESCRIPTION_TYPE'    => 'text',
            'RSS_TTL'             => '24',
            'RSS_ACTIVE'          => 'Y',
            'RSS_FILE_ACTIVE'     => 'N',
            'RSS_FILE_LIMIT'      => null,
            'RSS_FILE_DAYS'       => null,
            'RSS_YANDEX_ACTIVE'   => 'N',
            'XML_ID'              => null,
            'INDEX_ELEMENT'       => 'Y',
            'INDEX_SECTION'       => 'Y',
            'WORKFLOW'            => 'N',
            'BIZPROC'             => 'N',
            'SECTION_CHOOSER'     => 'L',
            'LIST_MODE'           => '',
            'RIGHTS_MODE'         => 'S',
            'SECTION_PROPERTY'    => 'N',
            'PROPERTY_INDEX'      => 'N',
            'VERSION'             => '2',
            'LAST_CONV_ELEMENT'   => '0',
            'SOCNET_GROUP_ID'     => null,
            'EDIT_FILE_BEFORE'    => '',
            'EDIT_FILE_AFTER'     => '',
            'SECTIONS_NAME'       => 'Разделы',
            'SECTION_NAME'        => 'Раздел',
            'ELEMENTS_NAME'       => 'Элементы',
            'ELEMENT_NAME'        => 'Элемент',
            'EXTERNAL_ID'         => null,
            'LANG_DIR'            => '/',
            'SERVER_NAME'         => 'itnmp.site',
            'IPROPERTY_TEMPLATES' => [
            ],
            'ELEMENT_ADD'    => 'Добавить элемент',
            'ELEMENT_EDIT'   => 'Изменить элемент',
            'ELEMENT_DELETE' => 'Удалить элемент',
            'SECTION_ADD'    => 'Добавить раздел',
            'SECTION_EDIT'   => 'Изменить раздел',
            'SECTION_DELETE' => 'Удалить раздел',
        ]);
    }

    public static function tearDownAfterClass(): void
    {
        $helper = HelperManager::getInstance();
        $helper->Iblock()->deleteIblockIfExists(self::$iblockCode, self::$iblockType);
        $helper->Iblock()->deleteIblockTypeIfExists(self::$iblockType);
    }

    public function testGetIblock()
    {
        $iblock = CacheSelector::getIblock(self::$iblockCode, self::$iblockType, 's1', 1);
        assertNotEmpty($iblock, 'Ошибка создания инфоблока');
        assertTrue(array_key_exists('ID', $iblock), 'Ошибка создания инфоблока, отсутствует ID');
        assertTrue(array_key_exists('CODE', $iblock), 'Ошибка создания инфоблока, отсутствует CODE');
        assertTrue(array_key_exists('NAME', $iblock), 'Ошибка создания инфоблока, отсутствует NAME');
        assertSame(self::$iblockCode, $iblock['CODE'], 'Ошибка создания инфоблока, не верный CODE');
    }

    public function testGetIblockId()
    {
        $iblockId = CacheSelector::getIblockId(self::$iblockCode, self::$iblockType, 's1', 1);
        assertNotEmpty($iblockId, 'Ошибка создания инфоблока');
        assertTrue(is_int($iblockId), 'Ошибка создания инфоблока, ID не integer');
    }
}
