<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <title>Isitirio</title>
  <link rel="stylesheet" type="text/css" href="/semanticui/semantic.css" />
  <link rel="stylesheet" type="text/css" href="/semanticui/components/dropdown.min.css" />
  <script src="/semanticui/jquery.min.js"></script>
  <script src="/semanticui/semantic.js"></script>
  <script src="/semanticui/components/dropdown.min.js"></script>
</head>
<body>

<div class="ui stackable menu" id="i_menu">
  <a class="item active" href="/">
    Home
  </a>
  <a class="item" popup-from="i_project_popup" popup-position="dropdown">
    Projects
  </a>
  <a class="item" access-denied="Access diened to tickets.">
    Tickets
  </a>
  <div class="right menu">
    <div class="item">
        <div class="ui primary button" access-denied="Access diened to create tickets.">
           Create
        </div>
    </div>
    <div class="item">
      <div class="ui transparent icon input">
        <input placeholder="Search..." type="text">
        <i class="search link icon"></i>
      </div>
    </div>
    <a class="item" access-denied="Access denied to settings.">
      <i class="setting icon"></i>
    </a>
    <a class="item">
      <i class="sign out icon"></i>
    </a>
  </div>
</div>
<div id="i_menu_space" style="display:none;">
</div>

<div class="ui flowing basic admission popup" id="i_project_popup">
  <div class="ui two column relaxed divided grid">
    <div class="inverse column" style="background-color:#FCFFFF">
      <h4 class="ui header">Most recent</h4>
      <div class="ui link list">
        <a class="item">Design &amp; Urban Ecologies</a>
        <a class="item">Fashion Design</a>
        <a class="item">Fine Art</a>
        <div class="item">
          <br />
          <a class="ui primary button">Show all</a>
        </div>
      </div>
    </div>
    <div class="column" style="background-color:#FFFCFF">
      <h4 class="ui header">Bookmarked</h4>
      <div class="ui link list">
        <a class="item">Anthropology</a>
        <a class="item">Economics</a>
        <a class="item">Media Studies</a>
        <a class="item">Philosophy</a>
      </div>
    </div>
  </div>
</div>


<!-- Main Content starts here -->

<div id="i_main" style="margin:5px;">

<?php
	if(isset($maintmpl)) {
		if(file_exists(__DIR__ . '/' . $maintmpl . '.php')) {
			include(__DIR__ . '/' . $maintmpl . '.php');
		}
	}
?>

</div>

<script src="/semanticui/isitirio.js"></script>
<script type="text/javascript">
$("[access-denied]").each(function(index, value) {
    var n = $(value);
    n.click(function() {
       isitirio.growl("Access Denied", n.attr("access-denied"), {timeout: 5000});
    });
});
</script>
</body>
</html>
