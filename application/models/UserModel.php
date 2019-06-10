<?php
class UserModel extends CI_Model
{
    //public $table_name = 'user';//给$table_name赋值，user表
    /*
        M：模型，提供数据，保存数据
        V：视图，只负责显示，表单form
        C：控制器，协调模型和视图
     */

    public function __construct()
    {
        parent::__construct ();
    }

    public function doRequest($url, $para)//模拟登录
    {
        do {
            if(extension_loaded('curl'))
            {
                $ch = curl_init();
                $cookiefile = realpath( 'singlecookie.txt');
                $options = array(
                    CURLOPT_URL     => $url,
                    CURLOPT_HEADER  => 1,
                    CURLOPT_POST    => 1,
                    CURLOPT_COOKIEFILE    =>  $cookiefile,
                    CURLOPT_COOKIEJAR     =>  $cookiefile,
                    CURLOPT_POSTFIELDS      => $para,
                    CURLOPT_SSL_VERIFYPEER  => 0,
                    CURLOPT_SSL_VERIFYHOST  => 0,
                    CURLOPT_SSLVERSION      => 1,
                    CURLOPT_CONNECTTIMEOUT  => 5,
                    CURLOPT_USERAGENT       => $_SERVER['HTTP_USER_AGENT'],
                    CURLOPT_REFERER         => "https://passport.fang.com/?backurl=http%3a%2f%2fmy.fang.com%"
                );

                curl_setopt_array($ch, $options);
                curl_exec($ch);
                $info = curl_getinfo($ch);
                curl_close($ch);
                if(json_last_error() === JSON_ERROR_NONE)
                {
                    $err =  array(
                        'status'    => 'success',
                        'results'   => $info,
                    );
                }
                else
                {
                    $err = array(
                        'status'    => 'failed',
                        'results'   => '返回值非JSON 类型',
                    );
                }
            }
            else
            {
                $err = array(
                    'status'    => 'failed',
                    'results'   => '请开启PHP Curl 拓展',
                );
            }
            return $err;
        } while(0);
    }

    public function simpleRequest($url0)
    {
        $ch = curl_init();
        $options = array(
            CURLOPT_URL     => $url0,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $options);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    public function mh($line, $html ,$res)//正则
    {
        preg_match_all($line, $html, $res);
        return $res;
    }

    public function write_db($res, $type)//插数据表
    {
        $x=0;
        $y=count($res[2]);
        while($x<$y)
        {
            $data = array(
                'term' => $res[2][$x],
                'website' => $res[1][$x],
                'type' => $type
            );
            $this->db->insert('fang', $data);
            $x=$x+1;
        }
        return 0;
    }

    public function get_all($limit,$offset)//获取数据
    {
        $query = $this->db->limit($limit,$offset)->get('fang');
        return $query->result_array();
    }
    public function allNums()//数据库行数
    {
        $result = $this->db->get('fang');
        return $result->num_rows();
    }



}
?>
