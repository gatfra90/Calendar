<?php
  /**
   * manage connection to mysql db (host,user,psw,db_name)
   */
  class MySQL
  {
    private $conn;
    private $host;
    private $user;
    private $psw;
    private $db;

    /**
     * constructor
     * @param $host string
     * @param $user string
     * @param $psw string
     * @param $db string
     */
    function __construct($host = "localhost", $user = "root", $psw = "", $db = "calendar") {
      $this->host = $host;
      $this->user = $user;
      $this->psw = $psw;
      $this->db = $db;
      $this->conn = mysqli_connect($this->host,$this->user,$this->psw,$this->db);
    }

    /**
     * execute a query
     * @param $query string
     * @return mysqli_result
     */
    function query_exe($query = ""){
      return $this->conn->query($query) or die($this->db_error());
    }

    /**
     * return mysqli error
     * @return mysqli_result
     */
    function db_error() {
      return mysqli_error($this->conn);
    }
  }