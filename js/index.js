// Whether the User has selected "Contains" or "Does Not COntain". Deafults to true nad changes when  the User clicks the button.
var contains = true;

// A list of the files currently displayed. Gets updated whenever a search is performed.
var filenames = {};

// Set a 5-second timer to update the flags assigned to the files in the search results. We do this because the User can update the flags in the reports window, and since it is another tab, those updates won't update this page in real time. If I had more time, I might have gone with a Node.js service using Socket.io to set up a websocket for updates...  but for this demo project, I figure a poll will suffice :)
let tag_update_timer = window.setInterval(function() {
	getReportTags();
}, 5000);

// Retrieve the file list with descriptions for display
getfilemeta();

// Shows or Hides the reulsts for a given file. Each "Contains" result has a button for this.... "Does Not Contain" results don't have the View Results button, since there are no results.

document.addEventListener('click', function(e){

	if(e.target && (e.target.className.indexOf('showresults') > -1)) {

		let btnel = e.target;

		let btnid = btnel.id;

		let filename = btnid.replace("btn_", "");

		let el = document.getElementById("results_div_" + filename);

		if (el.style.display == "none") {
			el.style.display = "block";
			btnel.innerHTML = "Hide Results";
		}else{
			el.style.display = "none";
			btnel.innerHTML = "View Results";
		};

	}
});

// The handler for the "Contains/Does Not Contain" button. Updates the global variable "contains".
document.addEventListener('click', function(e){
	if(e.target && (e.target.id == "btncontains")) {
		document.getElementById("searchresults").innerHTML = "";
		document.getElementById("resultscount").innerHTML = "";
		if (contains) {
			e.target.innerHTML = "Does Not Contain";
			e.target.classList.remove("btn-primary");
			e.target.classList.add("btn-danger");
			contains = false;
		}else{
			e.target.innerHTML = "Contains";
			e.target.classList.remove("btn-danger");
			e.target.classList.add("btn-primary");
			contains = true;
		};
	}
});

// Get the Search Results
function getSearchResults() {

	let arr_results = [];

	let searchterm = "";
	searchterm = document.getElementById('searchterm').value;

	document.getElementById("searchresults").innerHTML = "";
	document.getElementById("resultscount").innerHTML = "";


	if (searchterm.length < 1) {
		alert("Please provide a Search Term");
		return false;
	};

	document.getElementById("searchterm_div").style.display = "none";
	document.getElementById("searchterm_processing").style.display = "block";

	const requestOptions = {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: 'action=getsearchresults&searchterm=' + searchterm + '&contains=' + contains,
	};

	fetch('api/index.php', requestOptions)
	.then(async response => {
		const data = await response.json();

		results_markup = "";

		// The server will return an error is something goes wrong; otherwise it wil lreturn a message of "success".
		if (data["message"]) {

			if (data["message"] != "success") {
				alert(data["message"]);
				return false;
			}

			delete(data["message"]);
		};

		let count = 0;

		for (var key in data) {
			if (data.hasOwnProperty(key)) {

				let view_results_button = "";
				if (contains) {
					view_results_button = '<button class="btn btn-default showresults" style="margin-right:2em;" id="btn_' + key + '">View Results</button>';
				};

				let report_link = '<a id="report_link_' + key + '" style="display:inline-block;" href="report.php?filename=' + key + '&searchterm=' + searchterm + '" target="_blank">' + key + '</a>';

				let tags_markup = '<span id="report_tags_' + key + '" style="display:inline-block;margin-left:1em;"></span>';

				count = count + 1;

				let filename = key;
				let fileinfo = data[key];
				var description = fileinfo["description"];

				filenames[key] = key;

				delete fileinfo["description"];

				results_markup += '<div id="result_' + count + '" class="result_parent">' +
					'<span class="titlefont inline">' +
						view_results_button +
						report_link +
					'</span>' +
					'<span class="inline" style="margin-left:1em;">' +
						'<i>(' + description + ')</i>' +
					'</span>' +
					tags_markup +
				'</div>' +
				'<div id="results_div_' + key + '" style="display:none;margin-top:1em;">';

				for (var key1 in fileinfo) {
					if (fileinfo.hasOwnProperty(key1)) {
						var found_text = fileinfo[key1];
						var result = found_text.replace(new RegExp(searchterm,'i'),'<span class="highlighted">$&</span>');
						results_markup += '<p style="margin-left:3em;"><b>Line ' + key1 + ":</b> " + result + "</p>";
					}
				}

				results_markup += '</div><hr />';

			}
		}

		// Wait one secod on top of any other processing time... this prevents the "Processing..." message from disappearing too fast and creating a weird "blinking" experience onscreen.
		window.setTimeout(function() {
			document.getElementById("searchresults").innerHTML = results_markup;
			getReportTags();
			document.getElementById("resultscount").innerHTML = count + " Records Found";
			document.getElementById("searchterm_processing").style.display = "none";
			document.getElementById("searchterm_div").style.display = "block";
		}, 1000);

	})
	.catch(error => {
		console.error(error);
	});
}

// Make the Enter key work for searching
function btnGetSearchResults(event) {
	var keycode = event.which || event.keyCode;
	if (keycode == 13) {
		getSearchResults();
	};
};

// Get the descriptions for the files.
function getfilemeta() {

	const requestOptions = {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: 'action=getfilemeta',
	};
	fetch('api/index.php', requestOptions)
	.then(async response => {
		const data = await response.json();

		let file_meta_markup = '';

		for (var key in data) {
			if (data.hasOwnProperty(key)) {
				file_meta_markup += '<h4><a href="records/' + key + '">' + key + '</a></h4>' + '<p style="margin-left:3em;"><i>' + data[key] + '</i></p><br />';
			}
		}

		document.getElementById('searchable_documents_list').innerHTML = file_meta_markup;

	})
	.catch(error => {
		console.error(error);
	});

};

// Get any tags that are assigend to the files.
function getReportTags() {

	let bodystring = 'action=gettags&filenames=' + JSON.stringify(filenames);

	const requestOptions = {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: bodystring,
	};

	fetch('api/report.php', requestOptions)
	.then(async response => {
		const data = await response.json();

		let report_tag_markup = "";

		for (var key in data["reporttags"]) {
			if (key.length > 0) {
				if (document.getElementById('report_tags_' + key)) {
					document.getElementById('report_tags_' + key).innerHTML = "";
					for (var key1 in data["reporttags"][key]) {
						report_tag_markup = '<span class="tag tagbg2 tagselected" style="display:block-inline;margin-right:10px;">' + key1 + '</span>';
						document.getElementById('report_tags_' + key).innerHTML += report_tag_markup;
					};
				};
			};
		};

	})
	.catch(error => {
		console.error(error);
	});

};

logVisit = (pagename) => {

	const requestOptions = {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: 'action=logvisit&pagename=' + pagename,
	};
	fetch('https://work-samples.swishersolutions.com/api/api.php', requestOptions)
	.then(async response => {

	})
	.catch(error => {
		console.error(error);
	});

}

this.logVisit(window.location.href);
