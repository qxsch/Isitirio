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
  <div class="ui primary button" popup-from="i_assignee_popup" popup-position="dropdown">
    <i class="user circle icon"></i>
    <span>Assign</span>
    <i class="dropdown icon"></i>
  </div>
  <div class="ui dropdown button" dropdown>
    <i class="right arrow circle icon"></i>&nbsp;
    <span>Transition</span>
    <i class="dropdown icon"></i>
    <div class="menu">
      <div class="item">hello</div>
      <div class="item">world</div>
    </div>
  </div>

  <div class="ui flowing basic admission popup" id="i_assignee_popup">
    <h4>Assignees</h4>
    <div class="ui multiple search selection dropdown" id="i_assignee">
      <input type="hidden">
      <i class="dropdown icon"></i>
      <input type="text" class="search">
      <div class="default text">Select a user...</div>
    </div>
  </div>


</div>

<br />

<div class="ui two column stackable divided grid">
  <div class="ten wide column">
    <div class="ui">
       Content<br />Content<br />Content<br />Content<br />Content<br />
       Content<br />Content<br />Content<br />Content<br />Content<br />
       Content<br />Content<br />Content<br />Content<br />Content<br />
       Content<br />Content<br />Content<br />Content<br />Content<br />
       Content<br />Content<br />Content<br />Content<br />Content<br />
       Content<br />Content<br />Content<br />Content<br />Content<br />
       Content<br />Content<br />Content<br />Content<br />Content<br />
       Content<br />Content<br />Content<br />Content<br />Content<br />
     </div>
  </div>
  <div class="six wide column">
    <div class="ui">Content</div>
  </div>
</div>

<script type="text/javascript">
$("#i_main .dropdown[dropdown]").dropdown();
$("#i_main #i_assignee").each(function(index, value) {
  console.log("hi");
  var n = $(value);
  n.dropdown({
    apiSettings: {
       url: '/rest/users/?search={query}' 
    },
    onChange: function(value, text, choice) {
       console.log("setting new assignees: " + value);
    }
  });
});

</script>

