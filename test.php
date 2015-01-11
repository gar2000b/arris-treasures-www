<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test Page</title>
<style type="text/css">
	#pane {
		position:relative;
		width:300px; height:300px;
		border:2px solid red;
	}
		
	#box {
		position:absolute; top:140px; left:140px;
		width:20px; height:40px;          
		background-color:black;
	}
</style>
<script type="text/javascript" src="javascripts/jquery-1.8.2/jquery-1.8.2.min.js"></script>
<script type="text/javascript">

	function execute() {
		var pane = $('#pane'),
			box = $('#box'),
			w = pane.width() - box.width(),
			d = {},
			x = 1;
		
		function newv(v,a,b) {
			var n = parseInt(v, 10) - (d[a] ? x : 0) + (d[b] ? x : 0);
			return n < 0 ? 0 : n > w ? w : n;
		}
		
		$(window).keydown(function(e) { d[e.which] = true; });
		$(window).keyup(function(e) { d[e.which] = false; });
		
		setInterval(function() {
			box.css({
				left: function(i,v) { return newv(v, 37, 39); },
				top: function(i,v) { return newv(v, 38, 40); }
			});
		}, 10);
	}
	
</script>
</head>
<body onload="execute();">
<div id="pane">
    <div id="box"></div>
</div>
</body>
</html>
