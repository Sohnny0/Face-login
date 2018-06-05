<?php
namespace app\manage\controller;
use think\Controller;
use \think\Request;
use \think\View;

class Login {
    public function index(){
        return \view('face');
    }
    public function door_ajax(){
        /**
         * 这里设置登录验证，采集人脸超过十次以后，封锁这个IP，但只是在session上，关闭浏览器将失效
         */
        $login = session('login');
        if ($login==null){
            $login = array('num'=>0,'state'=>1);
            session('login',$login);
        }
        $login = session('login');
        if ($login['num']>10){
            return array('state'=>-1);
        }else{
            $login['num'] = $login['num'] + 1;
            session('login',$login);
        }
        $image_src = upload_image('the_file');
        $image1 = $image_src;
        $image2 = '';
        $state = 0;
        $scoure = 0;
        /** state = 0 表示没有识别到人脸，  1 表示无人脸  2表示通过 */

        if ($result['error_code']==0){
            $scoure = floor($result['result']['user_list'][0]['score']);
            if ($scoure>80){
                $state = 2;
                $user_id = $result['result']['user_list'][0]['user_id'];
            }else{
                $state = 1;
            }
        }
        $result = array('state'=>$state,'image1'=>$image1,'image2'=>$image2,'scoure'=>$scoure);
        return $result;
	}
}
