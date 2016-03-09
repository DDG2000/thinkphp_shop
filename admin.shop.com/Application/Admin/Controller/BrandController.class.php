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

    public function add()
    {
        if (IS_POST) {
            //收集数据验证数据是否合法
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
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

            $config = array(
                'mimes' => array('image/jpeg','image/png','image/gif'), //允许上传的文件MiMe类型
                'maxSize' => 1024*1024, //上传的文件大小限制 (0-不做限制)
                'exts' => array('jpg','jpeg','gif','png'), //允许上传的文件后缀
                'autoSub' => true, //自动子目录保存文件
                'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                'rootPath' => './Uploads/', //保存根路径
                'savePath' => '', //保存路径
                'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                'saveExt' => '', //文件保存后缀，空则使用原后缀
                'replace' => false, //存在同名是否覆盖
                'hash' => true, //是否生成hash编码
                'callback' => false, //检测文件是否存在回调，如果存在返回文件信息数组
                'driver' => '', // 文件上传驱动
                'driverConfig' => array(), // 上传驱动配置
            );
            $upload = new \Think\Upload($config);
            $file=empty($_FILES['logo']['tmp_name'])?array():$_FILES['logo'];
            var_dump($file);
            $file_info=$upload->uploadOne($file);
            var_dump($file_info);
            //执行保存操作失败
            exit;
            if ($this->_model->save() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('修改成功', U('index'));
        } else {
            //展示数据表中的数据
            $row = $this->_model->find($id);
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
}