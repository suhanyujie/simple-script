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
use SRC\Lexer\Token;
use SRC\Lexer\TokenType;

/**
 * 编写读取源码相关逻辑
 *
 */
$code = <<<CODE
    int a = 123 + 10 * 3 + 98;
  print "12312312";
  string a = '12312312'; 
CODE;

// 源码读取
$srcObj = new Source($code);
// 词法分析
$lexer = new Lexer($srcObj);
// 词法解析
$parser = new Parser($lexer);

function printTokenTree(Token $tokenTree = null)
{
    if (empty($tokenTree)) return "";
    echo "Calculating:{$tokenTree->type}\n";
    if ($tokenTree->type == TokenType::ASSIGN_INT) {
        $currentToken = $tokenTree->value;
        if ($currentToken->type === TokenType::ADD_EXPR) {
            $childs = $currentToken->child;
            if (!empty($childs)) {
                printTokenTree($currentToken);
            } else {
                echo "\tResult:".$currentToken->value."\n";
            }
            echo "\tResult:".$currentToken->value."\n";
        }
    } elseif ($tokenTree->type == TokenType::NUMBER) {
        if (is_object($tokenTree->value)) {
            echo "\tResult:".$tokenTree->value->value."\n";
        } else {
            echo "\tResult:".$tokenTree->value."\n";
        }
    } elseif ($tokenTree->type == TokenType::ADD_EXPR) {
        $childs = $tokenTree->child;
        foreach ($childs as $child) {
            switch ($child->type) {
                case TokenType::NUMBER:
                    if (is_object($child->value)) {
                        echo "\tResult:".$child->value->value."\n";
                    } else {
                        echo "\tResult:".$child->value."\n";
                    }
                    break;
                default:
                    printTokenTree($child);
            }
        }
    } elseif ($tokenTree->type == TokenType::MULTIPLE_EXPR) {
        if (empty($tokenTree->value)) {
            $childs = $tokenTree->child;
            foreach ($childs as $child) {
                switch ($child->type) {
                    case TokenType::NUMBER:
                        echo "\tResult:".$child->value."\n";
                        break;
                    default:
                        printTokenTree($child);
                }
            }
        } else {
            printTokenTree($tokenTree->value);
        }
    }
}

for ($i=0;$i<10;$i++) {
    $tokenTree = $lexer->next();
//    print_r($token);
    printTokenTree($tokenTree);
    break;
}

exit(PHP_EOL.'09:03'.PHP_EOL);

