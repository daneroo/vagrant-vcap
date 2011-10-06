<?php
header('Content-type: text/plain');

echo "iMetrical-php says Hello sebastien@vcap.me!\n\n"; 

$rec = array("ip"=>$_SERVER["REMOTE_ADDR"],"ts"=>time());
//HTTP_USER_AGENT
echo json_encode($rec)."\n\n";

$services = getenv("VCAP_SERVICES");


if ($services){
    $services_json = json_decode($services,true);
    print_r($services);
    echo "\n\n";

    $mongo_config = $services_json["mongodb-1.8"][0]["credentials"];
    print_r($mongo_config);
    echo "\n\n";
    //echo json_encode($mongo_config)."\n";
}

$username =  $mongo_config["username"];
$password =  $mongo_config["password"];
//$username =  "7530c8f5-9d7b-4b08-8837-6c3c727369c0"; //$mongo_config["username"];
//$password =  "474aa6f7-58cb-434d-936f-eed087aa2f4f"; //$mongo_config["password"];
$host =  $mongo_config["host"];
$port =  $mongo_config["port"];
$dbname = $mongo_config["db"];
//$mongourl = "mongodb://${username}:${password}@${host}:${port}/${dbname}";
$mongourl = "mongodb://${host}:${port}";
echo $mongourl."\n\n";
//ok var_dump($rec);
//var_dump($rec);echo " before setup\n\n";
$m = new Mongo($mongourl);

//var_dump($rec);echo " after setup\n\n";

$db = $m->selectDB($dbname);
//var_dump($rec);echo " after select \n\n";

$db->authenticate($username, $password);
//var_dump($rec);echo " after auth\n\n";

$collection = $db->logs;
//var_dump($rec); echo " init collection \n\n";


$collection->insert($rec);
//var_dump($rec);echo " after insert \n\n";

$cursor = $collection->find();

// iterate through the results
foreach ($cursor as $rec) {
    echo json_encode($rec)."\n";
}
?>
