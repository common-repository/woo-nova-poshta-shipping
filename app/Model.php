<?php

namespace WooNovaPoshtaShipping\App;

class BaseModel{
    
    private $db;

    public function __construct(){
        global $wpdb;
        $this->db = $wpdb;
    }

    /**
     * Method for getting data from DB
     *
     * @param [type] $data
     * @return void
     */
    public function get_data($data, $from, $conditions = null){
        $sql = "SELECT $data FROM $from";

        if(!empty($conditions)){
            $sql .= $conditions;
        }        

        $result = $this->db->get_row($sql, ARRAY_A);

        return $result;
    }

    /**
     * Inserting data
     *
     * @param [type] $table
     * @param array $data
     * @param array $format
     * @return void
     */
    public function insert_data($table, $data = array(), $format = array()){
        $this->db->insert($table, $data, $format);
    }

    /**
     * Updating data
     *
     * @param [string] $table
     * @param array $data
     * @param array $where
     * @param array $format
     * @return void
     */
    public function update_data($table, $data = array(), $where = array() ,$format = array()){
        $this->db->update($table, $data, $where, $format);
    }

}