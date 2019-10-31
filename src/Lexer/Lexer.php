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
        $ch = $this->src->peek();
        echo $ch."\n";
        switch ($ch) {
            case 'i':
                $flag = $this->src->peek(3);
                if ($flag === 'int') {
                    return this.readInt();
                }
                break;
            case 's':
                $flag = $this->src->peek(6);
                if ($flag === 'string') {
                    // 读取类型
                    // 读取标识符
                    // 读取表达式值
                    $tk = $this->readIdentity();
                    return $this->readString();
                }
                break;
            default:
                throw new \Exception("识别 token 失败！[{$ch}]", -1011);
        }
    }

    /**
     * @desc 读取接下来的字符串并返回 token 信息
     */
    public function readString()
    {
        // 定义一个 token 对象
        // 获取该 token 的位置对象
        // 获取 token 对应的值
        $token = new Token(TokenType::STRING);
        $token->loc->start = $this->getPos();
        $this->src->read();
        $value = [];
        while (true) {
            $tmpCh = $this->src->read();
            if (in_array($tmpCh, ["'", '"'])) {
                break;
            } elseif ($tmpCh === Source::EOF) {
                throw $this->makeExcepton();
            }
            array_push($value, $tmpCh);
        }
        $token->loc->end = $this->getPos();
        $token->value = implode('', $value);

        return $token;
    }

    /**
     * @desc 读取标识符
     */
    public function readIdentity()
    {
        $token = new Token(TokenType::IDENTITY);
        $token->loc->start = $this->getPos();
        $value = [];
        while (true) {
            $ch = $this->src->read();
            if ($ch === ' ') {
                break;
            }
            array_push($value, $ch);
        }
        $token->value = implode('', $value);
        $token->loc->end = $this->getPos();

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

    /**
     * @desc 获取当前文本源码位置
     */
    public function getPos()
    {
        return $this->src->getPos();
    }

    /**
     * @desc 通用异常
     */
    public function makeExcepton()
    {
        return new \Exception("Unexpected error in line:{$this->src
        ->line} column:{$this->src->col}!");
    }
}
