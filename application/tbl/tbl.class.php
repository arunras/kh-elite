<?php

    /*
    * Class for accessing to database for any single table
    * Creator: Loch Khemarin
    * Date: 10/04/2011
    */

    //use for connection with database for each record
    include_once(dirname(dirname(dirname(__FILE__))) . "/module/module.php");

    class tbl{
        public $table_name;                 //Name of the table to be accessed
        public $primary_key_field;          //Field name of primary key of the table
        public $primary_key_type;           //Datatype of primary key
        public $primary_key_value;          //Primary key value

        /* initialize with or without table name */
        public function __construct($table_name = "", $primary_key_field = "", $primary_key_value="", $primary_key_type = "non-string"){
            $this->table_name = $table_name;
            $this->primary_key_field = $primary_key_field;
            $this->primary_key_type = $primary_key_type;
            $this->primary_key_value = $primary_key_value;
            if($this->primary_key_type != "non-string"){
                $this->primary_key_value = "'" . $this->primary_key_value . "'";
            }
        }

        /* get value from database */
        public function getValue($field_name, $special_condition = "",  $operator = "="){
            if($field_name != "" && $this->primary_key_value != ""){
                return getValue("SELECT " . $field_name . " FROM " . $this->table_name . " WHERE " . $this->primary_key_field . " " . $operator . " "  . $this->primary_key_value . " " . $special_condition);
            }
        }

        /* Update value to database */
        public function setValue($field_name, $value, $field_type = "non-string", $special_condition = ""){
            if($field_name != ""){
                if($field_type != "non-string"){
                    $value = "'" . $value . "'";
                }
                return runSQL("UPDATE " . $this->table_name . " SET " . $field_name . " = " . $value . " WHERE " . $this->primary_key_field . " = " . $this->primary_key_value . " " . $special_condition);
            }
        }
    }
