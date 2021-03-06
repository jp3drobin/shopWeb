<?php
   require_once 'string.func.php';
        /**
         *  通过GD库创建验证码
         *  $width: 验证码图片宽度
         *  $height: 验证码图片高度
         *  $type:   产生字符类型，1为数字，2为数字和小写字母，3为数字小写字母加大写字母
         *  $length: 验证码字符个数
         *  $pixel: 干扰点数量
         *  $line: 干扰线数量
         *  $sess_name: session key
         */
function verifyImage($type = 1, $length = 4, $pixel = 0, $line = 0, $sess_name = "verify")
{
   
    //创建画布
    $width = 80;
    $height = 20;
        // 创建画布
        // 创建真色彩画布
        $image = imagecreatetruecolor($width, $height);
        // 画笔颜色
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        //用填充矩形填充画布
        imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);
        // 产生随机字符串
        $chars = buidRandomString($type, $length);
        // echo $chars."<br>";
        //存储到session
        $_SESSION[$sess_name] = $chars;
        // 字体数组
        $fontfiles = array(
        "SIMLI.TTF","STZHONGS.TTF","SIMYOU.TTF");
        // 随机获取数组中任意一个值
        $fontfile = "../fonts/".$fontfiles[mt_rand(0, count($fontfiles)-1)];
           /* 将TTF (TrueType Fonts) 字型文字写入图片*/
 
        for ($i=0; $i < $length; $i++) {
            //产生14 ~ 18的随机数用于字体大小
            $size = mt_rand(14, 18);
            //产生随机数用于字符角度
            $angle = mt_rand(-15, 15);
            //产生字符位置坐标
            $x = 5 + $i * $size;
            $y = mt_rand(15, 20);
 
            // 产生随机画笔颜色，用于设置字体颜色
            $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
            $text = substr($chars, $i, 1);
 
            imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
             
        }
        // 绘制点、线等干扰元素
 
        if ($pixel) {
            for ($i=0; $i < $pixel; $i++) {
                imagesetpixel($image, mt_rand(0, $width-1), mt_rand(0, $height-1), $black);
            }
        }
 
        if ($line) {
            for ($i=0; $i < $line; $i++) {
            $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
                imageline($image, mt_rand(0, $width-1), mt_rand(0, $height-1), mt_rand(0, $width-1), mt_rand(0, $height-1), $color);
            }
        }
 
        // 输出图片格式
        header("content-type:image/gif");
        // 生成图片
        imagegif($image);
        // 释放资源
        imagedestroy($image);
 
    }
 
     //   verifyImage(2, 4, 10, 3);


/**
 * 生成缩略图
 * @param string $filename
 * @param string $destination
 * @param int $dst_w
 * @param int $dst_h
 * @param bool $isReservedSource
 * @param number $scale
 * @return string
 */
function thumb($filename,$destination=null,$scale=0.5,$dst_w=null,$dst_h=null,$isReservedSource=false){
//    $filename="des_big.jpg";
    list($src_w,$src_h,$imagetype)=getimagesize($filename);
    $mime=image_type_to_mime_type($imagetype);
//    echo $mime;

    if(is_null($dst_w)||is_null($dst_h)){
        $dst_w=ceil($src_w*$scale);
        $dst_h=ceil($src_h*$scale);
    }

    $createFun=str_replace("/","createfrom",$mime);
    $outFun=str_replace("/",null,$mime);
    $src_image=$createFun($filename);
    //创建画布大小
    $dst_image=imagecreatetruecolor($dst_w,$dst_h);
    //设置缩放
    imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
    //判断路径是否存在，若不存在就创建
    if($destination&&!file_exists(dirname($destination))){
        mkdir(dirname($destination),0777,true);
    }
    //输出图片
    $dstFilename=$destination==null?getUniName().".".getExt($filename):$destination;
    $outFun($dst_image,$dstFilename);
    imagedestroy($src_image);
    imagedestroy($dst_image);
    //是否删掉源文件，默认为不删掉
//    $isReservedSource=false;
    if(!$isReservedSource){
        unlink($filename);
    }
}


