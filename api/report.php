<?php
// Set some constants
$records_path = '../records/';
$arr = [];

// Check that an "action" value was POSTed. If not, then bail with an error. This is my little "invention"... a standard of POSTing where we send an "action" value that determines what to do with the rest of the POSTed data.
$action = "";
if (isset($_POST["action"])) {
	$action = $_POST["action"];
};
if (strlen($action) < 1) {
	$arr["message"] = 'An invalid "action" value was POSTed.';
	echo json_encode($arr);
	die();
};

// Get Text from File	
if ($action == "gettext") {
	
	$filename = "";
	
	if (isset($_POST["filename"])) {
		$filename = $_POST["filename"];
	};
	
	//$err = "filepath: " . $records_path . $filename . "<hr />";
	//file_put_contents('/var/www/chaffstaff/phplog.txt', $err.PHP_EOL , FILE_APPEND | LOCK_EX);
	
	foreach(glob($records_path . $filename ) as $filepath) {
		foreach(file($filepath) as $line=>$text) {
			
			//Convert the text to UTF8 in case there are weird symbols or whatnot in the source.
			$text = utf8_encode($text);
			
			$arr[$line+1] = $text;	
		};
	};
			
	echo json_encode($arr);
	die();							
	
};

// Save a new tag to the full tag list.
if ($action == "savenewtag") {
	
	$tagname = "";
	
	if (isset($_POST["tagname"])) {
		$tagname = $_POST["tagname"];
	};
	
	if (strlen($tagname) < 1) {				
		echo json_encode($arr);
		die();
	};
	
	$tagname = str_replace("tag_", "", $tagname);
	
	// Get the data from the Tags JSON file. 
	$arr_tags = json_decode(file_get_contents("../tags.json"), TRUE);
	
	if (!isset($arr_tags["taglist"])) {
		$arr_tags["taglist"] = [];
	};
	
	$arr_tags["taglist"][$tagname] = $tagname;
	
	$f = fopen('../tags.json','w');
	fwrite($f, json_encode($arr_tags));
	fclose($f);
	
	
};

// Assign or Remove a tag for the given file (report).
if ($action == "savereporttag") {
	
	// If the "add" GET value is "false", we'll remove this tag. Otherwise we add it.
	$add = "true";
	if (isset($_POST["add"])) {
		$add = $_POST["add"];
	};
	
	$tagname = "";
	if (isset($_POST["tagname"])) {
		$tagname = $_POST["tagname"];
	};
	if (strlen($tagname) < 1) {				
		echo json_encode($arr);
		die();
	};	
	
	$filename = "";	
	if (isset($_POST["filename"])) {
		$filename = $_POST["filename"];
	};	
	if (strlen($filename) < 1) {				
		echo json_encode($arr);
		die();
	};
	
	// Get *just* the tag name form the tagname variable, which may be prepended with "tag_".
	$tagname = str_replace("tag_", "", $tagname);
	
	// Get the data from the Tags JSON file. 
	$arr_tags = json_decode(file_get_contents("../tags.json"), TRUE);

	if (!isset($arr_tags[$filename])) {
		$arr_tags[$filename] = [];
	};
	
	// Either add the tag or remove it from the file.
	if ($add == "true") {
		$arr_tags[$filename][$tagname] = $tagname;
	}else{
		unset($arr_tags[$filename][$tagname]);
	};
	
	// Write the new tags data to the json file.
	$f = fopen('../tags.json','w');
	fwrite($f, json_encode($arr_tags));
	fclose($f);
	
	
};

//Get tags for reports. Used by /js/index.js and /js/report.js
if ($action == "gettags") {
	
	$filename = "";	
	if (isset($_POST["filename"])) {
		$filename = $_POST["filename"];
	};
	
	$filenames = "";	
	if (isset($_POST["filenames"])) {
		$filenames = $_POST["filenames"];
	};
		
	$arr_tags = json_decode(file_get_contents("../tags.json"), TRUE);

	$arr["tags"] = $arr_tags["taglist"];
	
	$arr["reporttags"] = [];
	
	// If there's only one file in question, get it's tags.
	if (isset($arr_tags[$filename])) {
		$arr["reporttags"] = $arr_tags[$filename];
	};
	
	// If we're looking for more than one file, get tags for them all.
	if (strlen($filenames) > 2) {
		$filenames = json_decode($filenames, TRUE);
		
		foreach($filenames as $filename) {
			if (!isset($arr["reporttags"][$filename])) {
				$arr["reporttags"][$filename] = '';
			};
			
			if (isset($arr_tags[$filename])) {
				$arr["reporttags"][$filename] = $arr_tags[$filename];
			};
			
		};
	};
	
	echo json_encode($arr);
	die();
	
};

// Delete a tag, bith from the global tags list and from each file that uses it.
if ($action == "deletetag") {
	
	$tagname = "";
	
	if (isset($_POST["tagname"])) {
		$tagname = $_POST["tagname"];
	};
	
	if (strlen($tagname) < 1) {				
		echo json_encode($arr);
		die();
	};
	
	$arr_tags = json_decode(file_get_contents("../tags.json"), TRUE);
	
	foreach ($arr_tags as $key=>$val) {
		foreach ($val as $key1=>$val1) {
			if ($val1 == $tagname) {
				unset($arr_tags[$key][$key1]);
			};
		};		
	};
	
	$f = fopen('../tags.json','w');
	fwrite($f, json_encode($arr_tags));
	fclose($f);	
	
	echo json_encode($arr);
	die();
	
};

// If we got here, then something was POSTed that we were not expecting, so just bail with a generic error message.
echo json_encode('Something went wrong. Sorry about that...');
die();

?>