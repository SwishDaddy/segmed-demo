<!DOCTYPE html>
<html>
	<head>
	
		<title>Swisher Segmed Demo: Search</title>		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="shortcut icon" type="image/x-icon" href="https://images.squarespace-cdn.com/content/v1/5e5db7f1ded5fc06a4e9628b/1592596990535-PARH2AMSVKHF3O41J27K/ke17ZwdGBToddI8pDm48kP9_9v4eoiVNZ0Bwf4uICJtZw-zPPgdn4jUwVcJE1ZvWQUxwkmyExglNqGp0IvTJZamWLI2zvYWH8K3-s_4yszcp2ryTI0HqTOaaUohrI8PIjHX86RA8EsQshNOk4Ztr_oH-bLnxiE3HuUW-AL-mV20/favicon.ico?format=100w"/>
		
		<link type="text/css" rel="stylesheet" href="css/styles.css" />
		<link type="text/css" rel="stylesheet" href="js/lib/bootstrap/css/bootstrap.min.css" />
		
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>		
		<script type="text/javascript" src="js/lib/bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
		
	</head>

	<body>
		
		<div class="container">
	
			<div id="header" class="row">			
				<div class="col-xs-6">
					<a href="https://www.segmed.ai/" target="_blank">
						<img class="logoimage" src="img/segmedlogo.png" />
					</a>						
				</div>
				<div class="col-xs-6" style="text-align:right;">
					<a href="https://work-samples.swishersolutions.com/" target="_blank">
						<img class="logoimage" src="img/logo.png" style="border: 1px solid black;" />
					</a>				
				</div>			
			</div>
			
			<h1>Searching Text Files Demo</h1>
			
			<br />
			
			<div class="row">
				<div class="col-sm-12">
					
					<div id="searchterm_div">						
						<div class="input-group" style="min-width:20em;max-width:50em;">						
							<span class="input-group-btn">
								<button id="btncontains" class="btn btn-primary" style="font-size:14px;min-width:10em;" >Contains</button>
								<!--onclick="setContains()"-->
							</span>
							<input type="text" id="searchterm" class="form-control" onkeyup="btnGetSearchResults(event)"></input>
							<span class="input-group-btn">
								<button id="btnsearch" class="btn btn-info" style="font-size:14px;min-width:10em;" onclick="getSearchResults()">Find in Files</button>
							</span>
						</div>
						<label id="resultscount" class="titlefont" style="margin:.5em 0 0 .5em;"></label>
					</div>
					
					<div id="searchterm_processing" style="display:none;"><h3><img src="img/loading.gif" style="width:2em;"> Processing...</h3></div>
					
					<div id="searchresults">
					</div>
					
				</div>
				
			</div>
			
			<div class="col-sm-12" style="display:none;">
				<h3>All Documents</h3>
				<br />
				<div id="searchable_documents_list">
				
				</div>				
			</div>
		
		</div>

	</body>
	
</html>