<?php

//验证码工具类
//Completely Automated Public Turing Test to Tell Computers and Humans Apart
//Captcha:全自动区分人和计算机的图灵测试
class CaptchaTool
{

    //生成验证码方法,传一个参数:码值长度
    public function makeImage($code_length){
        //生成码值
        //1、列取码值的可能区间
        $char_list = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//所有可能的值
        //2、打乱字符串
        $rand_code = str_shuffle($char_list);
        //3、截取字符串,获取码值，长度为$code_length，
        $code = substr($rand_code,0,$code_length);
        //4、将码值存入session
        @session_start();
       $_SESSION['captcha_code'] = $code;
        //生成带随机背景图的画布
        $bg_file = TOOLS_PATH.'captcha/captcha_bg'.mt_rand(1,5).'.jpg';
        $image = imagecreatefromjpeg($bg_file);
        //生成验证码
        //1、获取码值可能的颜色和字体
        if(mt_rand(1,2)==1){
            $code_color = imagecolorallocate($image,0,0,0);//黑色
        }else{
            $code_color = imagecolorallocate($image,255,255,255);//白色
        }
        $font = 5;//字体大小
        //2、获取画布的宽高
        $image_w = imagesx($image);
        $image_h = imagesy($image);
        //3、获取字体的宽高
        $font_w = imagefontwidth($font);
        $font_h = imagefontheight($font);
        //4、字符串宽高
        $code_w = $font_w * $code_length;
        $code_h = $font_h;
        //5、计算码值的位置X,Y
        $x = ($image_w - $code_w)/2;
        $y = ($image_h - $code_h)/2;
        //6、将码值写到画布上
        //函数imageString(画布,字体大小,位置的X,位置Y,内容,颜色)
        //该函数内置字体，只需要指定大小,1-5表示
        imagestring($image,$font,$x,$y,$code,$code_color);
        for($i=0;$i<100;$i++) {
            imagesetpixel($image, mt_rand(0, $image_w - 1), mt_rand(0, $image_h - 1),$code_color);
        }
//        for($i=0;$i<3;$i++) {
//            imageline($image, mt_rand(0, $image_w - 1), mt_rand(0, $image_h - 1),mt_rand(0, $image_w - 1), mt_rand(0, $image_h - 1),$code_color);
//        }
        //7、浏览器获得图像
        //imagepng($image,'./blue.png');
        //直接显示输出到浏览器的话 就省略第二个参数
        //同时告知浏览器，所发送的内容类型为图像类型
        header('Content-Type:image/jpeg');
        imagepng($image);
        //8、销毁画布
        imagedestroy($image);
    }
    public function checkCode($no_captcha){
        //完成验证码的校验
        @session_start();
        if(isset($_SESSION['captcha_code'])&&isset($no_captcha)&&strtoupper($no_captcha) == strtoupper($_SESSION['captcha_code'])){
            return 1;
        }else{
            return false;
        }
    }
}