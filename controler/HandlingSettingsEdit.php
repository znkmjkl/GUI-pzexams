<?php
	
include_once("../lib/Lib.php");

$file=simplexml_load_file("../cfg/Settings.xml");
/*
echo '<body><pre>';
print_r($file);
echo '</pre>';
echo "<hr>";
*/
if(isset($_POST['debug']) == false){
	$file->Debug = 0;//Is unselected
}else{
	$file->Debug = 1;//Is selected
}


if(!empty($_POST['domains'])) {
	$array[] = $var;
	foreach($file->Domains->children() as $check) {
		array_push($array, $check);
    }
	$array2 = $_POST['domains'];
	$result = array_diff($array2, $array);
	$result2 = array_diff($array, $array2);
	foreach($result as $check) {
		$file->Domains->addChild('Domain', $check);
    }
	foreach($result2 as $check) {
		echo $check.'<br>';
		$res    = $file->xpath('//Domain[.="' . $check . '"]');
		$parent = $res[0];
		unset($parent[0]);
    }
}else{
	echo "Fail";
}

if(isset($_POST['adress'])){
	if($_POST['adress'] != $file->Email->Adress){
		$file->Email->Adress = $_POST['adress'];
	}
}

if(isset($_POST['password'])){
	if($_POST['password'] != $file->Email->Password){
		$file->Email->Password = $_POST['password'];
	}
}

if(isset($_POST['host'])){
	if($_POST['host'] != $file->Email->Host){
		$file->Email->Host = $_POST['host'];
	}
}

if(isset($_POST['port'])){
	if($_POST['port'] != $file->Email->Port){
		$file->Email->Port = $_POST['port'];
	}
}

if(isset($_POST['usecode']) == false){
	$file->Authorization->UseCode = 0;//Is unselected
}else{
	$file->Authorization->UseCode = 1;//Is selected
}
if(isset($_POST['code'])){
	if($_POST['code'] != $file->Authorization->Code){
		$file->Authorization->Code = $_POST['code'];
	}
}
/*
echo "<hr>";
echo '<pre>';
print_r($file);
echo '</pre></body>';
*/

$file->asXml('../cfg/Settings.xml');
header('Location: ../AdminEdit.php' ); 
?>