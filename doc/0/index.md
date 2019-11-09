## Token 分解
* 以一个文件为根，文件中有 PHP 标签、命名空间、引入命名空间、引入文件、类的声明...

## EBNF
* 编写基于 EBNF 的状态流转

```
prog::=INT_DECLEAR_EXPR
INT_DECLEAR_EXPR::=KEY_TYPE_INT IDENTIDY_FLAG FLAG_EQUAL NUM_EXPR
KEY_TYPE_INT::=int
IDENTIDY_FLAG::=[a-zA-Z_]\w+
FLAG_EQUAL::=\=
NUM_EXPR::=[0-9]+
```

* 通用赋值语句状态

```
prog::=ASSIGN_EXPR
ASSIGN_EXPR::=TYPE_FLAG IDENTIDY_FLAG FLAG_EQUAL EXPR_RIGHT
TYPE_FLAG::=(int|string|bool|list|map)
IDENTIDY_FLAG::=[a-zA-Z_][\w]+
FLAG_EQUAL::=[\=]
EXPR_RIGHT::=STRING_VALUE|INT_VALUE|BOOL_VALUE
STRING_VALUE::=[\w]
INT_VALUE::=[0-9]+
BOOL_VALUE::=(true|false)
```