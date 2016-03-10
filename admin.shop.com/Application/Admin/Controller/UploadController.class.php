<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/10
 * Time: 16:19
 */

namespace Admin\Controller;


class UploadController extends \Think\Controller
{
    public function index(){
//        var_dump($_FILES);
        //>>2.上传文件参数
        $config = C('UPLOAD_SETTING');

        //>>1.实例化文件上传类
        $upload = new \Think\Upload($config);
        //$_FILES数据提交后生成的文件信息，通过tep_name判断是否上传成功,不成功$file赋初值空数组
        $file = empty($_FILES['logo']['tmp_name']) ? array() : $_FILES['logo'];
        //判断$file 是否存在，存在则上传
        //给$logo赋初值
        $logo=$msg='';
        if ($file) {
            //文件上传，传递数组，传递一个文件uploadOne
            //判断文件上传是否成功，成功后获取拼接$logo值
            if($file_info = $upload->uploadOne($file)){
                //获取拼接$logo
                $logo=$file_info['savepath'].$file_info['savename'];
                $flag=1;   //上传成功
            }else{
                $msg=$upload->getError();
                $flag=0;    //上传失败
            }
        }
        $data=array(
          'file_url'=>$logo,
            'msg'=>$msg,
            'status'=>$flag,
        );
//        echo json_encode($data);
        $this->ajaxReturn($data);

    }
}