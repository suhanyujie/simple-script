<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-23
 * Time: 09:14
 */

namespace SRC\Lexer;

use SRC\Common\BaseTrait;

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
    protected $ch;
    protected $offset;
    protected $line;
    protected $col;
    protected $isPeek;
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
            $nextIndex = $this->offset + 1;
            $c = $this->code[$nextIndex];
            if (!isset($c)) {
                $c = TokenType::EOF;
                array_push($ret, $c);
                break;
            }
            $this->offset = $nextIndex;
            if ($c === self::CR || $c === self::NL) {
                // 判断是否是换行符 \r\n
                if ($c === self::CR && $this->code[$nextIndex + 1] === self::NL) $this->offset++;
                if (!$this->isPeek) {
                    $this->line++;
                    $this->col = 0;
                }
            }

            $num--;
        }
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
}
