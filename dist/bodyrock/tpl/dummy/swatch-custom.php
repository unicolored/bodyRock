<div class="col-xs-12">
  <?php
  $swatches = array('gray-color','bg','contrast','brand-primary','brand-info','brand-success','brand-warning','brand-danger');
  foreach($swatches as $swatch) {
    for ($i=4;$i<=4;$i++) {
      print '<span id="'.$swatch.'-'.$i.'" class="br_color_cube">'.$swatch.'</span>';
    }
  }
  ?>
</div>
<div class="col-xs-12">
  <?php
  $swatches = array('gray-color','bg','contrast','brand-primary','brand-info','brand-success','brand-warning','brand-danger');
  foreach($swatches as $swatch) {
    for ($i=2;$i<=2;$i++) {
      print '<h1 id="'.$swatch.'-'.$i.'" class="br_color_cube" style="background:none; width:auto;">'.ucfirst($swatch).'</h1>';
      //print '<span id="'.$swatch.'-'.$i.'">'.$swatch.'</span>';
    }
  }
  ?>
</div>
<div class="col-xs-6">
  <?php
  $swatches = array('gray-color','bg','contrast','brand-primary');
  foreach($swatches as $swatch) {
    print "<h1>".ucfirst($swatch)."</h1>";
    for ($i=2;$i<=6;$i++) {
      print '<span id="'.$swatch.'-'.$i.'" class="br_color_cube">'.$swatch.' '.$i.'</span>';
    }
  }
  ?>
</div>
<div class="col-xs-6">
  <?php
  $swatches = array('brand-info','brand-success','brand-warning','brand-danger');
  foreach($swatches as $swatch) {
    print "<h1>".ucfirst($swatch)."</h1>";
    for ($i=2;$i<=6;$i++) {
      print '<span id="'.$swatch.'-'.$i.'" class="br_color_cube">'.$swatch.' '.$i.'</span>';
    }
  }
  ?>
</div>
<hr class="clear">
