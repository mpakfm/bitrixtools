<?php

use Mpakfm\Bitrixtools\PhpCsFixerTool\PhpCsFixerConfig;
use PhpCsFixer\Config;

define('NOT_CHECK_PERMISSIONS', true);
define("NO_AGENT_CHECK", true);

require_once __DIR__ . DIRECTORY_SEPARATOR . '/vendor/autoload.php';

if ($_SERVER['DOCUMENT_ROOT'] == '') {
    $_SERVER['DOCUMENT_ROOT'] = __DIR__;
}

$conf = new Config();
$conf->setUsingCache(true)
    ->setRiskyAllowed(true)
    ->setFinder(PhpCsFixerConfig::createPhpFilesFinder())
    ->setRules(PhpCsFixerConfig::getAppliedRulesConfigForPhpFiles());

return $conf;
