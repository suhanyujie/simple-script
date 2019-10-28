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
     * @desc 前看一个 token
     */
    public function peek()
    {
        $this->src->pushPos();
        $token = $this->next();
        $this->src->restorePos();

        return $token;
    }

    /**
     * @desc 获取下一个 token
     */
    public function next()
    {
        // 读取字符前，先跳过空白符
        $this->skipWhitespace();
        $ch = $this->src->read();
        switch ($ch) {
            case 'i':
                $tk = $this->src->peek(2);
                var_dump($tk);die;
                break;
            case 's':
                break;
            default:
                throw new \Exception("识别 token 失败！[{$ch}]", -1011);
        }

        return $token;
    }

    /**
     * @desc 忽略空白符，循环"预读"空白符，如果是空白符，则跳过
     */
    public function skipWhitespace()
    {
        while (true) {
            $ch = $this->src->peek();
            if ($ch === ' ' || $ch === "\t" || $ch === Source::EOL) {
                // 空白符时，只做消耗，可以不处理
                $this->src->read();
                continue;
            }
            break;
        }
    }
}
