
<ul class="nav nav-tabs nav-justified" id="myTab">
  <li class="active"><a href="#home"><span class="glyphicon glyphicon-heart"></span> Tooltips / Popover</a></li>
  <li class="disabled"><a href="#profile">Disabled</a></li>
  <li><a href="#collapse">Collapse</a></li>

</ul>

<div class="tab-content">
  <div class="tab-pane active" id="home">
  <a href="#" data-toggle="tooltip" title="first tooltip" id="tooltip">Hover over me</a>
  <button class="btn btn-default" id="popover" data-toggle="tooltip" title="first tooltip">Hover over me</button>
</div>
  <div class="tab-pane" id="profile">Disabled profil</div>
  <div class="tab-pane" id="collapse"><?php get_template_part('tpl/bootstrap/collapse'); ?></div>
</div>