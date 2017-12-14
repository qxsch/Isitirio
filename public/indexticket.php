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

<div class="ui pointing menu">
  <a class="item active" href="/">
    Home
  </a>
  <a class="item" id="i_project_btn">
    Projects
  </a>
  <a class="item">
    Tickets
  </a>
  <div class="right menu">
    <div class="item">
        <div class="ui primary button">
           Create
        </div>
    </div>
    <div class="item">
      <div class="ui transparent icon input">
        <input placeholder="Search..." type="text">
        <i class="search link icon"></i>
      </div>
    </div>
    <a class="item">
      <i class="setting icon"></i>
    </a>
    <a class="item">
      <i class="sign out icon"></i>
    </a>
  </div>
</div>

<div class="ui flowing basic admission popup" id="i_project_popup">
  <div class="ui three column relaxed divided grid">
    <div class="column">
      <h4 class="ui header">Business</h4>
      <div class="ui link list">
        <a class="item">Design &amp; Urban Ecologies</a>
        <a class="item">Fashion Design</a>
        <a class="item">Fine Art</a>
        <a class="item">Strategic Design</a>
      </div>
    </div>
    <div class="column">
      <h4 class="ui header">Liberal Arts</h4>
      <div class="ui link list">
        <a class="item">Anthropology</a>
        <a class="item">Economics</a>
        <a class="item">Media Studies</a>
        <a class="item">Philosophy</a>
      </div>
    </div>
    <div class="column">
      <h4 class="ui header">Social Sciences</h4>
      <div class="ui link list">
        <a class="item">Food Studies</a>
        <a class="item">Journalism</a>
        <a class="item">Non Profit Management</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#i_project_btn').popup({ on: 'click' , popup: '#i_project_popup' });
</script>

<!-- Main Content starts here -->

<div style="margin:5px;">

<div class="ui masthead vertical segment">
  <h1 class="ui header">Theming</h1>
</div>

<div class="ui masthead vertical segment">
  <div class="ui primary button">
    <i class="edit icon"></i>
    <span>Edit</span>
  </div> 
  <div class="ui button">
    <i class="comment icon"></i>
    <span>Comment</span>
  </div>
  <div class="ui dropdown button">
    <i class="user circle icon"></i>
    <span>Assign</span>
    <i class="dropdown icon"></i>
    <div class="menu">
      <div class="header">Select Language</div>
      <div class="ui icon search input">
         <i class="search icon"></i>
         <input placeholder="Search languages..." type="text">
      </div>
      <div class="item"></div>
    </div>
  </div>
  <div class="ui dropdown button">
    <i class="right arrow circle icon"></i>&nbsp;
    <span>Transition</span>
    <i class="dropdown icon"></i>
    <div class="menu">
      <div class="item">hello</div>
      <div class="item">world</div>
    </div>
  </div>

<!--  <div class="menu">
    <div class="item">New</div>
    <div class="item">
      <span class="description">ctrl + o</span>
      Open...
    </div>
    <div class="item">
      <span class="description">ctrl + s</span>
      Save as...
    </div>
    <div class="item">
      <span class="description">ctrl + r</span>
      Rename
    </div>
    <div class="item">Make a copy</div>
    <div class="item">
      <i class="folder icon"></i>
      Move to folder
    </div>
    <div class="item">
      <i class="trash icon"></i>
      Move to trash
    </div>
    <div class="divider"></div>
    <div class="item">Download As...</div>
    <div class="item">
      <i class="dropdown icon"></i>
      Publish To Web
      <div class="menu">
        <div class="item">Google Docs</div>
        <div class="item">Google Drive</div>
        <div class="item">Dropbox</div>
        <div class="item">Adobe Creative Cloud</div>
        <div class="item">Private FTP</div>
        <div class="item">Another Service...</div>
      </div>
    </div>
    <div class="item">E-mail Collaborators</div>
  </div> -->




</div>

<br />

<div class="ui two column stackable divided grid">
  <div class="ten wide column">
    <div class="ui">
       Content<br />
       Content<br />
       Content<br />
       Content<br />
       Content<br />
    </div>
  </div>
  <div class="six wide column">
    <div class="ui">Content</div>
  </div>
</div>


</div>

<script type="text/javascript">
$('.ui.dropdown')
  .dropdown()
;
</script>
</body>
</html>
