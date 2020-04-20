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

        MUL = "*",
        DIV = "/",
        ADD = "+",
        SUB = "-",

        PRINT_STMT = "print",

        ASSIGN_OP = "=",
        ASSIGN_STRING = "ASSIGN_STRING",
        ASSIGN_INT = "ASSIGN_INT",

        ADD_EXPR = "ADD_EXPR",
        MULTIPLE_EXPR = "MULTIPLE_EXPR",

        STRING = "string",
        NUMBER = "number";
}
