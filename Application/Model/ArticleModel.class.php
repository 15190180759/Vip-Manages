<?php

/**
 * Class ArticleModel
 * 活动管理模型
 */
class ArticleModel extends Model
{
    /**
     * @param $data 用户输入的活动相关信息
     */
    public function add($data){
        //验证数据（省略）
        //加入数据
         //准备发布时间
            $data['time'] = time();
         //将活动内容转义
            $data['content'] = htmlspecialchars($data['content']);
         //通过基础类方法操作加入数据
            parent::insertData($data);
    }
    public function edit($data){
        //验证数据(省略)
        //修改数据
            //转义
            $data['content'] = htmlspecialchars($data['content']);
        parent::updateData($data);
    }
    public function getRandom(){
        $sql = "select * from article where end > now() limit 1";
        return $this->db->fetchRow($sql);
    }
}