<div class="ui masthead vertical segment">
  <h1 class="ui header"><img class="ui circular image" src="/assets/project-icons/erlenmeyer-flask.png" /> a big fat problem ticket</h1>
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
      <input type="hidden" name="assignees" />
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
       <div class="isitirio_basics">
         <div class="ui two column grid">
           <div class="row">
             <div class="column">
               <div class="ui two column grid">
                 <div class="row">
                   <div class="column">
                     <b>Type</b>
                   </div>
                   <div class="column">
                     <a class="ui image label">
                       <img src="/assets/tickettype-icons/problem.png">
                       IT Incident
                     </a>
                   </div>
                 </div>
               </div>
             </div>
             <div class="column">
               <div class="ui two column grid">
                 <div class="row">
                   <div class="column">
                     <b>Status</b>
                   </div>
                   <div class="column">
                     <a class="ui yellow image label">Open</a>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <div class="row">
             <div class="column">
               <div class="ui two column grid">
                 <div class="row">
                   <div class="column">
                     <b>Labels</b>
                   </div>
                   <div class="column">
                     <p class="ui tag label" style="margin-bottom:2px;">UEP Resolved</p>
                     <p class="ui tag label" style="margin-bottom:2px;">incident</p>
                   </div>
                 </div>
               </div>
             </div>
             <div class="column">
               <div class="ui two column grid">
                 <div class="row">
                   <div class="column">
                     <b>Priority</b>
                   </div>
                   <div class="column">
                     <p>Normal</p>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>

       <div class="ui horizontal divider">Description</div>
       <div class="isitirio_description">
         Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content<br />
         Content<br />Content<br />Content<br />Content<br />Content<br />
         Content<br />Content<br />Content<br />Content<br />Content<br />
         Content<br />Content<br />Content<br />Content<br />Content<br />
         Content<br />Content<br />Content<br />Content<br />Content<br />
         Content<br />Content<br />Content<br />Content<br />Content<br />
         Content<br />Content<br />Content<br />Content<br />Content<br />
         Content<br />Content<br />Content<br />Content<br />Content<br />
       </div>
     </div>
  </div>
  <div class="six wide column">
    <div class="ui">
      <div class="isitirio_persons">


       <div class="ui two column grid">
          <div class="row">
            <div class="column">
              <b>Created</b>
            </div>
            <div class="column">
              2017-12-12 12:12:00
            </div>
          </div>
          <div class="row">
            <div class="column">
              <b>Updated</b>
            </div>
            <div class="column">
              2017-12-14 14:14:00
            </div>
          </div>
        </div>
        <div class="ui two column grid">
          <div class="row">
            <div class="column">
               <div class="ui segments">
                 <div class="ui olive segment">
                   <b>Assignees</b>
                 </div>
                 <div class="ui segment" id="i_assignee_list">
                 </div>
               </div>
            </div>
            <div class="column">
               <div class="ui segments">
                 <div class="ui teal segment">
                   <b>Reporters</b>
                 </div>
                 <div class="ui segment">
                   <p><img class="ui avatar image" src="/semanticui/chris.jpg"><span>Chris Mastermind</span></p>
                 </div>
               </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="ui top attached tabular menu">
  <div class="item">Comment</div>
  <div class="active item">Comment</div>
</div>
<div class="ui bottom attached active tab segment">
  <p></p>
  <p></p>
</div>

<script type="text/javascript">
$("#i_main .dropdown[dropdown]").dropdown();
$("#i_main #i_assignee").each(function(index, value) {
  var initialized = false;
  var n = $(value);
  n.dropdown({
    values: [
      { name: '<img class="ui avatar image" src="/semanticui/john.jpg" /> John Doe', value: 'usr01', selected:true }
    ],
    apiSettings: {
       url: '/rest/users/?search={query}' 
    },
    saveRemoteData: false,
    onChange: function(value, text, choice) {
      if(initialized) {
         console.log("setting new assignees: " + value);
      }
      // updating the assignees
      setTimeout(function() {
        var ahtml = '';
        $("#i_assignee > .ui.label[data-value]").each(function(i, v) {
          ahtml += '<p>' + $(v).html().replace(/<i class="delete icon"><\/i>/g, '') + '</p>';
        });
        if(ahtml=='') {
          $('#i_assignee_list').html('<i>Unassigned</i>');
        }
        else {
          $('#i_assignee_list').html(ahtml);
        }
      }, 800);
    }
  });
  // mark as initialized
  setTimeout(function() { initialized = true; }, 800);
});

</script>

