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

        ASSIGN_OP = "=",
        MUL = "*",
        DIV = "/",
        ADD = "+",
        SUB = "-",

        PRINT_STMT = "print",
        ASSIGN_STRING = "ASSIGN_STRING",

        STRING = "string",
        NUMBER = "number";
}
