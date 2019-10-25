<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-21
 * Time: 09:25
 */
include_once __DIR__."/../vendor/autoload.php";

use SRC\Lexer\Source;
use SRC\Lexer\Lexer;

/**
 * 编写读取源码相关逻辑
 *
 */

$src = new Source("string a = '12312312;'");
$token = $src->read();
$lexer = new Lexer($src);
var_dump($lexer->next());exit(PHP_EOL.'09:03'.PHP_EOL);

