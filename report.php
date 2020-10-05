<!DOCTYPE html>
<html>
	<head>
	
		<title id="page_title">Filename: Swisher Segmed</title>		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="shortcut icon" type="image/x-icon" href="https://images.squarespace-cdn.com/content/v1/5e5db7f1ded5fc06a4e9628b/1592596990535-PARH2AMSVKHF3O41J27K/ke17ZwdGBToddI8pDm48kP9_9v4eoiVNZ0Bwf4uICJtZw-zPPgdn4jUwVcJE1ZvWQUxwkmyExglNqGp0IvTJZamWLI2zvYWH8K3-s_4yszcp2ryTI0HqTOaaUohrI8PIjHX86RA8EsQshNOk4Ztr_oH-bLnxiE3HuUW-AL-mV20/favicon.ico?format=100w"/>
		
		<link type="text/css" rel="stylesheet" href="css/styles.css" />
		<link type="text/css" rel="stylesheet" href="js/lib/bootstrap/css/bootstrap.min.css" />
		
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>		
		<script type="text/javascript" src="js/lib/bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="js/report.js"></script>
		
		<style>
			
			body {
				padding:0 2em;				
			}
			
			#report_text {
				word-break: break-all;
			}
			
			#container {
				display:none;
			};
			
			#splashscreen {				
				margin-top: 30%;
				margin: auto;
			}
			
			#newtag_div {
				display:none;
			}
			
			#taglist_div {
				padding: 2em;
			}
			
		
		</style>
		
	</head>

	<body>
		
		<div id="splashscreen">
			<h3><img src="img/loading.gif" style="width:2em;"> Processing...</h3>
		</div>
		
		<div  id="container" class="container">
			<div class="row" id="report_text_parent">
				<div class="col-md-8">
				
					<span style="display:inline-block;" id="report_filename" class="titlefont2"></span>
					<div style="display:inline-block;padding-left:1em;padding-bottom:none;margin-bottom:none;" id="report_tags">tags</div>					
					<br />
					<br />
					<div class="pillcontainer">				
						<div id="report_text"></div>
					</div>
				</div>
				
				<div class="col-md-4">
					<span class="titlefont2">Tag Management</span>
					<br />
					<br />
					<div class="pillcontainer">
						<button id="addtag" class="btn btn-primary">Add</button>
						<div id="newtag_div">
							<div class="input-group" style="min-width:10em;">						
							
								<input type="text" id="newtag" class="form-control"></input>
								<span class="input-group-btn">
									<button id="btnaddtagsave" class="btn btn-primary" style="font-size:14px;" onclick="">Save</button>
								</span>
								<span class="input-group-btn">
									<button id="btnaddtagcancel" class="btn btn-danger" style="font-size:14px;" >Cancel</button>
								</span>
							</div>
						</div>
						
						<div id="taglist_div"></div>
						
					</div>
				</div>			
			</div>
		
		</div>
	
	
	</body>
	
</html>