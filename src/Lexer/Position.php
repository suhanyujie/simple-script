<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-23
 * Time: 09:16
 */

namespace SRC\Lexer;

/**
 * 源码字符坐标/位置
 * Class Position
 * @package SRC\Lexer
 */
class Position
{
    protected $offset;

    protected $line;

    protected $col;

    /**
     * @desc 构造一个源码字符的位置
     */
    public function __construct($offset=0, $line=0, $col=0)
    {
        $this->offset = $offset;
        $this->line = $line;
        $this->col = $col;
    }
}
