<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-23
 * Time: 09:00
 */

namespace SRC\Lexer;


class Token
{
    const EOF = "eof";
    const STRING = "string";
    const NUMBER = "number";
    const MUL = "*";
    const DIV = "/";
    const ADD = "+";
    const SUB = "-";
    const PRINT_STMT = "print";
}
