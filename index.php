<!DOCTYPE html>
<html>
<head>
	<title>Searchi</title>
	<link rel="stylesheet" type="text/css" href="public/styles/style.css">
	<script src="public/js/jquery.js" type="text/javascript"></script>
	<script src="public/js/index.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
<br/>
<div class="row">
	<div class="col-sm-8">
			<form  onsubmit="submit_data(null);return false;" method="post">
			<input type="text" autocomplete="off" class="form-control" id="pharse" placeholder="enter your search phrase here..."/>
	</div>
	<div class="col-sm-2">
			<input type="submit" name="submit" class="btn btn-primary"/>
			</form>
	</div>
	<div class="col-sm-2">
		<img id="loadingDiv" src="public/img/ajax-loader.gif" />
	</div>
</div>
</div>
<div>
	<ul class="list-group floatinglist" id="searchKeyLists">
	</ul>
</div>
</body>
</html>