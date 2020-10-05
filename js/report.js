// Get the passed GET parameters
const queryString = window.location.search;

// Parse the GET
const urlParams = new URLSearchParams(queryString);

//Assign the GET parameters to variables
const filename = urlParams.get('filename') || "";
const searchterm = urlParams.get('searchterm') || "";
const contains = urlParams.get('contains') || "";

// SHows or Hides the "New Tag" input
document.addEventListener('click', function(e){
	if (e.target && (e.target.id == "addtag")) {
		document.getElementById("addtag").style.display = "none";
		document.getElementById("newtag_div").style.display = "block";
	}
});

// Delete a tag
document.addEventListener('click', function(e){
	if (e.target && (e.target.className.indexOf('deletetag') > -1)) {		
		let id = e.target.id;
		// Get *just* the filename from the id
		tagname = id.replace("tagdelete_", "");		
		deleteTag(tagname);
	};
});

// Set whether a tag in the tag list is selected for the current report.
document.addEventListener('click', function(e){
	if (e.target && (e.target.className.indexOf('taglist_tag') > -1)) {
					
		if (e.target.className.indexOf('tagselected') > -1) {
			document.getElementById(e.target.id).classList.remove("tagselected");
			saveReportTag(e.target.id, filename, false);
		}else{			
			document.getElementById(e.target.id).classList.add("tagselected");
			saveReportTag(e.target.id, filename, true);
		};
				
	};
});

// Save a new tag.
document.addEventListener('click', function(e){
	if (e.target && (e.target.id == "btnaddtagsave")) {

		let newtag = document.getElementById("newtag").value;

		const requestOptions = {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: 'action=savenewtag&tagname=' + newtag,
		};
		fetch('api/report.php', requestOptions)
		.then(async response => {	

			document.getElementById("newtag_div").style.display = "none";
			document.getElementById("addtag").style.display = "block";

			getTagList();

		})
		.catch(error => {
			console.error(error);
		});

	}
});

// Cancel vadding a new tag. Hides the new tag input and show the Add button.
document.addEventListener('click', function(e){
	if (e.target && (e.target.id == "btnaddtagcancel")) {
		document.getElementById("newtag_div").style.display = "none";
		document.getElementById("addtag").style.display = "block";
	}
});


// Get the data for this file.
const requestOptions = {
	method: 'POST',
	headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
	body: 'action=gettext&filename=' + filename,
};

fetch('api/report.php', requestOptions)
.then(async response => {
	const data = await response.json();

	let text_markup = '';

	for (var key in data) {
		if (data.hasOwnProperty(key)) {
			data[key] = data[key].replace(new RegExp(searchterm,'i'),'<span class="highlighted">$&</span>');
			text_markup += '<b>' + key + ':</b> ' + data[key] + '<br />';
		}
	};

	let filenamelink = 'File Name: <a id="btnraw" href="" target="_blank">' + filename + '</a>';

	document.getElementById("report_text").innerHTML = text_markup;
	document.getElementById("report_filename").innerHTML = filenamelink;
	
	// Set the path for the Raw file.
	document.getElementById("btnraw").href = "records/" + filename;

	// Add the filename to the title. This helps the User see which browser tab has which file open.
	document.getElementById("page_title").innerHTML = filename + ': Swisher Segmed';

	getTagList();

	//Delay hiding the "Processing..." bit to prevent a "blink" effect.
	window.setTimeout(function() {
		document.getElementById("splashscreen").style.display = "none";
		document.getElementById("container").style.display = "block";
	}, 750);

})
.catch(error => {
	console.error(error);
});

// Get the tags for the Tag List and for the report.
function getTagList() {

	let bodystring = 'action=gettags&filename=' + filename;
	
	const requestOptions = {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: bodystring,
	};

	fetch('api/report.php', requestOptions)
	.then(async response => {
		const data = await response.json();
				
		document.getElementById("taglist_div").innerHTML = "";
		
		let taglist_markup = "";
	
		for (var key in data["tags"]) {
			taglist_markup += '<div style="margin-bottom:1em;display:inline-block;">' +
				'<button id="tagdelete_' + key + '" style="height: 24px;" class="glyphicon glyphicon-remove-circle deletetag"></button>' +
				'<span class="tag tagbg1 taglist_tag" id="tag_' + key + '" style="display:block-inline;">' + key + '</span>' +
			'</div>';
		};
		
		document.getElementById("taglist_div").innerHTML = taglist_markup;
		
		let report_tag_markup = "";		 
		
		for (var key in data["reporttags"]) {
			document.getElementById("tag_" + key).classList.add("tagselected");
			report_tag_markup += '<span class="tag tagbg2 tagselected" style="display:block-inline;margin-right:10px;">' + key + '</span>';					
		};
								
		document.getElementById("report_tags").innerHTML = report_tag_markup;		

	})
	.catch(error => {
		console.error(error);
	});

};

// Assign a tag to the report.
function saveReportTag(tagname, filename, add) {
	
	tagname = tagname.replace("tag_", "");
	
	const requestOptions = {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: 'action=savereporttag&filename=' + filename + '&tagname=' + tagname + '&add=' + add,
	};
		
	fetch('api/report.php', requestOptions)
	.then(async response => {	

		document.getElementById("newtag_div").style.display = "none";
		document.getElementById("addtag").style.display = "block";

		// Update all tags
		getTagList();

	})
	.catch(error => {
		console.error(error);
	});
	
};

// Delete a Tag
function deleteTag(tagname) {
	
	var r = confirm("Really Delete " + tagname + "? It will be removed from ALL files!");
	if (r != true) {
		return false;
	};
	
	const requestOptions = {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: 'action=deletetag&tagname=' + tagname
	};
		
	fetch('api/report.php', requestOptions)
	.then(async response => {	

		getTagList();

	})
	.catch(error => {
		console.error(error);
	});	
	
};
