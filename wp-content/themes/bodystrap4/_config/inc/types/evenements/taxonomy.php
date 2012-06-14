<?php
// Adding a Custom Taxonomy
register_taxonomy("event-type", array("evenements"), array("hierarchical" => true, "label" => "Genres d'évènements", "singular_label" => "Genre d'évènement", "rewrite" => true));

?>