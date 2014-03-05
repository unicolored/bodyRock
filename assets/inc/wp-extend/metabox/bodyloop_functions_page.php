<?php


	// LEGENDE
	$input = "text";
	if ( strpos($string,"09") ) { $input = "number"; $string = str_replace("09","",$string); }
	if ( strpos($string,"?") ) { $input = "checkbox"; $string = str_replace("?","",$string); }
	if ( strpos($string,"::") ) { $input = "select"; $string = str_replace("::","",$string); }
    if ( strpos($string,":r:") ) { $input = "radio"; $string = str_replace(":r:","",$string); }

	$X = explode( "," , $string );
	$label = trim($X[0]);
	$name = str_replace(" ","",$X[1]);
	
	$form_item = "";
	
	switch ( $input ) {
		default: // Si $input ne correspond à rien, on renvoie une erreur
			$form_item .= '<hr>Erreur, $input est incorrect.<hr>';
		break;

		
		case "text":
			$form_item .= '<label for="'.$name.'">'.$label.'</label> ';
			$form_item .= '<input id="'.$name.'" name="'.$name.'" type="text" value="'.(isset($instance[$name]) && $instance[$name]!=false ? $instance[$name] : getDefaultLoop($name)).'" />';
		break;
		
		case "number":
			$form_item .= '<label for="'.$name.'">'.$label.'</label> ';
			$form_item .= '<input id="'.$name.'" name="'.$name.'" type="number" value="'.(isset($instance[$name]) && $instance[$name]!=false ? $instance[$name] : getDefaultLoop($name)).'" size="5" />';
		break;
		
		case "select":
			$form_item .= '<label for="'.$name.'">'.$label.'</label> ';
			if($options == false) { $options = "Options manquantes."; }
			$O = explode(";",$options);
			
			$form_item .= '<select name="'.$name.'" id="'.$name.'">';
				foreach($O as $res) {
					$X = explode(",",$res);
					$form_item .= '<option value="'.$X[1].'" '.(isset($instance[$name]) ? selected( $instance[$name], $X[1],false ) : selected( getDefaultLoop($name), $X[1],false )).'>'.$X[0].'</option>';
				}
			$form_item .= '</select>';
		break;
		
		case "checkbox": 
			if ( strpos($name,"()") ) {
				$name = str_replace("()","",$name);
				$resultats = getOptions($name);
//				$form_item .= '<h4>'.$label.'</h4>';
				foreach($resultats as $R) {
					$form_item .= '<input type="checkbox" class="checkbox" name="'.$name.'_'.$R->term_id.'" '.checked( (bool) $instance[$name.'_'.$R->term_id], true,false ).' id="'.$name.'_'.$R->term_id.'" />';
					$form_item .= '<label for="'.$name.'_'.$R->term_id.'">'.$R->name.'</label> ';
				}
			}
			else {
				$form_item .= '<input type="checkbox" class="checkbox" id="'.$name.'" name="'.$name.'" '.checked( (bool) $instance[$name], true,false ).' />';
				$form_item .= '<label for="'.$name.'">'.$label.'</label> ';
			}
		break;
        
        case "radio": 
            if ( strpos($name,"()") ) {
                $name = str_replace("()","",$name);
                $resultats = getOptions($name);
//              $form_item .= '<h4>'.$label.'</h4>';
                foreach($resultats as $R) {
                    $form_item .= '<input type="checkbox" class="checkbox" name="'.$name.'_'.$R->term_id.'" '.checked( (bool) $instance[$name.'_'.$R->term_id], true,false ).' id="'.$name.'_'.$R->term_id.'" />';
                    $form_item .= '<label for="'.$name.'_'.$R->term_id.'">'.$R->name.'</label> ';
                }
            }
            else {
                $form_item .= '<input type="checkbox" class="checkbox" id="'.$name.'" name="'.$name.'" '.checked( (bool) $instance[$name], true,false ).' />';
                $form_item .= '<label for="'.$name.'">'.$label.'</label> ';
            }
        break;
	}
	

?>