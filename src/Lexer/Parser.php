<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2020-04-17
 * Time: 17:07
 */

namespace SRC\Lexer;


class Parser
{
    protected $lexer;

    public function __construct($lexer)
    {
        $this->lexer = $lexer;
    }

    /**
     * @desc test 解析
     */
    public function parseProg()
    {

    }
}
