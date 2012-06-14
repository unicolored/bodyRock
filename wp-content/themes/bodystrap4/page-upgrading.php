<?php
/*
Template Name: Upgrading
*/
get_header() ?>



<!-- Masthead
================================================== -->
<header class="jumbotron subhead" id="overview">
  <h1>Upgrading to Bootstrap 2</h1>
  <p class="lead">Learn about significant changes and additions since v1.4 with this handy guide.</p>
</header>



<!-- Project
================================================== -->
<section id="docs">
  <div class="page-header">
    <h1>Project changes</h1>
  </div>
  <ul>
    <li>Docs: major updates across the board to general structure, examples, and code snippets. Also made responsive with new media queries.</li>
    <li>Docs: all docs pages are now powered by Mustache templates and strings are wrapped in i18n tags for translation by the Twitter Translation Center. All changes to documentation must be done here and then compiled (similar to our CSS and LESS).</li>
    <li>Repo directory structure: removed the compiled CSS from the root in favor of a large direct download link on the docs homepage. Compiled CSS is in <code>/docs/assets/css/</code>.</li>
    <li>Docs and repo: one makefile, just type <code>make</code> in the Terminal and get updated docs and CSS.</li>
  </ul>
</section>



<!-- Scaffolding
================================================== -->
<section id="scaffolding">
  <div class="page-header">
    <h1>Scaffolding</h1>
  </div>
  <h3>Grid system</h3>
  <ul>
    <li>Updated grid system, now only 12 columns instead of 16
    <li>Responsive approach means your projects virtually work out of the box on smartphones, tablets, and more</li>
    <li>Removed unused (by default) grid columns support for 17-24 columns</li>
  </ul>
  <h3>Responsive (media queries)</h3>
  <ul>
    <li>Media queries added for <strong>basic support</strong> across mobile and tablet devices
    <li>Responsive CSS is compiled separately, as bootstrap-responsive.css</li>
  </ul>
</section>



