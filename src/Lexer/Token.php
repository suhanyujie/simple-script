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

    protected $type;

    protected $value;

    /**
     * @var SourceLoc
     */
    protected $loc;

    /**
     * @desc 构造函数
     */
    public function __construct($type, $value, SourceLoc $loc)
    {
        $this->type = $type;
        $this->value = $value;
        $this->loc = $loc;
    }
}
