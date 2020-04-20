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
    // token 类型
    public $type;

    public $typeOfAssign = null;

    public $identifier = null;

    /**
     * @var token 对应的值信息
     */
    public $value;

    public $child = [];

    /**
     * @var SourceLoc
     * token 对应的源码位置等信息对象
     */
    public $loc;

    /**
     * @desc 构造函数
     */
    public function __construct($type = null, $value = null, SourceLoc $loc = null)
    {
        $this->type = $type;
        $this->value = $value;
        if (empty($loc)) {
            $this->loc = new SourceLoc();
        } else {
            $this->loc = $loc;
        }
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
