<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-22
 * Time: 09:08
 */

namespace SRC\Lexer;

/**
 * 词法分析器
 * Class Lexer
 * @package SRC\Lexer
 */
class Lexer
{
    /**
     * @var Source
     */
    protected $src = null;

    /**
     * @desc 构造方法
     */
    public function __construct(Source $src)
    {
        $this->src = $src;
    }

    /**
     * @desc
     */
    public function peek()
    {
        
    }

    /**
     * @desc
     */
    public function next()
    {
        $token = $this->src->read();

        return $token;
    }

    /**
     * @desc 忽略空白符
     */
    public function skipWhitespace()
    {

    }
}
