<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 2019-10-22
 * Time: 09:08
 */

namespace SRC\Lexer;

use PHPUnit\Framework\Constraint\IsFalse;

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
     * @desc 前看一个 token、一段字符
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
        switch ($ch) {
            case 'i':
                $flag = $this->src->peek(3);
                if ($flag === 'int') {
                    return $this->readInt();
                }
                break;
            case 's':
                $flag = $this->src->peek(6);
                if ($flag === 'string') {
                    return $this->readStringAssign();
                }
                break;
            case 'p':
                $flag = $this->src->peek(5);
                if ($flag === 'print') {
                    $stmt = $this->readPrint();
                    return $stmt;
                }
            case TokenType::EOF:
                return TokenType::EOF;
            default:
                throw new \Exception("识别 token 失败！[{$ch}]", -1011);
        }
    }


    /**
     * @desc print 语句
     *  - 支持打印字符串
     */
    public function readPrint()
    {
        $token = new Token();
        $token->type = TokenType::PRINT_STMT;
        $token->loc->start = $this->getPos();
        // 消耗关键词
        $this->src->read(strlen($token->type));
        $this->skipWhitespace();
        // 前看1个字符
        $ch = $this->src->peek(1);
        $value = '';
        // 打印字符串
        if (in_array($ch, ['"', '\''])) {
            $this->src->read(1);
            $delimiter = $ch;
            while (true) {
                $ch = $this->src->read();
                if ($ch === $delimiter) {
                    break;
                } elseif ($ch === Source::EOF) {
                    throw new \Exception("识别 print 语句失败", -1);
                } else {
                    $value .= $ch;
                }
            }
        } elseif ($ch == '$') {
            // todo
        }
        if ($this->src->peek(1) == ';') {
            $this->src->read(1);
        }
        $token->value = $value;
        $token->loc->end = $this->getPos();

        return $token;
    }

    /**
     * @desc int 赋值语句
     *  - 变量声明/赋值
     */
    public function readInt()
    {
        $flag = $this->src->peek(3);
        if ($flag !== 'int') $this->makeException();
        $token = new Token();
        $token->type = TokenType::ASSIGN_INT;
        $token->loc->start = $this->getPos();
        // 消耗类型名
        $this->src->read(3);
        $this->skipWhitespace();
        // 消耗标识符
        $token->identifier = $this->readIdentity();
        $this->skipWhitespace();
        if ($this->src->peek(1) == TokenType::ASSIGN_OP) {
            // 消耗掉赋值操作符 `=`
            $this->src->read(1);
            $token->value = $this->readAddExpr();
        }

        return $token;
    }

    /**
     * @desc 读取加法算术表达式
     */
    public function readAddExpr()
    {
        $this->skipWhitespace();
        $token = new Token();
        $token->type = TokenType::ADD_EXPR;
        $token->loc->start = $this->getPos();

    }

    /**
     * @desc 读取表达式
     */
    public function readExpr()
    {

    }

    // 读取 string 类型的赋值语句
    public function readStringAssign()
    {
        $token = new Token();
        // 赋值语句包含 类型名、标识符、值
        $token->type = TokenType::ASSIGN_STRING;
        $token->loc->start = $this->getPos();
        // 1.读取类型名
        // 2.读取标识符
        // 3.读取表达式值
        $token->typeOfAssign = $this->src->read(6);// string
        $this->skipWhitespace();
        // 读取消耗标识符
        $token->identifier = $this->readIdentity();
        $this->skipWhitespace();
        $this->readAssignOp();// =
        $this->skipWhitespace();
        $token->value = $this->readString();
        $this->skipSemi();

        return $token;
    }

    /**
     * @desc 读取接下来的字符串并返回 token 信息
     * - 读取类型名
     * - 读取标识符
     * - 读取字符串值
     */
    public function readString()
    {
        // 定义一个 token 对象
        // 获取该 token 的位置对象
        // 获取 token 对应的值
        $token = new Token(TokenType::STRING, null, new SourceLoc);
        $token->loc->start = $this->getPos();
        // 消耗掉 第一个 字符串定界符
        $this->src->read(1);
        $value = [];
        while (true) {
            $tmpCh = $this->src->read();
            if (in_array($tmpCh, ["'", '"'])) {
                break;
            } elseif ($tmpCh === Source::EOF) {
                throw $this->makeException();
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
        $token = new Token(TokenType::IDENTITY, null, new SourceLoc);
        $token->loc->start = $this->getPos();
        $value = [];
        while (true) {
            $ch = $this->src->read();
            if ($ch === ' ' || preg_match('@[^\w]@', $ch)) {
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
     * @desc 跳过语句后的分号
     */
    public function skipSemi()
    {
        if ($this->src->peek(1) == ';') {
            $this->src->read(1);
        }
    }

    /**
     * @desc 读取赋值运算符
     */
    public function readAssignOp()
    {
        $token = new Token(TokenType::ASSIGN_OP, null, new SourceLoc);
        $token->loc->start = $this->getPos();
        $value = [];
        while (true) {
            $ch = $this->src->read();
            if ($ch === ' ' || preg_match('@[^\w]@', $ch)) {
                break;
            }
            array_push($value, $ch);
        }
        $token->value = implode('', $value);
        $token->loc->end = $this->getPos();

        return $token;
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
    public function makeException()
    {
        return new \Exception("Unexpected error in line:{$this->src->line} column:{$this->src->col}!");
    }
}
