<?php
$output = '';
//catalogue starts at #id = 36360
$result = $modx->db->query("SELECT sc.id, sc.pagetitle, sc.alias, sctv.contentid, sctv.tmplvarid, sctv.value FROM `modx_site_content` AS sc INNER JOIN `modx_site_tmplvar_contentvalues` AS sctv ON sc.id = sctv.contentid WHERE sc.parent = 36360 AND sc.pagetitle <> '' AND sctv.value <> '' LIMIT 0 , 330000");
$cnt=0;
$data = array();
while( $row = $modx->db->getRow( $result ) ) {	
  if(!array_key_exists($row['id'], $data)) $data[$row['id']] = array();     	
  switch ($row['tmplvarid']) {
    case 6:
	  $data[$row['id']]['price'] = $row['value'];  
        break;
	 case 7:
	  $data[$row['id']]['vendorcode'] = $row['value'];  
	  break;
     case 23:
        $data[$row['id']]['picture'] = $row['value']; 
        break;
	case 18:
        $data[$row['id']]['description'] = $row['value']; 
        break;
  }
  $data[$row['id']]['pagetitle'] = strip_tags($row['pagetitle']); 
  $cnt++;	
}
 
foreach($data as $datakey=>$dataValue){
	if(round(str_replace(',','.',$dataValue['price']),2) > 0){	
    $chunkArr = array(
		'id' => $datakey,
		'price' => round(str_replace(',','.',$dataValue['price']),2),
		'picture' => ($dataValue['picture'] == '' ? 'files/foto_item/no_foto.jpg': $dataValue['picture']),
		'introtext' => $dataValue['description'],
		'vendorcode' => $dataValue['vendorcode'],
		'pagetitle' => $dataValue['pagetitle'],
		'parent' => 1,
	);
	$output .= $modx->parseChunk('yml_tpl', $chunkArr, '[+', '+]');
	}		
}
echo $output;
?>