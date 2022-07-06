<?php
/**
 * Created by PhpStorm.
 * User: mpak
 * Date: 26.01.2022
 * Time: 2:40
 */

namespace Tests;

use PHPUnit\Framework\TestCase;

class InitTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        global $USER;
        if (!$USER) {
            $USER = new \CUser();
        }
        $USER->Authorize(1);
    }

    public function testInit()
    {
        global $USER;

        assertNotEmpty($USER, 'Empty $USER');
        assertSame('1', $USER->GetID(),  'Unknown user');
    }
}
