<?php
// call database class
    class Query {
    // Variablen
     var $_sql = "";
     var $_result = 0;
     var $_errno = 0;
     var $_error = "";

       //Konstruktor
        function Query($sql)
        {
        // Query in der Klasse speichern
        	$this->_sql = trim($sql);
        	$this->_result = mysql_query($this->_sql);
          if(!$this->_result) {
            $this->_errno = mysql_errno();
            $this->_error = mysql_error();
          }       
        }

       //Methoden
        function error()
        {
        // Result-ID in einer tmp-Variablen speichern
         $tmp = $this->_result;
        // Variable in boolean umwandeln
         $tmp = (bool)$tmp;
        // Variable invertieren
         $tmp = !$tmp;
        // und zurückgeben
         return $tmp;
        }

        function getError() {
         if($this->error()) {
            $str  = "request:\n".$this->_sql."\n";
            $str .= "response:\n".$this->_error."\n";
            $str .= "Errorcode: ".$this->_errno;
         } 
         else $str = "No error.";
         return $str;
        }
        function getErrno() {
         return $this->_errno;
        }

        function fetch() {
         if($this->error()) {
            echo "An Error has occurred, please check your MySQL-Query.";
            $return = null;
         } 
         else $return = mysql_fetch_assoc($this->_result);
         return $return;
        }

        function numRows() {
         if($this->error()) {
            $return = -1;
         }
         else $return = mysql_num_rows($this->_result);
         return $return;
        }
        
        function free() {
        // Speicher freimachen
         mysql_free_result($this->_result);
        }

    }
?>
