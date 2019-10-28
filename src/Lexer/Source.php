<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-23
 * Time: 09:14
 */

namespace SRC\Lexer;

use SRC\Common\BaseTrait;
use SRC\Lexer\Position;

/**
 * 源码读取器
 * Class Source
 * @package SRC\Lexer
 */
class Source
{
    use BaseTrait;

    const NL = "\n",
        CR = "\r",
        EOL = "\n",
        EOF = "\x03";

    protected $code;
    protected $file;
    /**
     * @var string 当前的字符的值
     */
    protected $ch;
    /**
     * @var int 当前字符的偏移量
     */
    protected $offset;
    /**
     * @var int 当前字符所在的行
     */
    protected $line;
    /**
     * @var int 当前字符所在的列
     */
    protected $col;
    /**
     * @var bool 标识当前读取字符是否是处于 peek 模式
     */
    protected $isPeek;
    /**
     * @var array peek 模式时的存储位置信息数组
     */
    protected $posStack;

    /**
     * @desc 构造函数
     */
    public function __construct($code='', $file=STDIN)
    {
        $this->code     = $code;
        $this->file     = $file;
        $this->ch       = "";
        $this->offset   = -1;
        $this->line     = 1;
        $this->col      = 0;
        $this->isPeek   = false;
        $this->posStack = [];
    }

    /**
     * @desc 按字符读取源码
     */
    public function read($num=1)
    {
        $ret = [];
        while ($num) {
            $offset = $this->offset;
            $nextIndex = $offset + 1;
            $c = $this->code[$nextIndex] ?? null;
            echo $c."\n";
            if (!isset($c)) {
                $c = TokenType::EOF;
                array_push($ret, $c);
                break;
            }
            $offset = $nextIndex;
            // 如果是换行符，并且非 peek 模式，则 line++
            // 如果不是换行符，且非 peek，则 col++
            if ($c === self::CR || $c === self::NL) {
                // 判断是否是换行符 \r\n
                if ($c === self::CR && $this->code[$nextIndex + 1] === self::NL) $offset++;
                if (!$this->isPeek) {
                    $this->line++;
                    $this->col = 0;
                }
                $c = self::EOL;
            } elseif(!$this->isPeek) {
                $this->col++;
            }
            array_push($ret, $c);
            $num--;
        }
        if (!$this->isPeek) {
            $this->ch = $c;
            $this->offset = $offset;
        }
        $retString = implode('', $ret);

        return $retString;
    }

    /**
     * @desc 预读一个 token 前看一个 token
     */
    public function peek($num=1)
    {
        $this->isPeek = true;
        $token = $this->read($num);
        $this->isPeek = false;

        return $token;
    }

    /**
     * @desc 当前字符位置
     */
    public function getPos()
    {
        return new Position($this->offset, $this->line, $this->col);
    }

    /**
     * @desc 暂存位置
     */
    public function pushPos()
    {
        array_push($this->stashPos(), $this->getPos());
    }

    /**
     * @desc 将暂存的位置进行恢复 状态恢复
     */
    public function restorePos()
    {
        /**
         * @var Position
         */
        $pos = array_pop($this->posStack);
        if (!isset($pos)) {
            throw new \Exception("unknow stash posi in stashPos array!", -1001);
        }
        $this->offset = $pos->offset;
        $this->line   = $pos->line;
        $this->col    = $pos->col;
    }
}
