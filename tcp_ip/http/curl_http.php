<?php
/**
 * tcpճ������,���Խ���ͻ��˿�����ȷ�������ݡ������Ҳ���Դ���ճ����
 * Created by PhpStorm.
 * User: mouyj
 * Date: 2020/12/8
 * Time: 19:37
 */
error_reporting(E_ALL);
ini_set('display_errors', 'on');
function HTTP_Post($URL,$data, $referrer="") {

    $result = $request = '';
    // parsing the given URL
    $URL_Info=parse_url($URL);
    $URL_Info["port"]=80;
    // building POST-request:
    $request.="GET ".$URL_Info["path"]." HTTP/1.1\r\n";
    $request.="Host: ".$URL_Info["host"]."\r\n";
    $request.="Content-type: application/x-www-form-urlencoded\r\n";
    $request.="Connection: keep-alive\r\n";
    $request.="\r\n\r\n";
    $request.="GET ".$URL_Info["path"]." HTTP/1.1\r\n";
    $request.="Host: ".$URL_Info["host"]."\r\n";
    $request.="Content-type: application/x-www-form-urlencoded\r\n";
    $request.="Connection: close\r\n";
    $request.="\r\n\r\n";
    $fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
    fputs($fp, $request);
    fputs($fp, $request);
    $except=null;
    //���峬ʱʱ��
    $time_out=null;
    //socket_select($r = [$fp],$r = [],$except, $time_out);
    while ($c = fgets($fp, 1024)) {//�˴�Ӧ�����socket_select
        echo time() . PHP_EOL;//Ϊʲô������ӦΪfeof,���ʺ��ж�tcp���������Ի�һֱ����ֱ����ʱ�ŷ��ؽ�����ݣ�fgets Ҳ��������,ֻ��Ϊ�����Connection: keep-alive������ĳ�close���Ѹ�ٻ�����ݲ�����
        $result .= $c;
    }
    fclose($fp);
    return $result;
}

$output1=HTTP_Post("http://www.2345.com/404/404.html",$_POST);

echo $output1;
?>