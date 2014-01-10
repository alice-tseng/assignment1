<?php
//initiate the xml and set it to the $items variable
$items = simplexml_load_file("my_xml.xml");
if(isset($_GET['pokemon'])){
	$num = (isset($_GET['num'])) ? $_GET['num'] : NULL;
	
	if(empty($num) && $num !== "0"){
		$arr = array();
		foreach($items as $item){
			array_push($arr, $item);
		}
		echo json_encode($arr);
	} else {
		$num = intval($num);
		if($num < count($items->item)){
			echo json_encode($items->item[$num]);
		} else {
			echo 0;	
		}
	}
	
}

if(isset($_POST['insert'])){
	$image = (isset($_POST['image'])) ? $_POST['image'] : NULL;
	$title = (isset($_POST['title'])) ? $_POST['title'] : NULL;
	$desc = (isset($_POST['desc'])) ? $_POST['desc'] : NULL;
	
	if(empty($image) || empty($title) || empty($desc)) {
		echo 0;	
	}
	
	//CHANGING THE DATABASE
	$num = count($items->item);
	//MAKE SURE YOU ALWAYS HAVE AN ID to do checks when remove
	$items->item[$num]->id = $num;
	$items->item[$num]->image = $image;
	$items->item[$num]->title = $title;
	$items->item[$num]->desc = $desc;
	
	//DON'T NEED TO TOUCH
	$dom = new DOMDocument('1.0');
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$dom->loadXML($items->asXML());
	//DON'T NEED TO TOUCH - END
	
	//save to a file
	$dom->save('my_xml.xml');
}

if(isset($_POST['edit'])){
	$num = (isset($_POST['num'])) ? $_POST['num'] : NULL;
	$image = (isset($_POST['image'])) ? $_POST['image'] : NULL;
	$title = (isset($_POST['title'])) ? $_POST['title'] : NULL;
	$desc = (isset($_POST['desc'])) ? $_POST['desc'] : NULL;
	
	if(empty($num) && $num < count($items->item)) {
		echo 0;	
	}
	
	//CHANGING THE DATABASE
	$items->item[$num]->image = $image;
	$items->item[$num]->title = $title;
	$items->item[$num]->desc = $desc;
	
	//DON'T NEED TO TOUCH
	$dom = new DOMDocument('1.0');
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$dom->loadXML($items->asXML());
	//DON'T NEED TO TOUCH- END
	
	//save to a file
	$dom->save('my_xml.xml');
}

//DON'T NEED TO TOUCH unless you named id/item in the xml differently
if(isset($_POST['remove'])){
	$num = (isset($_GET['num'])) ? $_POST['num'] : NULL;
	
	if(empty($num) && $num < count($items->item)) {
		echo 0;	
	}
	
	$num = intval($num);
	foreach($items as $item)
	{
		if($item->id == $num) {
			unset($items->item[$num]);
		}
	}
	
	$dom = new DOMDocument('1.0');
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$dom->loadXML($items->asXML());
	$dom->save('my_xml.xml');
}
//DON'T NEED TO TOUCH- END
?>