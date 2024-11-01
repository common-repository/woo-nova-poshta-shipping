<?php

namespace WooNovaPoshtaShipping\App\DB;

final class WNPS_DB{

    private static $instance = null;    

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new static();
            return self::$instance;
        }
        else{
            return self::$instance;
        }
    }

    private function __construct(){/**...*/}
    private function __clone(){/**...*/}
    private function __wakeup(){/**...*/}


    /**
     * Create table
     *
     * @param [string] $table_name
     * @param [string] $sql_table_params
     * @param [string] $sql_table_conditions
     * @return void
     */
    public function create_table($table_name = "", $sql_table_params = "", $sql_table_conditions = ""){
        global $wpdb;

        $cahrset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

        $table_prefix = $wpdb->prefix;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sql = "
            CREATE TABLE $sql_table_conditions $table_prefix"."$table_name (
                $sql_table_params
            ) {$cahrset_collate};
        ";

        dbDelta($sql);
        
        return self::$instance;
    }

    /**
     * Drop table
     *
     * @param [string] $table_name
     * @return void
     */
    public static function drop_table($table_name = ""){
        global $wpdb;

        $_table_name = $wpdb->prefix . $table_name;

        $wpdb->query("DROP TABLE IF EXISTS $_table_name");

        return self::$instance;
    }

    /**
     * Clear table
     *
     * @param [string] $table_name
     * @return void
     */
    public function clear_table($table_name = ""){
        global $wpdb;

        $_table_name = $wpdb->prefix . $table_name;
        $sql = "DELETE FROM $_table_name";
        
        $wpdb->query($sql);
    }

     /**
      * Method for getting data from DB
      *
      * @param [string] $data
      * @param [string] $from
      * @param [string] $conditions
      * @return void
      */
    public function get_data($data = "", $from = "", $conditions = null){
        global $wpdb;
        
        $from = $wpdb->prefix . $from;

        $sql = "SELECT $data FROM $from";

        if(!empty($conditions)){
            $sql .= " ".$conditions;
        }        

        $result = $wpdb->get_results($sql, ARRAY_A);

        return $result;
    }

    /**
     * Inserting data
     *
     * @param [string] $table
     * @param array $data
     * @param array $format
     * @return void
     */
    public function insert_data($table = "", $data = array(), $format = array()){
        global $wpdb;

        $table = $wpdb->prefix . $table;
        
        $wpdb->insert($table, $data, $format);

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
        global $wpdb;
        $table = $wpdb->prefix . $table;
        $wpdb->update($table, $data, $where, $format);
        
    }

    /**
     * Deleting data
     *
     * @param [string] $table
     * @param [array] $where
     * @param array $format
     * @return void
     */
    public function delete_data($table, $where, $format = array()){
        global $wpdb;
        $table = $wpdb->prefix . $table;
        $wpdb->delete($table, $where, $format);
        
    }

}