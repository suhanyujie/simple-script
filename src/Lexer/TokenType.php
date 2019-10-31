<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-24
 * Time: 09:19
 */

namespace SRC\Lexer;


class TokenType
{
    const EOF = "eof",
        IDENTITY = "identity",
        STRING = "string",
        NUMBER = "number",
        MUL = "*",
        DIV = "/",
        ADD = "+",
        SUB = "-",
        PRINT_STMT = "print";
}
