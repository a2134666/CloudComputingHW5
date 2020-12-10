<?php
header("Access-Control-Allow-Origin: *");
// report result
if(isset($_REQUEST["result"]) and isset($_REQUEST["second"])){
  $logTime = date("d-M-Y H:i:s e"); // for logging
  try{
    $pdo = new PDO("mysql:host=localhost;dbname=AWA", "AWA", "AWA");
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("SET CHARACTER SET UTF8");
  }
  catch(PDOException $e){
    error_log("[{$logTime}] '{$_SERVER["PHP_SELF"]}': connect error -> {$e->getMessage()}\n", 3, "error_log");
    http_response_code(500);
    die("Internal Server Error");
  }
  
  try{
    $result = ($_REQUEST["result"] == 1)? 1: 0;
    $second = (intval($_REQUEST["second"])>0)? intval($_REQUEST["second"]): "null";
    
    $sql = "insert into `log` values (null, {$result}, {$second}, now());";
    $query = $pdo->query($sql);
  }
  catch(PDOException $e){
    error_log("[{$logTime}] '{$_SERVER["PHP_SELF"]}': query error -> {$e->getMessage()}\n", 3, "error_log");
    error_log("[{$logTime}] '{$_SERVER["PHP_SELF"]}': statement -> {$sql}\n", 3, "error_log");
    http_response_code(500);
    die("Internal Server Error");
  }
}
// get statistics
else if(isset($_REQUEST["type"]) and $_REQUEST["type"] == "statistics"){
  $logTime = date("d-M-Y H:i:s e"); // for logging
  try{
    $pdo = new PDO("mysql:host=localhost;dbname=AWA", "AWA", "AWA");
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("SET CHARACTER SET UTF8");
  }
  catch(PDOException $e){
    error_log("[{$logTime}] '{$_SERVER["PHP_SELF"]}': connect error -> {$e->getMessage()}\n", 3, "error_log");
    http_response_code(500);
    die("Internal Server Error");
  }
  
  try{
    $sql = "select count(*) as c, result, CAST(create_time AS DATE) as date from `log` group by result, CAST(create_time AS DATE)";
    $query = $pdo->query($sql);
    
    $statistics = [];
    while($count = $query->fetch(PDO::FETCH_ASSOC)){
      if(isset($statistics[$count["date"]])){
        $statistics[$count["date"]][$count["result"]] = $count["c"];
      }
      else{
        $temp = [];$temp[$count["result"]] = $count["c"];
        $statistics[$count["date"]] = $temp;
      }
    }
    exit(json_encode($statistics));
  }
  catch(PDOException $e){
    error_log("[{$logTime}] '{$_SERVER["PHP_SELF"]}': query error -> {$e->getMessage()}\n", 3, "error_log");
    error_log("[{$logTime}] '{$_SERVER["PHP_SELF"]}': statement -> {$sql}\n", 3, "error_log");
    http_response_code(500);
    die("Internal Server Error");
  }
}
?>