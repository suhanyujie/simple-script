<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-22
 * Time: 09:08
 */

namespace SRC\Lexer;


class Lexer
{
    protected $src = '';
    /**
     * @desc
     */
    public function __construct($src='')
    {
        $this->src = $src;
    }


    /**
     * @desc
     */
    public function next()
    {

    }


    /**
     * @desc 忽略空白符
     */
    public function skipWhitespace()
    {

    }
}
