<?php
/**
 * Created by PhpStorm.
 * User: mangle
 * Date: 16/5/15
 * Time: 01:24
 */

//namespace slim\src;


use Slim\Container;

class Model
{
    protected $table = "";

    protected $container_db;

    protected $db;

    protected $field;


    /**
     * Model constructor.
     * @param Container $container
     */
    public function __construct($container_db ,$table)
    {
            $this->container_db = $container_db;

             $this->table = $table;
            $this->initDB();
            return $this;

    }

    /**
     * initDB
     */
    public function initDB()
    {

       $dbSetting = $this->container_db;
       $dsn = $dbSetting['dsn'];
       $dbUser = $dbSetting['user'];
       $dbPasswd = $dbSetting['passwd'];
       $dbOptions = isset($dbSetting['options']) ? $dbSetting['options'] : [];

       try{
           $db = new \PDO($dsn,$dbUser,$dbPasswd,$dbOptions);
           $this->db = $db;
          }catch(\Exception $e){
           echo $e->getMessage();
           exit;
          }
    }

    public function sql($sql)
    {
        $this->db->exec($sql);
    }

    public function select($row ,$value ,$field = [] ,$limit = 10)
    {
        if(empty($field))
        {
            $this->field = '*';
        }else{
            foreach($this->field as $v)
            {
                $this->field .= $v.',';
            }
            rtrim(',',$this->field);
        }
        $rs = $this->db->query('SELECT ' . $this->field . ' FROM ' . $this->table .' WHERE ' . $row . ' = '.$value . ' LIMIT 0,' . $limit);
        $rs->setFetchMode(\PDO::FETCH_ASSOC);
        return $rs->fetchAll();
    }

}