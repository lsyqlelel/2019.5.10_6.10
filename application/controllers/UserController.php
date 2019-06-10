<?php
class UserController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct ();//调用父类的构造函数
        $this->load->model ( 'UserModel' );
    }
    public function index()
    {
        $url0 = "https://passport.fang.com/login.api";//模拟登录
                $data = array(
                    'uid' => '13055720082',
                    'pwd' => '40b2d06e10221a142f1bd02ba1a417ecc726244a2715832a69af6c2464c650111483f1b72ca39542573066a33d883eefdc8f054980db22f98eb8f1933e0c40658d189156fa1ea517fad4d11bb9c7bd14d67ad342fe925afe5913f699b23a8d0e7e4d356e5dfdfac68f42103fb0223ace715ef695a0ca5f96023693ab9c92e64a',
                    'Service' => 'soufun-passport-web',
                    'AutoLogin' => '1',
                );
        $this->UserModel->doRequest($url0, $data);
        $url = "https://fz.fang.com/?s=BDPZ-BL";
        $data['html'] = $this->UserModel->simpleRequest($url);

        $line[0] = '#target="_self"\s+.*?href="(.*?)"\s>(.*?)<#';//城市导航
        $line[1] = '#s4Box.*?href="(.*?)".*?>(.*?)<#';//首页导航
        $line[2] = '#td.*?href="(.*?)"\starget="_blank">(.*?)<#';//相关链接
        $line[3] = '#em>\s*.*?\s*<.*?href=\'(.*?)\'\starget=\'_blank\'>(.*?)<#';//新房
        $line[4] = '#href=\'(.*?)\'.*?target=\'_blank\'.*?title="(.*?)">#';//资讯及问答
        $line[5] = '#em>.a\sclass="cmsA"\s*href=\'(.*?)\'\s*target=\'_blank\'>(.*?)..a>\s*<input\stype="hidden"#';//装修设计
        $line[6] = '#href=\'(.*?)\'\starget=\'_blank\'><span.*?span><.*?class=\'tit\'>(.*?)</sp#';//房产排行
        $line[7] = '#href="(.*?)"\stitle="(.*?)"\starget="_blank">#';//其他新闻
        $type[0] = "城市导航";
        $type[1] = "首页导航";
        $type[2] = "相关链接";
        $type[3] = "新房";
        $type[4] = "资讯及问答";
        $type[5] = "装修设计";
        $type[6] = "房产排行";
        $type[7] = "其他新闻";

        for($r = 0 ;$r < 8;$r++ )             //正则匹配及写入数据库
        {
            $res = array();
            $res = $this->UserModel->mh( $line[$r], $data['html'], $res);//可以
            $a = count($res[2]);$x=0;
            while($x<$a)
            {
                $res[2][$x]=mb_convert_encoding($res[2][$x], 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');//解决php使用curl获取文本出现中文乱码
                $x++;
            }
            $this->UserModel->write_db($res, $type[$r]);
        }


        //----------------分页显示


        $this->load->library('pagination');//加载分页库
        $this->load->helper('url');

        $this->load->model('UserModel');
        $count = $this->UserModel->allNums();
        $config['base_url'] = site_url('UserController/index');
        $config['total_rows'] = $count;
        $config['per_page'] = '20';
        $config['first_link'] = '首页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '末页';
        $config['uri_segment'] = 3;//必须与$this->uri->segment(3)保持一致

        $this->pagination->initialize($config);

        $offset = intval($this->uri->segment(3));

        $data['fang'] = $this->UserModel->get_all($config['per_page'],$offset);

        $data['link'] = $this->pagination->create_links();
        $this->load->view('curl_view',$data);



    }

}
