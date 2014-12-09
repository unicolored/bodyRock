<?php
// Adding a Custom Taxonomy
register_taxonomy("lieu-type", array("lieux"), array("hierarchical" => true, "label" => "Genres de lieux", "singular_label" => "Genre de lieu", "rewrite" => true));
register_taxonomy("lieu-cat", array("lieux"), array("hierarchical" => true, "label" => "Catégories de lieux", "singular_label" => "Catégorie de lieu", "rewrite" => true));
register_taxonomy("lieu-tag", array("lieux"), array("hierarchical" => false, "label" => "Tags de lieux", "singular_label" => "Tag de lieu", "rewrite" => true));
?>