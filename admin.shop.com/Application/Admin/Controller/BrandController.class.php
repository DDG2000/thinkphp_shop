<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/7
 * Time: 17:46
 */

namespace Admin\Controller;


class BrandController extends \Think\Controller
{
    //初始化自动完成，分派数据显示标题
    //自动实例化模型
    private $_model = null;

    protected function _initialize()
    {
        //标题数组
        $meta_title = array(
            'index' => '商品管理',
            'add' => '添加商品',
            'edit' => '编辑商品',
            'delete' => '删除商品',
        );
        //方法不在数组中，默认为商品管理
        $meta_title = isset($meta_title[ACTION_NAME]) ? $meta_title[ACTION_NAME] : '商品管理';
        $this->assign('meta_title', $meta_title);
        $this->_model = D('Brand');
    }

    public function index()
    {
        $keyword = I('get.keyword', '');
        $cond = array(
            'name' => array('like', '%' . $keyword . '%'),
        );
        $page = I('get.p', 1);
        $this->assign($this->_model->getPageResult($cond, $page));
        $this->assign('keyword', $keyword);

        $this->display();
    }
    //商品添加
    public function add()
    {
        if (IS_POST) {
            //收集数据验证数据是否合法
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
//            $logo=$this->_uploadLogo();
            //执行插入数据
            if ($this->_model->add() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('添加成功', U('index'));
        } else {
            $this->display();
        }
    }

    //商品的修改
    public function edit($id)
    {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
//            $logo=$this->_uploadLogo();
            //执行保存操作失败

            if ($this->_model->save() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('修改成功', U('index'));
        } else {
            //展示数据表中的数据
            $row = $this->_model->find($id);
//            dump($row);
            $this->assign('row', $row);
            $this->display('add');
        }
    }
    //执行商品的删除操作，将状态改为-1
    //或则执行修改操作，将状态在0/1之间转换
    public function delete($id, $status = -1)
    {
        if ($this->_model->changeStatus($id, $status) === false) {
            $this->error($this->_model->getError());
        } else {
            if ($status == -1) {
                $this->success('删除成功', U('index'));
            } else {
                $this->success('修改成功', U('index'));
            }
        }
    }
    //具体的文件上传，返回文件路径
    private function _uploadLogo(){
        //>>2.上传文件参数
        $config = C('UPLOAD_SETTING');

        //>>1.实例化文件上传类
        $upload = new \Think\Upload($config);
        //$_FILES数据提交后生成的文件信息，通过tep_name判断是否上传成功,不成功$file赋初值空数组
        $file = empty($_FILES['logo']['tmp_name']) ? array() : $_FILES['logo'];
        //判断$file 是否存在，存在则上传
        //给$logo赋初值
        $logo='';
        if ($file) {
            //文件上传，传递数组，传递一个文件uploadOne
            //判断文件上传是否成功，成功后获取拼接$logo值
            if($file_info = $upload->uploadOne($file)){
                //获取拼接$logo
                $logo=$file_info['savepath'].$file_info['savename'];
            }
        }
        return $logo;
    }
}