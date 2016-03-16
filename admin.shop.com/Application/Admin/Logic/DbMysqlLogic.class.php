<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/11
 * Time: 22:44
 */

namespace Admin\Logic;


class DbMysqlLogic implements DbMysql{
    /**
     * DB connect
     *
     * @access public
     *
     * @return resource connection link
     */
    public function connect()
    {
        echo __METHOD__.'<br />';
        // TODO: Implement connect() method.
    }

    /**
     * Disconnect from DB
     *
     * @access public
     *
     * @return viod
     */
    public function disconnect()
    {
        echo __METHOD__.'<br />';
        // TODO: Implement disconnect() method.
    }

    /**
     * Free result
     *
     * @access public
     * @param resource $result query resourse
     *
     * @return viod
     */
    public function free($result)
    {
        echo __METHOD__.'<br />';
        // TODO: Implement free() method.
    }

    /**
     * Execute simple query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return resource|bool query result
     */
    public function query($sql, array $args = array())
    {
        $sqls=preg_split('/\?[FTN]/',$sql);   //打断$sqls
        array_pop($sqls);         //移除最后一个元素
        $sql='';
        $args=func_get_args();
        array_shift($args);        //移除第一个元素
        foreach($sqls as $key=>$value){
            $sql.=$value.$args[$key];
        }
//        echo $sql;
        return M()->execute($sql);  //执行一条sql语句
        // TODO: Implement query() method.
    }

    /**
     * Insert query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false last insert id
     */
    public function insert($sql, array $args = array())
    {
        $params = func_get_args();
        $sql = $params[0];
        $table_name = $params[1];
        $args = $params[2];
        $sql = str_replace('?T', '`'.$table_name .'`', $sql);
        $sql_tmp = array();
        foreach($args as $key=>$value){
            $sql_tmp[] = "`$key`='$value'";
        }
        $sql_tmp = implode(',', $sql_tmp);
        $sql = str_replace('?%', $sql_tmp, $sql);
//        echo $sql . '<br />';
//        exit;
        return M()->execute($sql);

        // TODO: Implement insert() method.
    }

    /**
     * Update query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false affected rows
     */
    public function update($sql, array $args = array())
    {
        echo __METHOD__.'<br />';
        // TODO: Implement update() method.
    }

    /**
     * Get all query result rows as associated array
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAll($sql, array $args = array())
    {
        echo __METHOD__.'<br />';
        // TODO: Implement getAll() method.
    }

    /**
     * Get all query result rows as associated array with first field as row key
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAssoc($sql, array $args = array())
    {
        echo __METHOD__.'<br />';
        // TODO: Implement getAssoc() method.
    }

    /**
     * Get only first row from query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array
     */
    public function getRow($sql, array $args = array())
    {
        $sqls=preg_split('/\?[FTN]/',$sql);   //打断$sqls
        array_pop($sqls);         //移除最后一个元素
        $sql='';
        $args=func_get_args();
        array_shift($args);        //移除第一个元素
        foreach($sqls as $key=>$value){
            $sql.=$value.$args[$key];
        }                          //将两个数组组合连接
        $rows= M()->query($sql);   //查询
        return $rows[0];           //返回数组

        // TODO: Implement getRow() method.
    }

    /**
     * Get first column of query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array one level data array
     */
    public function getCol($sql, array $args = array())
    {
        echo __METHOD__.'<br />';
        // TODO: Implement getCol() method.
    }

    /**
     * Get one first field value from query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return string field value
     */
    public function getOne($sql, array $args = array())
    {
        echo __METHOD__.'<br />';
        // TODO: Implement getOne() method.
    }
}