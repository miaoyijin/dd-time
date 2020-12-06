<?php
/**
 * Created by PhpStorm.
 * User: mouyj
 * Date: 2020/7/26
 * Time: 19:19
 */
//2.0 swoole �汾������HTTP������
$http = new Swoole\Http\Server("127.0.0.1", 9501);

$http->set([
    'worker_num'      => 1,
]);
$http->on("start", function ($server) {
    swoole_set_process_name("swoole master");
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on('WorkerStart', function ($server, $worker_id){
    swoole_set_process_name("swoole worker");
});
$http->on('managerStart', function ($server){
    swoole_set_process_name("swoole manager");
});

$http->on("request", function ($request, $response) {
    //����ͬʱ������http����

    //sleep(10);sleep��������ִ�е��߳������ó�cpu����cpuȥִ�������̣߳�swoole ����һ���̡߳���
    //��sleepָ����ʱ�����cpu�Ż�ص�����߳��ϼ�������ִ��
    file_put_contents('log.txt', date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
    mysqldeal($response);
});

$http->start();

function mysqldeal($response)
{
    $db = new swoole_mysql();
    $server = array(
        'host' => 'proverb-mysql-g1-master001.a.2345inc.com',
        'port' => 3306,
        'user' => 'proverb',
        'password' => 'ko5OsiTec2q6',
        'database' => 'proverb_dm',
        'charset' => 'utf8', //ָ���ַ���
        'timeout' => 32,  // ��ѡ�����ӳ�ʱʱ�䣨�ǲ�ѯ��ʱʱ�䣩��Ĭ��ΪSW_MYSQL_CONNECT_TIMEOUT��1.0��
    );

    $db->connect($server, function ($db, $r) use ($response) {
        if ($r === false) {
            echo 1111;
            var_export($db->connect_errno, $db->connect_error);
        }
        $sql = 'select sleep(10)';
        $db->query($sql, function(swoole_mysql $db, $r) use ($response) {
            if ($r === false)
            {
                echo 2222;
                var_export($db->error, $db->errno);
            }
            elseif ($r === true )
            {
                echo 3333;
                var_export($db->affected_rows, $db->insert_id);
            }
            echo 4444;
            var_export($r);
            $db->close();
            $response->end();
        });
    });
}