<?php
$a = function (Closure $next)
{
    echo 'a';
    $next();
};

$b = function (Closure $next)
{
    echo 'b';
    $next();
};
$init = function () {
    echo 'init';
};
function callPack(Closure $closure, $targetF) {
    //�ѱ����ͺ�����װ��һ�𵱳�һ�����壬�������л���
    return function () use ($closure, $targetF) {$targetF($closure);};
};
$go1 = callPack($init, $a);
$go = callPack($go1, $b);
$go();