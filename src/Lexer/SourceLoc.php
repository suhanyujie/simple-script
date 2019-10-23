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
    protected $start;

    protected $end;

    /**
     * @desc 构造方法
     */
    public function __construct($start=0, $end=0)
    {
        $this->start = $start;
        $this->end = $end;
    }
}
