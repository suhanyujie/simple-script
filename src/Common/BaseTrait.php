<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-23
 * Time: 09:22
 */

namespace SRC\Common;


trait BaseTrait
{
    protected $baseClassData = [];

    /**
     * @desc 魔术方法：从属性中读取数据
     */
    public function __get($key='')
    {
        if (empty($key)) return '';

        return $this->baseClassData[$key] ?? '';
    }

    /**
     * @desc 魔术方法：设置属性时，属性不存在，默认存入属性数组 $baseClassData 中
     */
    public function __set($key='', $val='')
    {
        $this->baseClassData[$key] = $val;
    }
}