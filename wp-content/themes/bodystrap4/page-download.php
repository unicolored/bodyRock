<?php
/*
Template Name: Download
*/
get_header() ?>

<!-- Masthead
================================================== -->
<header class="jumbotron subhead" id="overview">
  <h1>Customize and download</h1>
  <p class="lead"><a href="https://github.com/twitter/bootstrap/zipball/master">Download the full repository</a> or customize your entire Bootstrap build by selecting only the components, javascript plugins, and assets you need.</p>
  <div class="subnav">
    <ul class="nav nav-pills">
      <li><a href="#components">1. Choose components</a></li>
      <li><a href="#plugins">2. Select jQuery plugins</a></li>
      <li><a href="#variables">3. Customize variables</a></li>
      <li><a href="#download">4. Download</a></li>
    </ul>
  </div>
</header>

<section class="download" id="components">
  <div class="page-header">
    <a class="btn btn-small pull-right toggle-all" href="#">Toggle all</a>
    <h1>
      1. Choose components
      <small>Get just the CSS you need</small>
    </h1>
  </div>
  <div class="row download-builder">
    <div class="span3">
      <h3>Scaffolding</h3>
      <label class="checkbox"><input checked="checked" type="checkbox" value="reset.less"> Normalize and reset</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="scaffolding.less"> Body type and links</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="grid.less"> Grid system</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="layouts.less"> Layouts</label>
      <h3>Base CSS</h3>
      <label class="checkbox"><input checked="checked" type="checkbox" value="type.less"> Headings, body, etc</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="code.less"> Code and pre</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="labels.less"> Labels</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="badges.less"> Badges</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="tables.less"> Tables</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="forms.less"> Forms</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="buttons.less"> Buttons</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="sprites.less"> Icons</label>
    </div><!-- /span -->
    <div class="span3">
      <h3>Components</h3>
      <label class="checkbox"><input checked="checked" type="checkbox" value="button-groups.less"> Button groups and dropdowns</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="navs.less"> Navs, tabs, and pills</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="navbar.less"> Navbar</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="breadcrumbs.less"> Breadcrumbs</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="pagination.less"> Pagination</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="pager.less"> Pager</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="thumbnails.less"> Thumbnails</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="alerts.less"> Alerts</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="progress-bars.less"> Progress bars</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="hero-unit.less"> Hero unit</label>
    </div><!-- /span -->
    <div class="span3">
      <h3>JS Components</h3>
      <label class="checkbox"><input checked="checked" type="checkbox" value="tooltip.less"> Tooltips</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="popovers.less"> Popovers</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="modals.less"> Modals</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="dropdowns.less"> Dropdowns</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="accordion.less"> Collapse</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="carousel.less"> Carousel</label>
    </div><!-- /span -->
    <div class="span3">
      <h3>Miscellaneous</h3>
      <label class="checkbox"><input checked="checked" type="checkbox" value="wells.less"> Wells</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="close.less"> Close icon</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="utilities.less"> Utilities</label>
      <label class="checkbox"><input checked="checked" type="checkbox" value="component-animations.less"> Component animations</label>
      <h3>Responsive</h3>
      <label class="checkbox"><input checked="checked" type="checkbox" value="responsive.less"> Responsive layouts</label>
    </div><!-- /span -->
  </div><!-- /row -->
</section>

<section class="download" id="plugins">
  <div class="page-header">
    <a class="btn btn-small pull-right toggle-all" href="#">Toggle all</a>
    <h1>
      2. Select jQuery plugins
      <small>Quickly add only the necessary javascript</small>
    </h1>
  </div>
  <div class="row download-builder">
    <div class="span4">
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-transition.js">
        Transitions <small>(required for any animation)</small>
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-modal.js">
        Modals
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-dropdown.js">
        Dropdowns
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-scrollspy.js">
        Scrollspy
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-tab.js">
        Togglable tabs
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-tooltip.js">
        Tooltips
      </label>
    </div><!-- /span -->
    <div class="span4">
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-popover.js">
        Popovers <small>(requires Tooltips)</small>
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-alert.js">
        Alert messages
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-button.js">
        Buttons
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-collapse.js">
        Collapse
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-carousel.js">
        Carousel
      </label>
      <label class="checkbox">
        <input type="checkbox" checked="true" value="bootstrap-typeahead.js">
        Typeahead
      </label>
    </div><!-- /span -->
    <div class="span4">
      <h4 class="muted">Heads up!</h4>
      <p class="muted">All checked plugins will be compiled into a single file, bootstrap.js. All plugins require the latest version of <a href="http://jquery.com/" target="_blank">jQuery</a> to be included.</p>
    </div><!-- /span -->
  </div><!-- /row -->
