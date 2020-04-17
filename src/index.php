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
use SRC\Lexer\Parser;

/**
 * 编写读取源码相关逻辑
 *
 */
$code = <<<CODE
  print "12312312";
  string a = '12312312'; 
CODE;

// 源码读取
$srcObj = new Source($code);
// 词法分析
$lexer = new Lexer($srcObj);
// 词法解析
$parser = new Parser($lexer);

for ($i=0;$i<10;$i++) {
    var_dump($lexer->next());
}

exit(PHP_EOL.'09:03'.PHP_EOL);

