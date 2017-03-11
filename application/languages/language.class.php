<?php
    /* use for selecting language to display */

    define("JAPANESE", "ja");
    define("ENGLISH",  "en");

    class language{
        public $language;
        private $word;

        public function __construct($language){
            $this->language = $language;
            $word = array();
            if($this->language != ""){
                $this->word = $this->read_language($this->language);
            }
        }

        public function text($value){
            if(!array_key_exists(strtolower($value), $this->word)){
                return $value;
            }
            else{
               return $this->word[strtolower($value)];
            }
        }

        private function read_language($language){
            $handle = @fopen(dirname(__FILE__) . "/" .  $language, "r");
            $word   = array();
            if ($handle) {
                while (($buffer = fgets($handle, 4096)) !== false) {
                    //echo $buffer;
                    $buffer = explode(";",  $buffer);
                    //array_push($word, array($buffer[0], $buffer[1]));
                    $word[$buffer[0]] = $buffer[1];
                }
                if (!feof($handle)) {
                    echo "Error: unexpected fgets() fail\n";
                }
                fclose($handle);
            }
            return $word;
        }
    }
?>