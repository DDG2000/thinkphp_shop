<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of GoodsGalleryController
 *
 * @author qingf
 */
class GoodsGalleryController extends \Think\Controller{
    /**
     * 删除相册图片
     * @param type $id
     */
    public function delete($id){
        if(M('GoodsGallery')->delete($id)===false){
            $this->error('删除失败');
        }else{
            $this->success('删除成功');
        }
    }
}
