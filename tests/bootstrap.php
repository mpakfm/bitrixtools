<?php

use PHPUnit\Framework\Assert;

define("NOT_CHECK_PERMISSIONS", true);
define("NO_AGENT_CHECK", true);
define("SITE_ID", 's1');
$GLOBALS["DBType"]        = 'mysql';
$_SERVER["DOCUMENT_ROOT"] = __DIR__ . '/../';

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

while (ob_get_level()) {
    ob_end_clean();
}

// Загружаем assert-функции из phpunit
require_once dirname((new ReflectionClass(Assert::class))->getFileName()) . '/Assert/Functions.php';
