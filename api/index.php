<?php

// Set some constants
$records_path = '../records/';
$arr["message"] = "success";

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

// Get Search Results	
if ($action == "getsearchresults") {
		
	// Get the search term. If it's blank or not POSTed, then bail with an error.
	$searchterm = "";
	if (isset($_POST["searchterm"])) {
		$searchterm = $_POST["searchterm"];
	};
	if (strlen($searchterm) < 1) {
		$arr["message"] = 'Please provide a Search Term.';
		echo json_encode($arr);
		die();
	};
	
	// Contains or Does Not Contain?
	$contains = "true";
	if (isset($_POST["contains"])) {
		$contains = $_POST["contains"];
	};	
	
	// Get the data from the JSON file. This is where we get the description for the file.
	$arr_filemeta = json_decode(file_get_contents("../file_meta.json"), TRUE);
	
	// Initialize the result objects.
	$arr_results = [];
	
	// If Contains, then search all files that have the search term.
	if ($contains == "true") {
		foreach(glob($records_path . '*.txt') as $filepath) {
			foreach(file($filepath) as $line=>$text) {
							
				// Strip special characters that might break the markup or whatnot
				$text = htmlspecialchars($text);			
				$searchterm = htmlspecialchars($searchterm);
				
				// Pro-tip: "stripos" (with an "i") is case-insensitive
				if(stripos($text, $searchterm) > -1) {					
						
					// Strip the filepath info ("./reports/" or whatever) and get just the filename
					$arr_filepath = explode("/", $filepath);				
					$filename = end($arr_filepath);	
					
					// Get the description for the file_meta JSON and add it to the object
					if (isset($arr_filemeta[$filename])) {				
						$description = $arr_filemeta[$filename];
						$arr_results[$filename]["description"] = $description;				
						$arr_results[$filename][$line+1] = $text;					
					};		
					
				};				
			};
		};
	};
	
	// If Does Not COntain, get all files that do NOT have the search term
	if ($contains == "false") {
		
		foreach(glob($records_path . '*.txt') as $filepath) {
			
			$text = utf8_encode(file_get_contents($filepath));
			
			if(strlen(stripos($text, $searchterm)) < 1) {
				// Strip the filepath info ("./reports/" or whatever) and get just the filename
					$arr_filepath = explode("/", $filepath);				
					$filename = end($arr_filepath);	
					
					// Get the description for the file_meta JSON and add it to the object
					if (isset($arr_filemeta[$filename])) {				
						$description = $arr_filemeta[$filename];
						$arr_results[$filename]["description"] = $description;		
					};	
			};
		};
	};
		
	echo json_encode($arr_results);
	die();
	
};

// Get the list of documents and descriptions from the file_meta.json file. 
if ($action == "getfilemeta") {
	
	$arr_filemeta = file_get_contents("../file_meta.json");
	
	echo $arr_filemeta;
	die();
	
};

// If we got here, then something was POSTed that we were not expecting, so just bail with a generic error message.
echo json_encode('Something went wrong. Sorry about that...');
die();




//###################

// For the file descriptions, I copied and pasted the meta data from the source site for the files (http://www.textfiles.com/fun/). I just copied the html table, then pasted it into a spreadsheet, then removed the size column, then saved as file_meta.csv. Then I used the following code to convert the .csv data to JSON. I use this JSON data in the file_meta.json to show the description for each file, since the source site so conveniently provided them! :)

// I have the code for this all commented out since it was a one-time ETL thing, but I left it for reference purposes. Same thing for the file file_meta.csv in the webroot.

/*
$array = file('./file_meta.csv');

$arr_json = [];

foreach($array as $key=>$line) {
	$arr_csv = str_getcsv($line);	
	foreach($arr_csv as $key=>$val) {		
		$filename = $arr_csv[0];
		$description = $arr_csv[1];	
		$arr_json[$filename] = $description;		
	};	
};

$arr_final_json = [];

foreach($arr_json as $key=>$val) {	
	if (strpos($key, '.txt') > 0) {
		$arr_final_json[$key] = $val;		
	};
};

echo json_encode($arr_final_json);

die();

*/

//####################

?>