<?php
// Adding a Custom Taxonomy
register_taxonomy(
	"lieu-type",
	array("lieux"),
	array("hierarchical" => true,
	"label" => "Types de lieux",
	"singular_label" => "Type de lieu",
	"rewrite" => true));

?>
