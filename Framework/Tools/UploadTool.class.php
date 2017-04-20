<?php



class UploadTool
{
    private  $error;
    private $mime = [
        'image/jpeg'=>'jpeg',
        'image/png'=>'png',
        'image/gif'=>'gif'
    ];
    //专业处理文件上传方法，需要传入文件信息和文件保存目录
    public function uploadOne($files,$dir=''){
        /*
       * 文件上传判断
       */
        //判断文件是否为空
        if($files['size']==0){
            return '';
        }

        if($files['error'] != 0){
            $this->error = "文件上传失败！";
            return false;
        }
        //判断文件上传类型
        $allow_types = ['image/jpeg','image/png','image/gif'];
        if(!in_array($files['type'],$allow_types)){
            $this->error = "文件类型错误！";
            return false;
        }

        //判断上传文件大小
        $max_size = 2*1024*1024;
        if($files['size'] > $max_size){
            $this->error = "文件大小超过指定大小！";
            return false;
        }

        //判断是否是通过 http post 上传的文件
        if(!is_uploaded_file($files['tmp_name'])){
            $this->error = "文件不是通过浏览器上传！";
            return false;
        }
        //分目录存储
        //使用年月日来区分目录
        $dirname = UPLOADS_PATH.$dir.date("Ymd").'/';
        //创建文件夹
        if(!is_dir($dirname)){
            mkdir($dirname,0777,true);//true 迭代创建 如果文件不存在自动创建
        }
        $filename = $dirname.uniqid("IT_").strrchr($files['name'],'.');


        /**
         * 判断移动文件是否成功
         */
        if(move_uploaded_file($files['tmp_name'],$filename)){
           return str_replace(UPLOADS_PATH,'',$filename);//子字符串替换
        }else{
            $this->error = "移动文件失败！";
            return false;
        }
    }
    //专业制作缩略图的方法，需要传入:源图片路径,缩略的宽度，缩略的高度
    public function thumb($src_path,$max_width,$max_height){


        //创建画布

            $thumb_image = imagecreatetruecolor($max_width,$max_height);

        //获取源图片的宽高
            $src_path = UPLOADS_PATH.$src_path;
            if(!is_file($src_path)){
                $this->error = "原图不存在！";
                return false;
            }
            $src_imagesize = getimagesize($src_path);
            $mime = $src_imagesize['mime'];//获取图片类型
            list($src_width,$src_height) = $src_imagesize;

            //创建需要制作的图片资源

        $createFunc = 'imagecreatefrom'.$this->mime[$mime];
        $src_image = $createFunc($src_path);//可变方法

        //计算最大缩放比例
            $scale = max($src_width/$max_width,$src_height/$max_height);
        //计算缩放后的宽高
            $thumb_width = $src_width/$scale;
            $thumb_height = $src_height/$scale;
        //选择颜色
            $white = imagecolorallocate($thumb_image,255,255,255);
        //补白
            imagefill($thumb_image,0,0,$white);

        //拷贝图片
             imagecopyresampled($thumb_image,$src_image,($max_width-$thumb_width)/2,($max_height-$thumb_height)/2,0,0,$thumb_width,$thumb_height,$src_width,$src_height);
        //函数pathinfo得到路径信息 目录 全文件名  扩展 文件名
        $pathinfo = pathinfo($src_path);
        $filename = $pathinfo['dirname'].'/'.$pathinfo['filename']."_{$max_width}x{$max_height}.".$pathinfo['extension'];
        //可变获取图片的方法
        $outFunc = "image".$this->mime[$mime];
        $outFunc($thumb_image,$filename);
        //销毁画布
        imagedestroy($thumb_image);
        imagedestroy($src_image);
        //返回缩略图路径
        return str_replace(UPLOADS_PATH,'',$filename);
    }
    //获取错误信息方法
    public function getError(){
        return $this->error;
    }
    //上传多文件的方法,返回多文件路径组成的一个数组
    public function uploadMore($files,$path){
        //1、重构多文件信息
        $filepaths = [];
        foreach($files['error'] as $key=>$error){
            if($error==0){//过滤掉错误的文件
                $fileinfo = [];
                $fileinfo['name'] = $files['name'][$key];
                $fileinfo['type'] = $files['type'][$key];
                $fileinfo['tmp_name'] = $files['tmp_name'][$key];
                $fileinfo['error'] = $error;
                $fileinfo['size'] = $files['size'][$key];
                //一张一张上传
                $filepath = $this->uploadOne($fileinfo,$path);
                if($filepath===false){
                    //只要一个失败！就全部失败
                    return false;
                }else{
                    $filepaths[] = $filepath;
                }
            }
        }
        return $filepaths;
    }
}