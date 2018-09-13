<?


/**********************************************************************
*  PHP Perfect Form Items v1.0				by Jose Carlos Garc�a Neila
* ----------------------------------------------------------------------
*  Construye formularios mediante c�digo PHP para separar de forma clara
*  la l�gica de programaci�n con la l�gica de dise�o
*   � Para m�s informaci�n se acompa�ana documentaci�n en PDF 
*	
*  Modifique el c�digo a su gusto si lo desea y distribuyalo sin problema
*  ninguno, aunque si le pedir�a que incluya intacto este encabezado.
* 
*  http://www.distintiva.com/jose/_perf_form
************************************************************************/


//- Funciones auxiliares--------------------------------------------------------
function walk_tolower(&$val){
	$val=strtolower($val);
}
function array_lower($a_arr){
	array_walk($a_arr, 'walk_tolower');
	return $a_arr;
}


//- Funciones de abstracci�n de formularios -------------------------------------

//=CREA UN SELECT= en base a un array de textos y valores de misma dimension
// $default puede ser 1texto ( o un array) de valor/es que estar�n seleccionado/s
// $extra_tag se a�adir� al select:  ej: "class='frm' onclick=alert('')"
function frm_datalist($name, $arr_txt, $arr_vals, $label='', $default='', $extra_tag=''){
	$tmp="<label>$label";
	$tmp.="<input id='$name' type='text' name='$name' list='list_$name' $extra_tag />";
	$tmp.="<datalist id='list_$name'>";
	$items=count($arr_txt[$name]);
	if($items!=count($arr_vals[$name])) return $tmp."<option>ERR! en el array de valores</select>";
	for($i=0;$i<$items;$i++){
		$sel=' selected';
		$val=$arr_txt[$name][$i];
		if(is_array($default)){
			if(!in_array( strtolower($val), array_lower($default) )) $sel='';
		}else{
			if(!eregi($val,$default)) $sel='';
		}
		$tmp.="<option value='$val'$sel/>".$arr_vals[$name][$i]."</option>";
	}
	return $tmp.'</datalist></label>';
}

function frm_datalist2($name, $arr_txt, $arr_vals, $label='', $default='', $extra_tag=''){
	
	$tmp="<input id='$name' type='text' name='$name' list='list_$name' $extra_tag />";
	$tmp.="<datalist id='list_$name'>";
	$items=count($arr_txt[$name]);
	if($items!=count($arr_vals[$name])) return $tmp."<option>ERR! en el array de valores</select>";
	for($i=0;$i<$items;$i++){
		$sel=' selected';
		$val=$arr_txt[$name][$i];
		if(is_array($default)){
			if(!in_array( strtolower($val), array_lower($default) )) $sel='';
		}else{
			if(!eregi($val,$default)) $sel='';
		}
		$tmp.="<option value='$val'$sel/>".$arr_vals[$name][$i]."</option>";
	}
	return $tmp.'</datalist>';
}


function frm_select($name, $arr_txt, $arr_vals, $default='', $extra_tag=''){
	$tmp="<select name='$name' $extra_tag>";
	$items=count($arr_txt[$name]);
	if($items!=count($arr_vals[$name])) return $tmp."<option>ERR! en el array de valores</select>";
	for($i=0;$i<$items;$i++){
		$sel=' selected';
		$val=$arr_vals[$name][$i];
		if(is_array($default)){
			if(!in_array( strtolower($val), array_lower($default) )) $sel='';
		}else{
			if(!eregi($val,$default)) $sel='';
		}
		$tmp.="<option value='$val'$sel>".$arr_txt[$name][$i]."</option>";
	}
	return $tmp.'</select>';
}


//=CREA UNA LISTA=  de tama�o visible = $size,  lo dem�s es igual que frm_select
function frm_list($name,$size,  $arr_txt, $arr_vals, $default='', $extra_tag=''){
	return frm_select($name, $arr_txt, $arr_vals, $default, "size=$size $extra_tag");
}

//=CREA UNA LISTA DE SELECCION MULTIPLE=, como valores seleccionados se puede pasar un array
function frm_list_multi($name, $size, $arr_txt, $arr_vals, $default='', $extra_tag=''){
	return frm_list($name."[]", $size, $arr_txt, $arr_vals, $default, "multiple $extra_tag");
}

//=CREA UN CHECKBOX=, Si se le pasa una variable por $var_in y coincide con $ck_val, se selecciona
function frm_check($name, $ck_val, $var_in='', $extra_tag=''){
	$ck='';
	if(strtolower($ck_val)==strtolower($var_in)) $ck=' checked';
	return "<input type=checkbox name='$name' value='$ck_val' $extra_tag $ck>";
}

//=CREA UN RADIO=, Si se le pasa una variable por $var_in y coincide con $ck_val, se selecciona
function frm_radio($name, $val, $var_in='', $extra_tag=''){
	$ck='';
	if(strtolower($val)==strtolower($var_in)) $ck=' checked';
	return "<input type=radio name='$name' value='$val' $extra_tag$ck>";
}

//=CREA UN TEXTBOX=
function frm_text($name, $val, $size, $max_length, $extra_tag=''){
	return "<input type=text name='$name' size='$size' maxlength='$max_length' value='$val' $extra_tag>";
}

//=CREA UN PASSWORD=
function frm_password($name, $val, $size, $max_length, $extra_tag=''){
	return "<input type=password name='$name' size='$size' maxlength='$max_length' value='$val' $extra_tag>";
}


?>