<!-- Base CSS
================================================== -->
<section id="baseCSS">
  <div class="page-header">
    <h1>Base CSS</h1>
  </div>
  <h3>Typography</h3>
  <ul>
    <li><code>h4</code> elements were dropped from 16px to 14px with a default <code>line-height</code> of 18px</li>
    <li><code>h5</code> elements were dropped from 14px to 12px</li>
    <li><code>h6</code> elements were dropped from 13px to 11px</li>
    <li>Right-aligned option for blockquotes if <code>float: right;</code></li>
  </ul>
  <h3>Code</h3>
  <ul>
    <li>New graphical style for <code>&lt;code&gt;</code></li>
    <li>Google Code Prettify styles updated (based on GitHub's gists)</li>
  </ul>
  <h3>Tables</h3>
  <ul>
    <li>Improved support for <code>colspan</code> and <code>rowspan</code></li>
    <li>Styles now restricted to new base class, <code>.table</code></li>
    <li>Table classes standardized with <code>.table-</code> required as a prefix</li>
    <li>Removed unused table color options (too much code for such little impact)</li>
    <li>Dropped support for TableSorter</li>
  </ul>
  <h3>Buttons</h3>
  <ul>
    <li>New classes for colors and sizes, all prefixed with <code>.btn-</code></li>
    <li>IE9: removed gradients and added rounded corners</li>
    <li>Updated active state to make styling clearer in button groups (new) and look better with custom transition</li>
    <li>New mixin, <code>.buttonBackground</code>, to set button gradients</li>
    <li>The <code>.secondary</code> class was removed from modal examples in our docs as it never had associated styles.</li>
  </ul>
  <h3>Forms</h3>
  <ul>
    <li>Default form style is now vertical (stacked) to use less CSS and add greater flexibility</li>
    <li>Form classes standardized with <code>.form-</code> required as a prefix</li>
    <li>New built-in form defaults for search, inline, and horizontal forms</li>
    <li>For horizontal forms, previous classes <code>.clearfix</code> and <code>.input</code> are equivalent to the new <code>.control-group</code> and <code>.controls</code>.</li>
    <li>More flexible horizontal form markup with classes for all styling, including new optional class for the <code>label</code></li>
    <li>Form states: colors updated and customizable via new LESS variables</li>
  </ul>
  <h3>Icons, by Glyphicons</h3>
  <ul>
    <li>New Glyphicons Halflings icon set added in sprite form, in black and white</li>
    <li>Simple markup required for an icon in tons of contexts: <code>&lt;i class="icon-cog"&gt;&lt;/&gt;</code></li>
    <li>Add another class, <code>.icon-white</code>, for white variation of the same icon</li>
  </ul>
</section>



<!-- Components
================================================== -->
<section id="components">
  <div class="page-header">
    <h1>Components</h1>
  </div>
  <h3>Button groups and dropdowns</h3>
  <ul>
    <li>Two brand new components in 2.0: button groups and button dropdowns</li>
    <li>Dependency: button dropdowns are built on button groups, and therefore require all their styles</li>
    <li>Button groups, <code>.btn-group</code>, can be grouped one level higher with a button toolbar, <code>.btn-toolbar</code></li>
  </ul>
  <h3>Navigation</h3>
  <ul>
    <li>Tabs and pills now require the use of a new base class, <code>.nav</code>, on their <code>&lt;ul&gt;</code> and the class names are now <code>.nav-pills</code> and <code>.nav-tabs</code>.</li>
    <li>New nav list variation added that uses the same base class, <code>.nav</code></li>
    <li>Vertical tabs and pills have been added&mdash;just add <code>.nav-stacked</code> to the <code>&lt;ul&gt;</code></li>
    <li>Pills were restyled to be less rounded by default</li>
    <li>Pills now have dropdown menu support (they share the same markup and styles as tabs)</li>
  </ul>
  <h3>Navbar (formerly topbar)</h3>
  <ul>
    <li>Base class changed from <code>.topbar</code> to <code>.navbar</code></li>
    <li>Now supports static position (default behavior, not fixed) and fixed to the top of viewport via <code>.navbar-fixed-top</code> (previously only supported fixed)</li>
    <li>Added vertical dividers to top-level nav</li>
    <li>Improved support for inline forms in the navbar, which now require <code>.navbar-form</code> to properly scope styles to only the intended forms.</li>
    <li>Navbar search form now requires use of the <code>.navbar-search</code> class and its input the use of <code>.search-query</code>. To position the search form, you <strong>must</strong> use <code>.pull-left</code> or <code>.pull-right</code>.</li>
    <li>Added optional responsive markup for collapsing navbar contents for smaller resolutions and devices. <a href="./components.html#navbar">See navbar docs</a> for how to utilize.</li>
  </ul>
  <h3>Dropdown menus</h3>
  <ul>
    <li>Updated the <code>.dropdown-menu</code> to tighten up spacing</li>
    <li>Now requires you to add a <code>&lt;span class="caret"&gt;&lt;/span&gt;</code> to show the dropdown arrow</li>
    <li>Now requires you to add a <code>data-toggle="dropdown"</code> attribute to obtain toggling behavior</li>
    <li>The navbar (fixed topbar) has brand new dropdowns. Gone are the dark versions and in their place are the standard white ones with an additional caret at their tops for clarity of position.</li>
  </ul>
  <h3>Labels</h3>
  <ul>
    <li>Label colors updated to match form state colors</li>
    <li>Not only do they match graphically, but they are powered by the same new variables</li>
  </ul>
  <h3>Thumbnails</h3>
  <ul>
    <li>Formerly <code>.media-grid</code>, now just <code>.thumbnails</code>, we've thoroughly extended this component for more uses while maintaining overall simplicity out of the box.</li>
    <li>Individual thumbnails now require <code>.thumbnail</code> class</li>
  </ul>
  <h3>Alerts</h3>
  <ul>
    <li>New base class: <code>.alert</code> instead of <code>.alert-message</code></li>
    <li>Class names standardized for other options, now all starting with <code>.alert-</code></li>
    <li>Redesigned base alert styles to combine the default alerts and block-level alerts into one</li>
    <li>Block level alert class changed: <code>.alert-block</code> instead of <code>.block-message</code></li>
  </ul>
  <h3>Progress bars</h3>
  <ul>
    <li>New in 2.0</li>
    <li>Features multiple styles via classes, including striped and animated variations via CSS3</li>
  </ul>
  <h3>Miscellaneous components</h3>
  <ul>
    <li>Added documentation for the well component and the close icon (used in modals and alerts)</li>
  </ul>
</section>



<!-- Javascript
================================================== -->
<section id="javascript">
  <div class="page-header">
    <h1>Javascript plugins</h1>
  </div>
  <div class="alert alert-info">
    <strong>Heads up!</strong> We've rewritten just about everything for our plugins, so head on over to <a href="./javascript.html">the Javascript page</a> to learn more.
  </div>
  <h3>Tooltips</h3>
  <ul>
    <li>The plugin method has been renamed from <code>twipsy()</code> to <code>tooltip()</code>, and the class name changed from <code>twipsy</code> to <code>tooltip</code>.</li>
    <li>The <code>placement</code> option value that was <code>below</code> is now <code>bottom</code>, and <code>above</code> is now <code>top</code>.</li>
    <li>The <code>animate</code> option was renamed to <code>animation</code>.</li>
    <li>The <code>html</code> option was removed, as the tooltips default to allowing HTML now.</li>
  </ul>
  <h3>Popovers</h3>
  <ul>
    <li>Child elements now properly namespaced: <code>.title</code> to <code>.popover-title</code>, <code>.inner</code> to <code>.popover-inner</code>, and <code>.content</code> to <code>.popover-content</code>.</li>
    <li>The <code>placement</code> option value that was <code>below</code> is now <code>bottom</code>, and <code>above</code> is now <code>top</code>.</li>
  </ul>
  <h3>New plugins</h3>
  <ul>
    <li><a href="./javascript.html#collapse">Collapse</a></li>
    <li><a href="./javascript.html#carousel">Carousel</a></li>
    <li><a href="./javascript.html#typeahead">Typeahead</a></li>
  </ul>
</section>

<?php
get_footer();
?>
