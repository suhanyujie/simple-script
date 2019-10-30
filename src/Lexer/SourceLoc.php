<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-23
 * Time: 09:02
 */

namespace SRC\Lexer;


class SourceLoc
{
    /**
     * @var Position
     */
    public $start;

    /**
     * @var Position
     */
    public $end;

    /**
     * @desc 构造方法
     */
    public function __construct(Position $start=null, Position $end=null)
    {
        $this->start = $start;
        $this->end = $end;
    }
}