</section>


<section class="download" id="variables">
  <div class="page-header">
    <a class="btn btn-small pull-right toggle-all" href="#">Reset to defaults</a>
    <h1>
      3. Customize variables
      <small>Optionally modify Bootstrap without a compiler</small>
    </h1>
  </div>
  <div class="row download-builder">
    <div class="span3">
      <h3>Scaffolding</h3>
      <label>@bodyBackground</label>
      <input type="text" class="span3" placeholder="@white">
      <label>@textColor</label>
      <input type="text" class="span3" placeholder="@grayDark">

      <h3>Links</h3>
      <label>@linkColor</label>
      <input type="text" class="span3" placeholder="#08c">
      <label>@linkColorHover</label>
      <input type="text" class="span3" placeholder="darken(@linkColor, 15%)">
      <h3>Colors</h3>
      <label>@blue</label>
      <input type="text" class="span3" placeholder="#049cdb">
      <label>@green</label>
      <input type="text" class="span3" placeholder="#46a546">
      <label>@red</label>
      <input type="text" class="span3" placeholder="#9d261d">
      <label>@yellow</label>
      <input type="text" class="span3" placeholder="#ffc40d">
      <label>@orange</label>
      <input type="text" class="span3" placeholder="#f89406">
      <label>@pink</label>
      <input type="text" class="span3" placeholder="#c3325f">
      <label>@purple</label>
      <input type="text" class="span3" placeholder="#7a43b6">

      <h3>Sprites</h3>
      <label>@iconSpritePath</label>
      <input type="text" class="span3" placeholder="'../img/glyphicons-halflings.png'">
      <label>@iconWhiteSpritePath</label>
      <input type="text" class="span3" placeholder="'../img/glyphicons-halflings-white.png'">

    </div><!-- /span -->
    <div class="span3">
      <h3>Grid system</h3>
      <label>@gridColumns</label>
      <input type="text" class="span3" placeholder="12">
      <label>@gridColumnWidth</label>
      <input type="text" class="span3" placeholder="60px">
      <label>@gridGutterWidth</label>
      <input type="text" class="span3" placeholder="20px">
      <h3>Fluid grid system</h3>
      <label>@fluidGridColumnWidth</label>
      <input type="text" class="span3" placeholder="6.382978723%">
      <label>@fluidGridGutterWidth</label>
      <input type="text" class="span3" placeholder="2.127659574%">

      <h3>Typography</h3>
      <label>@baseFontSize</label>
      <input type="text" class="span3" placeholder="13px">
      <label>@baseFontFamily</label>
      <input type="text" class="span3" placeholder="'Helvetica Neue', Helvetica, Arial, sans-serif">
      <label>@baseLineHeight</label>
      <input type="text" class="span3" placeholder="18px">
      <label>@altFontFamily</label>
      <input type="text" class="span3" placeholder="Georgia, 'Times New Roman', Times, serif;">
      <label>@headingsFontFamily</label>
      <input type="text" class="span3" placeholder="inherit">
      <label>@headingsFontWeight</label>
      <input type="text" class="span3" placeholder="bold">
      <label>@headingsColor</label>
      <input type="text" class="span3" placeholder="inherit">
      <label>@heroUnitBackground</label>
      <input type="text" class="span3" placeholder="@grayLighter">
      <label>@heroUnitHeadingColor</label>
      <input type="text" class="span3" placeholder="inherit">
      <label>@heroUnitLeadColor</label>
      <input type="text" class="span3" placeholder="inherit">
    </div><!-- /span -->
    <div class="span3">
      <h3>Tables</h3>
      <label>@tableBackground</label>
      <input type="text" class="span3" placeholder="transparent">
      <label>@tableBackgroundAccent</label>
      <input type="text" class="span3" placeholder="#f9f9f9">
      <label>@tableBackgroundHover</label>
      <input type="text" class="span3" placeholder="#f5f5f5">
      <label>@tableBorder</label>
      <input type="text" class="span3" placeholder="#ddd">

      <h3>Navbar</h3>
      <label>@navbarHeight</label>
      <input type="text" class="span3" placeholder="40px">
      <label>@navbarBackground</label>
      <input type="text" class="span3" placeholder="@grayDarker">
      <label>@navbarBackgroundHighlight</label>
      <input type="text" class="span3" placeholder="@grayDark">
      <label>@navbarText</label>
      <input type="text" class="span3" placeholder="@grayLight">
      <label>@navbarLinkColor</label>
      <input type="text" class="span3" placeholder="@grayLight">
      <label>@navbarLinkColorHover</label>
      <input type="text" class="span3" placeholder="@white">
      <label>@navbarLinkColorActive</label>
      <input type="text" class="span3" placeholder="@navbarLinkColorHover">
      <label>@navbarLinkBackgroundHover</label>
      <input type="text" class="span3" placeholder="transparent">
      <label>@navbarLinkBackgroundActive</label>
      <input type="text" class="span3" placeholder="@navbarBackground">
      <label>@navbarSearchBackground</label>
      <input type="text" class="span3" placeholder="lighten(@navbarBackground, 25%)">
      <label>@navbarSearchBackgroundFocus</label>
      <input type="text" class="span3" placeholder="@white">
      <label>@navbarSearchBorder</label>
      <input type="text" class="span3" placeholder="darken(@navbarSearchBackground, 30%)">
      <label>@navbarSearchPlaceholderColor</label>
      <input type="text" class="span3" placeholder="#ccc">

      <h3>Dropdowns</h3>
      <label>@dropdownBackground</label>
      <input type="text" class="span3" placeholder="@white">
      <label>@dropdownBorder</label>
      <input type="text" class="span3" placeholder="rgba(0,0,0,.2)">
      <label>@dropdownLinkColor</label>
      <input type="text" class="span3" placeholder="@grayDark">
      <label>@dropdownLinkColorHover</label>
      <input type="text" class="span3" placeholder="@white">
      <label>@dropdownLinkBackgroundHover</label>
      <input type="text" class="span3" placeholder="@linkColor">
    </div><!-- /span -->
    <div class="span3">
      <h3>Forms</h3>
      <label>@placeholderText</label>
      <input type="text" class="span3" placeholder="@grayLight">
      <label>@inputBackground</label>
      <input type="text" class="span3" placeholder="@white">
      <label>@inputBorder</label>
      <input type="text" class="span3" placeholder="#ccc">
      <label>@inputDisabledBackground</label>
      <input type="text" class="span3" placeholder="@grayLighter">

      <label>@btnPrimaryBackground</label>
      <input type="text" class="span3" placeholder="@linkColor">
      <label>@btnPrimaryBackgroundHighlight</label>
      <input type="text" class="span3" placeholder="darken(@white, 10%);">

      <h3>Form states &amp; alerts</h3>
      <label>@warningText</label>
      <input type="text" class="span3" placeholder="#c09853">
      <label>@warningBackground</label>
      <input type="text" class="span3" placeholder="#fcf8e3">
      <label>@errorText</label>
      <input type="text" class="span3" placeholder="#b94a48">
      <label>@errorBackground</label>
      <input type="text" class="span3" placeholder="#f2dede">
      <label>@successText</label>
      <input type="text" class="span3" placeholder="#468847">
      <label>@successBackground</label>
      <input type="text" class="span3" placeholder="#dff0d8">
      <label>@infoText</label>
      <input type="text" class="span3" placeholder="#3a87ad">
      <label>@infoBackground</label>
      <input type="text" class="span3" placeholder="#d9edf7">
    </div><!-- /span -->
  </div><!-- /row -->
</section>

<section class="download" id="download">
  <div class="page-header">
    <h1>
      4. Download
    </h1>
  </div>
  <div class="download-btn">
    <a class="btn btn-primary" href="#">Customize and Download</a>
    <h4>What's included?</h4>
    <p>Downloads include compiled CSS, compiled and minified CSS, and compiled jQuery plugins, all nicely packed up into a zipball for your convenience.</p>
  </div>
</section><!-- /download -->
<?php get_footer() ?>
