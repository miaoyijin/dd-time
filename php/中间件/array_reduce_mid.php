<?php

// ����һ���ӿ�
interface Middleware
{
    public function handle(Closure $next);
}

// ʵ��һ����־�м��
class LogMiddleware implements Middleware
{
    public function handle(Closure $next)
    {
        echo "log1" . '<br/>' . PHP_EOL;
        $next();
        echo "log2" . '<br/>' . PHP_EOL;
    }
}

// ʵ��һ����֤�м��
class ApiMiddleware implements Middleware
{
    public function handle(Closure $next)
    {
        echo "token" . '<br/>' . PHP_EOL;
        $next();
    }
}

// ִ�е��ú���
function carry($closures, $middleware)
{
    return function () use ($closures, $middleware) {
        $middleware->handle($closures);
    };
}

// ִ�е���
function then()
{
    $middlewares = [new LogMiddleware(), new ApiMiddleware()];
    // Controller�д���ĵ�ҵ���߼�
    $prepare = function () {
        echo 'start' . '<br/>' . PHP_EOL;
    };
    // mixed array_reduce( array $array, callable $callback[, mixed $initial = NULL] )
    // array_reduce() ���ص����� callback ���������õ� array �����е�ÿһ����Ԫ�У��Ӷ��������Ϊ��һ��ֵ��

    // array array_reverse( array $array[, bool $preserve_keys = false] )
    // array_reverse �� ���ص�Ԫ˳���෴������
    $go = array_reduce(array_reverse($middlewares), 'carry', $prepare);
    $go();

}

then();
?>
