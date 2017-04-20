<?php


class CaptchaController extends Controller
{
    public function index(){
        $string = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";//创建随机数
        $string = str_shuffle($string);//打乱随机数
        $random_code = substr($string,0,4);//截取随机数前4位数

        @session_start();//开启session保存随机数
        $_SESSION['random_code'] = $random_code;

        $image_path = PUBLIC_PATH."Admin/captcha/captcha_bg".mt_rand(1,5).".jpg";//读取图片路径拼接随机1到5的背景图
        $image_info = getimagesize($image_path);//获取图片大小
        list($width,$height) = $image_info;//取出图片宽高
        $image = imagecreatefromjpeg($image_path);//创建画布
        $white = imagecolorallocate($image,255,255,255);//创建白色
        imagerectangle($image,0,0,$width-1,$height-1,$white);//创建白色边框
        $black = imagecolorallocate($image,0,0,0);//创建黑色
        imagestring($image,5,$width/3,$height/6,$random_code,mt_rand(0,1)?$white:$black);//创建基本居中的随机白色和黑色的随机字体随机背景

        header("Content-Type:image/jpeg;charset=utf-8");//声明输出数据和字符串的类型
        imagejpeg($image);//输出图片
        imagedestroy($image);//销毁图片
    }
}