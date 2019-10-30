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

    /**
     * @var token 对应的值信息
     */
    public $value;

    /**
     * @var SourceLoc
     * token 对应的源码位置等信息对象
     */
    public $loc;

    /**
     * @desc 构造函数
     */
    public function __construct($type, $value=null, SourceLoc $loc=null)
    {
        $this->type = $type;
        $this->value = $value;
        $this->loc = $loc;
    }

    /**
     * @desc 设置 $value 属性
     */
    public function setValue($value='')
    {
        $this->value = $value;
    }

    /**
     * @desc 设置 $loc 属性
     */
    public function setLoc(SourceLoc $loc)
    {
        $this->loc = $loc;
    }
}
