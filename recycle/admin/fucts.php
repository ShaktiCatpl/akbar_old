<?php
function sanitize_data($input_data) {
	$searchArr=array("document","write","alert","%","@","$",";","+","|","#","<",">",")","(","'","\'",",");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}

function sanitize_search($input_data) {
	$searchArr=array("document","write","alert","%","@","$",";","+","|","#","<",">",")","(","'","\'",",","http://");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}

function sanitize_data_email($input_data) {
	$searchArr=array("document","write","alert","%","$",";","+","|","#","<",">",")","(","'","\'");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}
function sanitize_data_travel($input_data) {
	$searchArr=array("document","write","alert","%",";","+","|","#","<",">",")","(","'","\'");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}
function xml2array($contents, $get_attributes=1, $priority = 'tag')
    {
        if(!$contents) return array();
   
        if(!function_exists('xml_parser_create')) {
            //print "'xml_parser_create()' function not found!";
            return array();
        }
   
        //Get the XML parser of PHP - PHP must have this module for the parser to work
        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xml_values);
        xml_parser_free($parser);
   
        if(!$xml_values) return;//Hmm...
   
        //Initializations
        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();
   
        $current = &$xml_array; //Refference
   
        //Go through the tags.
        $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
        foreach($xml_values as $data) {
            unset($attributes,$value);//Remove existing values, or there will be trouble
   
            //This command will extract these variables into the foreach scope
            // tag(string), type(string), level(int), attributes(array).
            extract($data);//We could use the array by itself, but this cooler.
   
            $result = array();
            $attributes_data = array();
           
            if(isset($value)) {
                if($priority == 'tag') $result = $value;
                else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
            }
   
            //Set the attributes too.
            if(isset($attributes) and $get_attributes) {
                foreach($attributes as $attr => $val) {
                    if($priority == 'tag') $attributes_data[$attr] = $val;
                    else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                }
            }
   
            //See tag status and do the needed.
            if($type == "open") {//The starting of the tag '<tag>'
                $parent[$level-1] = &$current;
                if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                    $current[$tag] = $result;
                    if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
   
                    $current = &$current[$tag];
   
                } else { //There was another element with the same tag name
   
                    if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        $repeated_tag_index[$tag.'_'.$level]++;
                    } else {//This section will make the value an array if multiple tags with the same name appear together
                        $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                        $repeated_tag_index[$tag.'_'.$level] = 2;
                       
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
   
                    }
                    $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                    $current = &$current[$tag][$last_item_index];
                }
   
            } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
                //See if the key is already taken.
                if(!isset($current[$tag])) { //New Key
                    $current[$tag] = $result;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;
   
                } else { //If taken, put all things inside a list(array)
                    if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...
   
                        // ...push the new element into that array.
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                       
                        if($priority == 'tag' and $get_attributes and $attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;
   
                    } else { //If it is not an array...
                        $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                        $repeated_tag_index[$tag.'_'.$level] = 1;
                        if($priority == 'tag' and $get_attributes) {
                            if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                               
                                $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                                unset($current[$tag.'_attr']);
                            }
                           
                            if($attributes_data) {
                                $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                    }
                }
   
            } elseif($type == 'close') { //End of tag '</tag>'
                $current = &$parent[$level-1];
            }
        }
		
        return($xml_array);
    }
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    return array_multisort($sort_col, $dir, $arr);
}
function createListFile($resourceFilePath,$fileName, $str)            {

                         $folderPath = $resourceFilePath."/".$fileName;
                           
                         if( file_exists($folderPath) )         {

                                     unlink($folderPath);

                                    }else{
                                                $ourFileHandle=fopen($folderPath, 'w');
												chmod($folderPath,0777); 
                                                fclose($ourFileHandle);
												
                                    }

                         file_put_contents($folderPath, $str);
						 @chmod($folderPath,0777);

            }
  function public_disclousre_array($pageListArray1){
  	 $m =0;
    $dataArr=array();
  	if(is_array(@$pageListArray1['page'][0]) )    {
        $pageListArray = $pageListArray1['page'];		
        for($i=0;$i <sizeof($pageListArray);$i++)        {
                @$dataArr[$m]['financialYear']    = trim($pageListArray[$i]['financialYear']['value']);
              	$quatersArray = $pageListArray[$i]['quaters'];
				
				$r=0;
						//Quater Array
						if(is_array(@$quatersArray[0]) )    {
							for($q=0;$q<sizeof($quatersArray);$q++)        {
								@$dataArr[$m]['quaters'][$r]['quater'] = trim($quatersArray[$q]['quater']['value']);
								$reportsArray = $quatersArray[$q]['reports'];
								
								//Reports Array
								$k1=0;
										if(is_array(@$reportsArray[0]) )    {
											
											for($k=0;$k<sizeof($reportsArray);$k++)        {
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['reportName'] = trim($reportsArray[$k]['reportName']['value']);
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['report'] = trim($reportsArray[$k]['report']['value']);
												$k1++;    
											}
										}else{	
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['reportName'] = trim($reportsArray['reportName']['value']);
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['report'] = trim($reportsArray['report']['value']);
												$k1++;    
										}
								$r++;            
							}
						}else{	
							    @$dataArr[$m]['quaters'][$r]['quater'] = trim($quatersArray['quater']['value']);	
								$reportsArray = $quatersArray['reports'];						
								//Reports Array
									$k1=0;
										if(is_array($reportsArray[0]) )    {
											for($k=0;$k<sizeof($reportsArray);$k++)        {
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['reportName'] = trim($reportsArray[$k]['reportName']['value']);
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['report'] = trim($reportsArray[$k]['report']['value']);
												$k1++;    
											}
										}else{	
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['reportName'] = trim($reportsArray['reportName']['value']);
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['report'] = trim($reportsArray['report']['value']);
												$k1++;    
										}
										$r++;
						}
					
                $m++;            
        }
    }else    {
            		$pageListArray = $pageListArray1['page'];    
                    @$dataArr[$m]['financialYear']       = trim($pageListArray['financialYear']['value']);
                   	$quatersArray = $pageListArray['quaters'];
						$r=0;
						//Quater Array
						if(is_array($quatersArray[0]) )    {
							for($q=0;$q <sizeof($quatersArray);$q++)        {
								@$dataArr[$m]['quaters'][$r]['quater'] = trim($quatersArray[$q]['quater']['value']);
								//Reports Array
								$reportsArray = $quatersArray[$i]['reports'];
								$k1=0;
										if(is_array($reportsArray[0]) )    {
											for($k=0;$k<sizeof($reportsArray);$k++)        {
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['reportName'] = trim($reportsArray[$k]['reportName']['value']);
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['report'] = trim($reportsArray[$k]['report']['value']);
												$k1++;    
											}
										}else{	
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['reportName'] = trim($reportsArray['reportName']['value']);
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['report'] = trim($reportsArray['report']['value']);
												$k1++;    
										}
								$r++;            
							}
						}else{	
							    @$dataArr[$m]['quaters'][$r]['quater'] = trim($quatersArray['quater']['value']);
								$reportsArray = $quatersArray['reports'];
								//Reports Array
									$k1=0;
										if(is_array($reportsArray[0]) )    {
											for($k=0;$k<sizeof($reportsArray);$k++)        {
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['reportName'] = trim($reportsArray[$k]['reportName']['value']);
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['report'] = trim($reportsArray[$k]['report']['value']);
												$k1++;    
											}
										}else{	
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['reportName'] = trim($reportsArray['reportName']['value']);
												@$dataArr[$m]['quaters'][$r]['reports'][$k1]['report'] = trim($reportsArray['report']['value']);
												$k1++;    
										}
										$r++;
						}
    }
	return $dataArr;
  }
 function press_array($pageListArray1){
    $m =0;
    $dataArr=array();
    if(is_array($pageListArray1['page'][0]) )    {
        $pageListArray = $pageListArray1['page'];
        for($i=0;$i <sizeof($pageListArray);$i++)
        {

                @$dataArr[$m]['pressId']         			 = trim($pageListArray[$i]['pressId']['value']);
                @$dataArr[$m]['pressTitle']       			= $pageListArray[$i]['pressTitle']['value'];
                @$dataArr[$m]['pressDescription']           = $pageListArray[$i]['pressDescription']['value'];
                @$dataArr[$m]['fileName']                   = $pageListArray[$i]['fileName']['value'];
                @$dataArr[$m]['fileType']              		= $pageListArray[$i]['fileType']['value'];
                @$dataArr[$m]['source'] 					= $pageListArray[$i]['source']['value'];
                @$dataArr[$m]['date']       			    = trim($pageListArray[$i]['date']['value']);
                $m++;
            
        }
    }else    {
            $pageListArray = $pageListArray1['page'];    
            if(trim($pageListArray['isDeleted']['value']) =='no')     {
                    @$dataArr[$m]['pressId']         	= trim($pageListArray['pressId']['value']);
                    @$dataArr[$m]['pressTitle']   		= $pageListArray['pressTitle']['value'];
                    @$dataArr[$m]['pressDescription']   = $pageListArray['pressDescription']['value'];
                    @$dataArr[$m]['fileName']        	= $pageListArray['fileName']['value'];
                    @$dataArr[$m]['fileType']       	= $pageListArray['fileType']['value'];
                    @$dataArr[$m]['source'] 			= $pageListArray['source']['value'];
                    @$dataArr[$m]['date']        	    = trim($pageListArray['date']['value']);            
                    $m++;
                }
    }
//sort by
    if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
        array_multisort(@$order_in_category, SORT_ASC, $dataArr);
    }
return $dataArr;
} 

 function media_array($pageListArray1){
    $m =0;
    $dataArr=array();
    if(is_array(@$pageListArray1['page'][0]))    {
        $pageListArray = $pageListArray1['page'];
        for($i=0;$i <sizeof($pageListArray);$i++)
        {
                @$dataArr[$m]['mediaId']            = trim($pageListArray[$i]['mediaId']['value']);
                @$dataArr[$m]['mediaTitle']         = $pageListArray[$i]['mediaTitle']['value'];
                @$dataArr[$m]['mediaDescription']   = $pageListArray[$i]['mediaDescription']['value'];
                @$dataArr[$m]['fileName']           = $pageListArray[$i]['fileName']['value'];
                @$dataArr[$m]['fileType']           = $pageListArray[$i]['fileType']['value'];
                @$dataArr[$m]['source']             = $pageListArray[$i]['source']['value'];
		@$dataArr[$m]['sourceTitle']        = $pageListArray[$i]['sourceTitle']['value'];
                @$dataArr[$m]['date']               = trim($pageListArray[$i]['date']['value']);
                $m++;
            
        }
    }else    {
            $pageListArray = $pageListArray1['page'];    
            if(trim($pageListArray['isDeleted']['value']) =='no')     {
                    @$dataArr[$m]['mediaId']            = trim($pageListArray['mediaId']['value']);
                    @$dataArr[$m]['mediaTitle']         = $pageListArray['mediaTitle']['value'];
                    @$dataArr[$m]['mediaDescription']   = $pageListArray['mediaDescription']['value'];
                    @$dataArr[$m]['fileName']           = $pageListArray['fileName']['value'];
                    @$dataArr[$m]['fileType']           = $pageListArray['fileType']['value'];
                    @$dataArr[$m]['source']             = $pageListArray['source']['value'];
                    @$dataArr[$m]['sourceTitle']        = $pageListArray['sourceTitle']['value'];
                    @$dataArr[$m]['date']               = trim($pageListArray['date']['value']);            
                    $m++;
                }
    }
//sort by
    if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
        array_multisort(@$order_in_category, SORT_ASC, $dataArr);
    }
return $dataArr;
}

function web_array($pageListArray1){
    $m =0;
    $dataArr=array();
    if(is_array(@$pageListArray1['page'][0]))    {
        $pageListArray = $pageListArray1['page'];
        for($i=0;$i <sizeof($pageListArray);$i++)
        {
                @$dataArr[$m]['webId']           		= trim($pageListArray[$i]['webId']['value']);
                @$dataArr[$m]['webTitle']     		  	= $pageListArray[$i]['webTitle']['value'];
                @$dataArr[$m]['webDescription']      	= $pageListArray[$i]['webDescription']['value'];
                @$dataArr[$m]['source'] 				= $pageListArray[$i]['source']['value'];
                @$dataArr[$m]['date']         			= trim($pageListArray[$i]['date']['value']);
                $m++;
            
        }
    }else    {
            $pageListArray = $pageListArray1['page'];    
            if(trim($pageListArray['isDeleted']['value']) =='no')     {
                @$dataArr[$m]['webId']   	        	= trim($pageListArray['webId']['value']);
                @$dataArr[$m]['webTitle']     		  	= $pageListArray['webTitle']['value'];
                @$dataArr[$m]['webDescription']      	= $pageListArray['webDescription']['value'];
                @$dataArr[$m]['source'] 				= $pageListArray['source']['value'];
                @$dataArr[$m]['date']         			= trim($pageListArray['date']['value']);           
                    $m++;
                }
    }
//sort by
    if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
        array_multisort(@$order_in_category, SORT_ASC, $dataArr);
    }
return $dataArr;
}
function wellness_page_particular_id($pageListArray1,$id){
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		$m=0;
			for($i=0;$i < sizeof($pageListArray);$i++)		{
				if($id==trim($pageListArray[$i]['hospitalId']['value'])){
					@$dataArr[$m]['hospitalId'] 	= trim($pageListArray[$i]['hospitalId']['value']);
					@$dataArr[$m]['hospitalName'] 	  = @$pageListArray[$i]['hospitalName']['value'];
					@$dataArr[$m]['categoryName'] 	  = @$pageListArray[$i]['categoryName']['value'];
					@$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
					@$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
					@$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
					@$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
					@$dataArr[$m]['cityTitle'] 		  = @$pageListArray[$i]['cityTitle']['value'];
					@$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
					@$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
					@$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
					$dataArr[$m]['fax']               = @$pageListArray[$i]['fax']['value'];
					$dataArr[$m]['stateTitle'] 	 	  = @$pageListArray[$i]['stateTitle']['value'];
					$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
					$dataArr[$m]['mobile'] 		  	  = @$pageListArray[$i]['mobile']['value'];
					$dataArr[$m]['detailsOfServices'] = @$pageListArray[$i]['detailsOfServices']['value'];
					$dataArr[$m]['discount'] 		  = @$pageListArray[$i]['discount']['value'];
					$dataArr[$m]['termsCondition'] 		  = @$pageListArray[$i]['termsCondition']['value'];
					$dataArr[$m]['offerDetails'] 		  = @$pageListArray[$i]['offerDetails']['value'];
					$m++;
					break;
				}
					
			}
	}else{
			@$pageListArray=@$pageListArray1['page'];
			$m=0;
				if($id==trim($pageListArray['hospitalId']['value'])){                                  
				$dataArr[$m]['hospitalId'] 		  = trim($pageListArray['hospitalId']['value']);
				$dataArr[$m]['hospitalName'] 	  = @$pageListArray['hospitalName']['value'];
				$dataArr[$m]['address1'] 		  = @$pageListArray['address1']['value'];
				$dataArr[$m]['address2'] 		  = @$pageListArray['address2']['value'];
				$dataArr[$m]['state'] 			  = @$pageListArray['state']['value'];
				$dataArr[$m]['city'] 			  = @$pageListArray['city']['value'];
				@$dataArr[$m]['cityTitle'] 		= @$pageListArray['cityTitle']['value'];
				$dataArr[$m]['stateTitle'] 	 	 = @$pageListArray['stateTitle']['value'];
				$dataArr[$m]['location'] 		  = @$pageListArray['location']['value'];
				$dataArr[$m]['pincode'] 		  = @$pageListArray['pincode']['value'];
				$dataArr[$m]['phone'] 			  = @$pageListArray['phone']['value'];
				$dataArr[$m]['fax'] 			  = @$pageListArray['fax']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray['email']['value'];
				$dataArr[$m]['mobile'] 		 	 = @$pageListArray['mobile']['value'];
				$dataArr[$m]['detailsOfServices'] 		  = @$pageListArray['detailsOfServices']['value'];
				$dataArr[$m]['discount'] 		  = @$pageListArray['discount']['value'];
				$dataArr[$m]['termsCondition'] 		  = @$pageListArray['termsCondition']['value'];
				$dataArr[$m]['offerDetails'] 		  = @$pageListArray['offerDetails']['value'];
				$dataArr[$m]['categoryName'] 	  = @$pageListArray['categoryName']['value'];
				$m++;        
				}
		}
	return @$dataArr;
}
function wellness_page_array($pageListArray1,$city,$advanceSearch,$categoryName=''){
	$m =0;
	$categoryName1=array(); 
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];  
		for($i=0;$i < sizeof($pageListArray);$i++)
		{
			if(@$city!='' && @$advanceSearch==''){  
				$categoryName1=explode(",",@$pageListArray[$i]['categoryName']['value']);  
				if(($city==@$pageListArray[$i]['city']['value'] ) && (in_array(@$categoryName,$categoryName1))){                                  
				@$dataArr[$m]['hospitalId'] 		  = trim($pageListArray[$i]['hospitalId']['value']);
				@$dataArr[$m]['hospitalName'] 	  = @$pageListArray[$i]['hospitalName']['value'];
				@$dataArr[$m]['categoryName'] 	  = @$pageListArray[$i]['categoryName']['value'];
				@$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				@$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				@$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				@$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 		  = @$pageListArray[$i]['cityTitle']['value'];
				@$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				@$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				@$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
                $dataArr[$m]['fax']               = @$pageListArray[$i]['fax']['value'];
				$dataArr[$m]['stateTitle'] 	  = @$pageListArray[$i]['stateTitle']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['mobile'] 		  = @$pageListArray[$i]['mobile']['value'];
				$dataArr[$m]['detailsOfServices'] 		  = @$pageListArray[$i]['detailsOfServices']['value'];
				$dataArr[$m]['discount'] 		  = @$pageListArray[$i]['discount']['value'];
				$dataArr[$m]['termsCondition'] 		  = @$pageListArray[$i]['termsCondition']['value'];
				$dataArr[$m]['offerDetails'] 		  = @$pageListArray[$i]['offerDetails']['value'];
				$m++;        
				}
			}else if(@$city!='' && @$advanceSearch!=''){ 
                 $orignal = trim(strtolower(base64_decode(@$pageListArray[$i]['hospitalName']['value']))) ;
                 $countText  = strlen($advanceSearch);
                 $match = substr($orignal,0,$countText);
                  
				   $location = trim(strtolower(base64_decode(@$pageListArray[$i]['location']['value']))) ;
				   $match1 = substr($location,0,$countText);
				   
				   $pincode = trim(strtolower(base64_decode(@$pageListArray[$i]['pincode']['value']))) ;
				   $match2 = substr($pincode,0,$countText);  
				   $categoryName1=explode(",",@$pageListArray[$i]['categoryName']['value']);         
                  if($city==@$pageListArray[$i]['city']['value'] && (in_array($categoryName,$categoryName1))&& (($match==strtolower($advanceSearch)) || ($match1==strtolower($advanceSearch)) || ($match2==strtolower($advanceSearch)))) {
                              
				$dataArr[$m]['hospitalId'] 		  = trim($pageListArray[$i]['hospitalId']['value']);
				$dataArr[$m]['hospitalName'] 	  = @$pageListArray[$i]['hospitalName']['value'];
				$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray[$i]['cityTitle']['value'];
				$dataArr[$m]['stateTitle'] 	  = @$pageListArray[$i]['stateTitle']['value'];
				$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
				$dataArr[$m]['fax'] 			  = @$pageListArray[$i]['fax']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['mobile'] 		  = @$pageListArray[$i]['mobile']['value'];
				$dataArr[$m]['detailsOfServices'] 		  = @$pageListArray[$i]['detailsOfServices']['value'];
				$dataArr[$m]['discount'] 		  = @$pageListArray[$i]['discount']['value'];
				$dataArr[$m]['termsCondition'] 		  = @$pageListArray[$i]['termsCondition']['value'];
				$dataArr[$m]['offerDetails'] 		  = @$pageListArray[$i]['offerDetails']['value'];
				$dataArr[$m]['categoryName'] 	  = @$pageListArray[$i]['categoryName']['value'];
                $m++;
				}
			
			 }
		}
	}else{
			@$pageListArray=@$pageListArray1['page'];
			$m=0;
				if($city==@$pageListArray['city']['value']  ){                                  
				$dataArr[$m]['hospitalId'] 		  = trim($pageListArray['hospitalId']['value']);
				$dataArr[$m]['hospitalName'] 	  = @$pageListArray['hospitalName']['value'];
				$dataArr[$m]['address1'] 		  = @$pageListArray['address1']['value'];
				$dataArr[$m]['address2'] 		  = @$pageListArray['address2']['value'];
				$dataArr[$m]['state'] 			  = @$pageListArray['state']['value'];
				$dataArr[$m]['city'] 			  = @$pageListArray['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray['cityTitle']['value'];
				$dataArr[$m]['stateTitle'] 	  = @$pageListArray['stateTitle']['value'];
				$dataArr[$m]['location'] 		  = @$pageListArray['location']['value'];
				$dataArr[$m]['pincode'] 		  = @$pageListArray['pincode']['value'];
				$dataArr[$m]['phone'] 			  = @$pageListArray['phone']['value'];
				$dataArr[$m]['fax'] 			  = @$pageListArray['fax']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray['email']['value'];
				$dataArr[$m]['mobile'] 		  = @$pageListArray['mobile']['value'];
				$dataArr[$m]['detailsOfServices'] 		  = @$pageListArray['detailsOfServices']['value'];
				$dataArr[$m]['discount'] 		  = @$pageListArray['discount']['value'];
				$dataArr[$m]['termsCondition'] 		  = @$pageListArray['termsCondition']['value'];
				$dataArr[$m]['offerDetails'] 		  = @$pageListArray['offerDetails']['value'];
				$dataArr[$m]['categoryName'] 	  = @$pageListArray['categoryName']['value'];
				$m++;        
				}
		}
return @$dataArr;
}
function opd_page_array($pageListArray1,$city,$advanceSearch){
	$m =0; 
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];  
       
		for($i=0;$i < sizeof($pageListArray);$i++)
		{
			if($city!='' && $advanceSearch==''){    
					if($city==@$pageListArray[$i]['city']['value'] ){                                  
				@$dataArr[$m]['hospitalId'] 		  = trim($pageListArray[$i]['hospitalId']['value']);
				@$dataArr[$m]['hospitalName'] 	  = @$pageListArray[$i]['hospitalName']['value'];
				@$dataArr[$m]['hospitalCode'] 	  = @$pageListArray[$i]['hospitalCode']['value'];
				@$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				@$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				@$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				@$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray[$i]['cityTitle']['value'];
				@$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				@$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				@$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
                $dataArr[$m]['fax']               = @$pageListArray[$i]['fax']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray[$i]['hospitalType']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['website'] 		  = @$pageListArray[$i]['website']['value'];
				$dataArr[$m]['longitude'] 		  = @$pageListArray[$i]['longitude']['value'];
				$dataArr[$m]['lattitude'] 		  = @$pageListArray[$i]['lattitude']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray[$i]['hospitalType']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
				$m++;        
				}
			}else if($city!='' && $advanceSearch!=''){ 
                 $orignal = trim(strtolower(base64_decode($pageListArray[$i]['hospitalName']['value']))) ;
                 $countText  = strlen($advanceSearch);
                 $match = substr($orignal,0,$countText);
                  
				   $location = trim(strtolower(base64_decode($pageListArray[$i]['location']['value']))) ;
				   $match1 = substr($location,0,$countText);        
                  if($city==@$pageListArray[$i]['city']['value'] && (($match==strtolower($advanceSearch)) || ($match1==strtolower($advanceSearch)))) {
                              
				$dataArr[$m]['hospitalId'] 		  = trim($pageListArray[$i]['hospitalId']['value']);
				$dataArr[$m]['hospitalName'] 	  = @$pageListArray[$i]['hospitalName']['value'];
				$dataArr[$m]['hospitalCode'] 	  = @$pageListArray[$i]['hospitalCode']['value'];
				$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray[$i]['cityTitle']['value'];
				$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
				$dataArr[$m]['fax'] 			  = @$pageListArray[$i]['fax']['value'];
                $dataArr[$m]['hospitalType']      = @$pageListArray[$i]['hospitalType']['value']; 
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['website'] 		  = @$pageListArray[$i]['website']['value'];
				$dataArr[$m]['longitude'] 		  = @$pageListArray[$i]['longitude']['value'];
				$dataArr[$m]['lattitude'] 		  = @$pageListArray[$i]['lattitude']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray[$i]['hospitalType']['value'];
				$dataArr[$m]['match'] 	  = @$match;
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
                $m++;
				}
			
			 }
		}
	}else{
			@$pageListArray=@$pageListArray1['page'];
			$m=0;
				if($city==@$pageListArray['city']['value'] ){                                  
				@$dataArr[$m]['hospitalId'] 		  = trim($pageListArray['hospitalId']['value']);
				@$dataArr[$m]['hospitalName'] 	  = @$pageListArray['hospitalName']['value'];
				@$dataArr[$m]['hospitalCode'] 	  = @$pageListArray['hospitalCode']['value'];
				@$dataArr[$m]['address1'] 		  = @$pageListArray['address1']['value'];
				@$dataArr[$m]['address2'] 		  = @$pageListArray['address2']['value'];
				@$dataArr[$m]['state'] 			  = @$pageListArray['state']['value'];
				@$dataArr[$m]['city'] 			  = @$pageListArray['city']['value'];
				@$dataArr[$m]['cityTitle'] 		  = @$pageListArray['cityTitle']['value'];
				@$dataArr[$m]['location'] 		  = @$pageListArray['location']['value'];
				@$dataArr[$m]['pincode'] 		  = @$pageListArray['pincode']['value'];
				@$dataArr[$m]['phone'] 			  = @$pageListArray['phone']['value'];
                $dataArr[$m]['fax']               = @$pageListArray['fax']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray['hospitalType']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray['email']['value'];
				$dataArr[$m]['website'] 		  = @$pageListArray['website']['value'];
				$dataArr[$m]['longitude'] 		  = @$pageListArray['longitude']['value'];
				$dataArr[$m]['lattitude'] 		  = @$pageListArray['lattitude']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray['hospitalType']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray['isDeleted']['value']);
				$m++;        
				}
		}
//sort by
	/*if (count (@$dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}*/
return @$dataArr;
}
function hospital_page_array($pageListArray1,$city,$advanceSearch){
	$m =0; 
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];  
       
		for($i=0;$i < sizeof($pageListArray);$i++)
		{
			if($city!='' && $advanceSearch==''){    
					if($city==@$pageListArray[$i]['city']['value'] ){                                  
				@$dataArr[$m]['hospitalId'] 		  = trim($pageListArray[$i]['hospitalId']['value']);
				@$dataArr[$m]['hospitalName'] 	  = @$pageListArray[$i]['hospitalName']['value'];
				@$dataArr[$m]['hospitalCode'] 	  = @$pageListArray[$i]['hospitalCode']['value'];
				@$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				@$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				@$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				@$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray[$i]['cityTitle']['value'];
				@$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				@$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				@$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
                $dataArr[$m]['fax']               = @$pageListArray[$i]['fax']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray[$i]['hospitalType']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['website'] 		  = @$pageListArray[$i]['website']['value'];
				$dataArr[$m]['longitude'] 		  = @$pageListArray[$i]['longitude']['value'];
				$dataArr[$m]['lattitude'] 		  = @$pageListArray[$i]['lattitude']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray[$i]['hospitalType']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
				$m++;        
				}
			}else if($city!='' && $advanceSearch!=''){ 
                 $orignal = trim(strtolower(base64_decode($pageListArray[$i]['hospitalName']['value']))) ;
                 $countText  = strlen($advanceSearch);
                 $match = substr($orignal,0,$countText);
                  
				   $location = trim(strtolower(base64_decode($pageListArray[$i]['location']['value']))) ;
				   $match1 = substr($location,0,$countText);        
                  if($city==@$pageListArray[$i]['city']['value'] && (($match==strtolower($advanceSearch)) || ($match1==strtolower($advanceSearch)))) {
                              
				$dataArr[$m]['hospitalId'] 		  = trim($pageListArray[$i]['hospitalId']['value']);
				$dataArr[$m]['hospitalName'] 	  = @$pageListArray[$i]['hospitalName']['value'];
				$dataArr[$m]['hospitalCode'] 	  = @$pageListArray[$i]['hospitalCode']['value'];
				$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray[$i]['cityTitle']['value'];
				$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
				$dataArr[$m]['fax'] 			  = @$pageListArray[$i]['fax']['value'];
                $dataArr[$m]['hospitalType']      = @$pageListArray[$i]['hospitalType']['value']; 
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['website'] 		  = @$pageListArray[$i]['website']['value'];
				$dataArr[$m]['longitude'] 		  = @$pageListArray[$i]['longitude']['value'];
				$dataArr[$m]['lattitude'] 		  = @$pageListArray[$i]['lattitude']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray[$i]['hospitalType']['value'];
				$dataArr[$m]['match'] 	  = @$match;
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
                $m++;
			} }
		}
	}
//sort by
	/*if (count (@$dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}*/
return @$dataArr;
}

function branch_page_array($pageListArray1,$city,$advanceSearch){
	$m =0;   
   
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
          //echo "<pre>";
       //print_r($pageListArray); exit;
       
       
		for($i=0;$i < sizeof($pageListArray);$i++)
		{
			if($city!='' && $advanceSearch==''){    
					if($city==@$pageListArray[$i]['city']['value'] ){
                                  
				@$dataArr[$m]['branchId'] 		  = trim($pageListArray[$i]['branchId']['value']);
				@$dataArr[$m]['branchName'] 	  = @$pageListArray[$i]['branchName']['value'];
				@$dataArr[$m]['branchCode'] 	  = @$pageListArray[$i]['branchCode']['value'];
				@$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				@$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				@$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				@$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray[$i]['cityTitle']['value'];
				@$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				@$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				@$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
                $dataArr[$m]['fax']               = @$pageListArray[$i]['fax']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['website'] 		  = @$pageListArray[$i]['website']['value'];
				$dataArr[$m]['longitude'] 		  = @$pageListArray[$i]['longitude']['value'];
				$dataArr[$m]['lattitude'] 		  = @$pageListArray[$i]['lattitude']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
				$m++;        
				}
			}else if($city!='' && $advanceSearch!=''){ 
                 $orignal = trim(strtolower(base64_decode($pageListArray[$i]['branchName']['value']))) ;
                 $countText  = strlen($advanceSearch);
                 $match = substr($orignal,0,$countText);
                                
                    if($city==@$pageListArray[$i]['city']['value'] && $match==strtolower($advanceSearch)) {
                              
				$dataArr[$m]['branchId'] 		  = trim($pageListArray[$i]['branchId']['value']);
				$dataArr[$m]['branchName'] 	  = @$pageListArray[$i]['branchName']['value'];
				$dataArr[$m]['branchCode'] 	  = @$pageListArray[$i]['branchCode']['value'];
				$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray[$i]['cityTitle']['value'];
				$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
				$dataArr[$m]['fax'] 			  = @$pageListArray[$i]['fax']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['website'] 		  = @$pageListArray[$i]['website']['value'];
				$dataArr[$m]['longitude'] 		  = @$pageListArray[$i]['longitude']['value'];
				$dataArr[$m]['lattitude'] 		  = @$pageListArray[$i]['lattitude']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
                $m++;
			} }
		}
	}
//sort by
	if (count (@$dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return @$dataArr;
}
function wellness_category_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			$dataArr[$m]['categoryName'] 		  		= @$pageListArray[$i]['categoryName']['value'];
				$m++;
		}
	}else	{
					$pageListArray = @$pageListArray1['page'];	
					if(@$pageListArray['categoryName']['value']!=''){
						$dataArr[$m]['categoryName']		 = @$pageListArray['categoryName']['value'];			
					}
					$m++;
	}
//sort by
	/*if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}*/
return $dataArr;
}
function hospital_particular_details($pageListArray1,$id){
	$dataArr=array();
	$m =0; 
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];  
       
		for($i=0;$i < sizeof($pageListArray);$i++)
		{
			if(@$id==trim(@$pageListArray[$i]['hospitalId']['value'])){                          
				@$dataArr[$m]['hospitalId'] 		  = trim($pageListArray[$i]['hospitalId']['value']);
				@$dataArr[$m]['hospitalName'] 	  = @$pageListArray[$i]['hospitalName']['value'];
				@$dataArr[$m]['hospitalCode'] 	  = @$pageListArray[$i]['hospitalCode']['value'];
				@$dataArr[$m]['address1'] 		  = @$pageListArray[$i]['address1']['value'];
				@$dataArr[$m]['address2'] 		  = @$pageListArray[$i]['address2']['value'];
				@$dataArr[$m]['state'] 			  = @$pageListArray[$i]['state']['value'];
				@$dataArr[$m]['city'] 			  = @$pageListArray[$i]['city']['value'];
				@$dataArr[$m]['cityTitle'] 			  = @$pageListArray[$i]['cityTitle']['value'];
				@$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				@$dataArr[$m]['pincode'] 		  = @$pageListArray[$i]['pincode']['value'];
				@$dataArr[$m]['phone'] 			  = @$pageListArray[$i]['phone']['value'];
                $dataArr[$m]['fax']               = @$pageListArray[$i]['fax']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray[$i]['hospitalType']['value'];
				$dataArr[$m]['email'] 			  = @$pageListArray[$i]['email']['value'];
				$dataArr[$m]['website'] 		  = @$pageListArray[$i]['website']['value'];
				$dataArr[$m]['longitude'] 		  = @$pageListArray[$i]['longitude']['value'];
				$dataArr[$m]['lattitude'] 		  = @$pageListArray[$i]['lattitude']['value'];
				$dataArr[$m]['hospitalType'] 	  = @$pageListArray[$i]['hospitalType']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
				$m++; 
				break;       
				}
			 }
		}
return @$dataArr;
}
function states_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['stateId'] 		  		= @$pageListArray[$i]['stateId']['value'];
				$dataArr[$m]['stateTitle'] 	 		 = @$pageListArray[$i]['stateTitle']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['stateId'] 			= $pageListArray['stateId']['value'];
					$dataArr[$m]['stateTitle'] 		= @$pageListArray['stateTitle']['value'];
					$dataArr[$m]['isDeleted']		 = trim(@$pageListArray['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	/*if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}*/
return $dataArr;
}


function cities_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['stateId'] 		  		= @$pageListArray[$i]['stateId']['value'];
				$dataArr[$m]['cityId'] 		  		= @$pageListArray[$i]['cityId']['value'];
				$dataArr[$m]['cityTitle'] 	 		 = @$pageListArray[$i]['cityTitle']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['stateId'] 		= @$pageListArray['stateId']['value'];
					$dataArr[$m]['cityId'] 			= $pageListArray['cityId']['value'];
					$dataArr[$m]['cityTitle'] 		= @$pageListArray['cityTitle']['value'];
					$dataArr[$m]['isDeleted']		= trim(@$pageListArray['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
/*	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}*/
return $dataArr;
}




function jobs_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['jobId'] 		  	  = @$pageListArray[$i]['jobId']['value'];
				$dataArr[$m]['jobTitle'] 	 	  = @$pageListArray[$i]['jobTitle']['value'];
				$dataArr[$m]['location'] 		  = @$pageListArray[$i]['location']['value'];
				$dataArr[$m]['skills'] 			  = @$pageListArray[$i]['skills']['value'];
				$dataArr[$m]['qualification'] 	  = @$pageListArray[$i]['qualification']['value'];
				$dataArr[$m]['experience'] 		  = @$pageListArray[$i]['experience']['value'];
				$dataArr[$m]['description'] 	  = @$pageListArray[$i]['description']['value'];
				$dataArr[$m]['isDeleted']         = trim(@$pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['jobId'] 			= $pageListArray['jobId']['value'];
					$dataArr[$m]['jobTitle'] 		= @$pageListArray['jobTitle']['value'];
					$dataArr[$m]['location']		= @$pageListArray['location']['value'];
					$dataArr[$m]['skills']			= @$pageListArray['skills']['value'];
					$dataArr[$m]['qualification']	 = @$pageListArray['qualification']['value'];
					$dataArr[$m]['experience']		 = @$pageListArray['experience']['value'];
					$dataArr[$m]['description']		 = @$pageListArray['description']['value'];
					$dataArr[$m]['isDeleted']		 = trim(@$pageListArray['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}



function static_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array($pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				@$dataArr[$m]['staticId'] 		  = trim($pageListArray[$i]['staticId']['value']);
				@$dataArr[$m]['staticTitle'] 	  = $pageListArray[$i]['staticTitle']['value'];
				@$dataArr[$m]['pageCode'] 		  = $pageListArray[$i]['pageCode']['value'];
				@$dataArr[$m]['link'] 		  		= $pageListArray[$i]['link']['value'];
				@$dataArr[$m]['linkType'] 		  	= $pageListArray[$i]['linkType']['value'];
				@$dataArr[$m]['staticDescription'] = $pageListArray[$i]['staticDescription']['value'];
				$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['staticId'] 		= trim($pageListArray['staticId']['value']);
					$dataArr[$m]['staticTitle'] 	= $pageListArray['staticTitle']['value'];
					$dataArr[$m]['pageCode']		= $pageListArray['pageCode']['value'];
					$dataArr[$m]['link']			= $pageListArray['link']['value'];
					$dataArr[$m]['linkType']		= $pageListArray['linkType']['value'];
					$dataArr[$m]['staticDescription'] = $pageListArray['staticDescription']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}



function products_master_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array($pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		    for($i=0;$i <sizeof(@$pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
					$dataArr[$m]['productId'] 		  		= trim($pageListArray[$i]['productId']['value']);
                    $dataArr[$m]['productMaster']       = $pageListArray[$i]['productMaster']['value'];
					$dataArr[$m]['productSub'] 	  = $pageListArray[$i]['productSub']['value'];
					$dataArr[$m]['productCode'] 	  		= $pageListArray[$i]['productCode']['value'];
					$dataArr[$m]['geoDescription'] 	  		= $pageListArray[$i]['geoDescription']['value'];
					$dataArr[$m]['geodescriptionCode'] 	  = $pageListArray[$i]['geodescriptionCode']['value'];
					$dataArr[$m]['coverDescription'] 	  = $pageListArray[$i]['coverDescription']['value'];
					$dataArr[$m]['coverType'] 	  			= $pageListArray[$i]['coverType']['value'];
					$dataArr[$m]['sumDescription'] 	  		= $pageListArray[$i]['sumDescription']['value'];
					$dataArr[$m]['sumdescriptionCode'] 	 	 = $pageListArray[$i]['sumdescriptionCode']['value'];
					$dataArr[$m]['tenure'] 	 				 = $pageListArray[$i]['tenure']['value'];
					$dataArr[$m]['ageCode'] 	  			= $pageListArray[$i]['ageCode']['value'];
					$dataArr[$m]['ageBand1'] 	  			= $pageListArray[$i]['ageBand1']['value'];
					$dataArr[$m]['ageBand2'] 	  			= $pageListArray[$i]['ageBand2']['value'];
					$dataArr[$m]['ageBand3'] 	  			= $pageListArray[$i]['ageBand3']['value'];
					$dataArr[$m]['triptypeCode'] 	  		= $pageListArray[$i]['triptypeCode']['value'];
					$dataArr[$m]['isDeleted']        		 = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['productId'] 			= trim($pageListArray['productId']['value']);
                    $dataArr[$m]['productMaster']     = $pageListArray['productMaster']['value'];
					$dataArr[$m]['productSub'] 	= $pageListArray['productSub']['value'];
					$dataArr[$m]['productCode']			= $pageListArray['productCode']['value'];
					$dataArr[$m]['geoDescription']			= $pageListArray['geoDescription']['value'];
					$dataArr[$m]['geodescriptionCode']		= $pageListArray['geodescriptionCode']['value'];
					$dataArr[$m]['coverDescription'] 	= $pageListArray['coverDescription']['value'];
					$dataArr[$m]['coverType'] 			= $pageListArray['coverType']['value'];
					$dataArr[$m]['sumDescription'] 		= $pageListArray['sumDescription']['value'];
					$dataArr[$m]['sumdescriptionCode'] 	= $pageListArray['sumdescriptionCode']['value'];
					$dataArr[$m]['tenure'] 				=$pageListArray['tenure']['value'];
					$dataArr[$m]['ageCode'] 			= $pageListArray['ageCode']['value'];
					$dataArr[$m]['ageBand1'] 			= $pageListArray['ageBand1']['value'];
					$dataArr[$m]['ageBand2'] 			= $pageListArray['ageBand2']['value'];
					$dataArr[$m]['ageBand3'] 			= $pageListArray['ageBand3']['value'];
					$dataArr[$m]['triptypeCode'] 			= $pageListArray['triptypeCode']['value'];
					$dataArr[$m]['isDeleted']			 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}



function home_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array($pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				@$dataArr[$m]['pageId'] 		  = trim($pageListArray[$i]['pageId']['value']);
				@$dataArr[$m]['pageTitle'] 	  = $pageListArray[$i]['pageTitle']['value'];
				@$dataArr[$m]['link'] 		  		= $pageListArray[$i]['link']['value'];
				@$dataArr[$m]['pageDescription'] = $pageListArray[$i]['pageDescription']['value'];
				@$dataArr[$m]['briefDescription'] = $pageListArray[$i]['briefDescription']['value'];
				@$dataArr[$m]['thumbnail']	  	 = @$pageListArray[$i]['thumbnail']['value'];
				@$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['pageId'] 		= trim($pageListArray['pageId']['value']);
					$dataArr[$m]['pageTitle'] 	= $pageListArray['pageTitle']['value'];
					$dataArr[$m]['link']			= $pageListArray['link']['value'];
					$dataArr[$m]['pageDescription'] = $pageListArray['pageDescription']['value'];
					$dataArr[$m]['briefDescription'] = $pageListArray['briefDescription']['value'];
					$dataArr[$m]['thumbnail']	  	= @$pageListArray['thumbnail']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}


function settings_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array($pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['settingId'] 		  = trim($pageListArray[$i]['settingId']['value']);
				$dataArr[$m]['title'] 	 			 = @$pageListArray[$i]['title']['value'];
				$dataArr[$m]['description'] 		= @$pageListArray[$i]['description']['value'];
				$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['settingId'] 		= trim($pageListArray['settingId']['value']);
					$dataArr[$m]['title'] 			= $pageListArray['title']['value'];
					$dataArr[$m]['description']		 = $pageListArray['description']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}


function planDetails_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['planId'] 		  = @$pageListArray[$i]['planId']['value'];
				$dataArr[$m]['planTitle'] 	  = @$pageListArray[$i]['planTitle']['value'];
				$dataArr[$m]['planType'] 	  = @$pageListArray[$i]['planType']['value'];
				$dataArr[$m]['sumInsured'] 	  = @$pageListArray[$i]['sumInsured']['value'];
				$dataArr[$m]['planDescription'] = @$pageListArray[$i]['planDescription']['value'];
				$dataArr[$m]['orderBy'] = @$pageListArray[$i]['orderBy']['value'];
				$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			@$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					@$dataArr[$m]['planId'] 		= @$pageListArray['planId']['value'];
					@$dataArr[$m]['planTitle'] 	= @$pageListArray['planTitle']['value'];
					@$dataArr[$m]['planType'] 	= @$pageListArray['planType']['value'];
					@$dataArr[$m]['sumInsured'] 	= @$pageListArray['sumInsured']['value'];
					@$dataArr[$m]['planDescription'] = @$pageListArray['planDescription']['value'];
					$dataArr[$m]['orderBy'] = @$pageListArray[$i]['orderBy']['value'];
					@$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					@$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}

function sumInsured_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['benefitId'] 		  = @$pageListArray[$i]['benefitId']['value'];
				$dataArr[$m]['sumTitle'] 	  = @$pageListArray[$i]['sumTitle']['value'];
				$dataArr[$m]['sumId'] 	  = @$pageListArray[$i]['sumId']['value'];
				$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['benefitId'] 		= @$pageListArray['benefitId']['value'];
					$dataArr[$m]['sumTitle'] 	= @$pageListArray['sumTitle']['value'];
					$dataArr[$m]['sumId'] 	= @$pageListArray['sumId']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}




function faqs_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['faqId'] 		  =trim(@$pageListArray[$i]['faqId']['value']);
				$dataArr[$m]['faqTitle'] 	  = @$pageListArray[$i]['faqTitle']['value'];
				$dataArr[$m]['faqDescription'] = @$pageListArray[$i]['faqDescription']['value'];
				$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			@$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['faqId'] 		= trim(@$pageListArray['faqId']['value']);
					$dataArr[$m]['faqTitle'] 	= @$pageListArray['faqTitle']['value'];
					$dataArr[$m]['faqDescription'] = @$pageListArray['faqDescription']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}

function seo_faqs_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['faqId'] 		  =trim(@$pageListArray[$i]['faqId']['value']);
				$dataArr[$m]['faqTitle'] 	  = @$pageListArray[$i]['faqTitle']['value'];
				$dataArr[$m]['faqDescription'] = @$pageListArray[$i]['faqDescription']['value'];
				$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			@$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['faqId'] 		= trim(@$pageListArray['faqId']['value']);
					$dataArr[$m]['faqTitle'] 	= @$pageListArray['faqTitle']['value'];
					$dataArr[$m]['faqDescription'] = @$pageListArray['faqDescription']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}

function formsDetails_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['formId'] 		  = @$pageListArray[$i]['formId']['value'];
				$dataArr[$m]['formTitle'] 	  = @$pageListArray[$i]['formTitle']['value'];
				$dataArr[$m]['formDescription'] = @$pageListArray[$i]['formDescription']['value'];
				$dataArr[$m]['fileName']	  		 = @$pageListArray[$i]['fileName']['value'];
				$dataArr[$m]['fileType']	  		 = @$pageListArray[$i]['fileType']['value'];
				$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['formId'] 		= @$pageListArray['formId']['value'];
					$dataArr[$m]['formTitle'] 	= @$pageListArray['formTitle']['value'];
					$dataArr[$m]['formDescription'] = @$pageListArray['formDescription']['value'];
					$dataArr[$m]['fileName']	  		= @$pageListArray['fileName']['value'];
					$dataArr[$m]['fileType']	  		= @$pageListArray['fileType']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}

function faqsClaimCentre_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['page'][0]) )	{
		$pageListArray = $pageListArray1['page'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
				$dataArr[$m]['faqId'] 		  = @$pageListArray[$i]['faqId']['value'];
				$dataArr[$m]['faqTitle'] 	  = @$pageListArray[$i]['faqTitle']['value'];
				$dataArr[$m]['faqDescription'] = @$pageListArray[$i]['faqDescription']['value'];
				$dataArr[$m]['isDeleted']         = trim($pageListArray[$i]['isDeleted']['value']);
				$m++;
			}
		}
	}else	{
			$pageListArray = $pageListArray1['page'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['faqId'] 		= @$pageListArray['faqId']['value'];
					$dataArr[$m]['faqTitle'] 	= @$pageListArray['faqTitle']['value'];
					$dataArr[$m]['faqDescription'] = @$pageListArray['faqDescription']['value'];
					@$dataArr[$m]['isDeleted']		 = trim(@$pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}



function category_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['category'][0]) )	{
		$pageListArray = $pageListArray1['category'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
					$dataArr[$m]['categoryId'] 	  	  = $pageListArray[$i]['categoryId']['value'];
					$dataArr[$m]['categoryName']	  = @$pageListArray[$i]['categoryName']['value'];
					$dataArr[$m]['description']	 	 = @$pageListArray[$i]['description']['value'];
					$dataArr[$m]['briefDescription'] = @$pageListArray[$i]['briefDescription']['value'];
					$dataArr[$m]['metaTitle']	 	 = @$pageListArray[$i]['metaTitle']['value'];
					$dataArr[$m]['metaDescription']	 = @$pageListArray[$i]['metaDescription']['value'];
					$dataArr[$m]['metaKeywords']	 = @$pageListArray[$i]['metaKeywords']['value'];
					$dataArr[$m]['banner']	  		 = @$pageListArray[$i]['banner']['value'];
					$dataArr[$m]['isDeleted']        = trim($pageListArray[$i]['isDeleted']['value']);
					$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['category'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['categoryId'] 		 = $pageListArray['categoryId']['value'];
					$dataArr[$m]['categoryName']	 = $pageListArray['categoryName']['value'];
					$dataArr[$m]['description']	  	 = $pageListArray['description']['value'];
					$dataArr[$m]['briefDescription'] = $pageListArray['briefDescription']['value'];
					$dataArr[$m]['metaTitle']	  	 = $pageListArray['metaTitle']['value'];
					$dataArr[$m]['metaDescription']	 = $pageListArray['metaDescription']['value'];
					$dataArr[$m]['metaKeywords']	 = $pageListArray['metaKeywords']['value'];
					$dataArr[$m]['banner']	  		= @$pageListArray['banner']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}


function download_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['download'][0]) )	{
		$pageListArray = $pageListArray1['download'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
					$dataArr[$m]['downloadId'] 	  	  = $pageListArray[$i]['downloadId']['value'];
					$dataArr[$m]['downloadTitle']	  = @$pageListArray[$i]['downloadTitle']['value'];
					$dataArr[$m]['fileName']	  		 = @$pageListArray[$i]['fileName']['value'];
					$dataArr[$m]['fileType']	  		 = @$pageListArray[$i]['fileType']['value'];
					$dataArr[$m]['isDeleted']        = trim($pageListArray[$i]['isDeleted']['value']);
					$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['download'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['downloadId'] 		 = $pageListArray['downloadId']['value'];
					$dataArr[$m]['downloadTitle']	 = $pageListArray['downloadTitle']['value'];
					$dataArr[$m]['fileName']	  		= @$pageListArray['fileName']['value'];
					$dataArr[$m]['fileType']	  		= @$pageListArray['fileType']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}
function claim_forms_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['claimforms'][0]) )	{
		$pageListArray = $pageListArray1['claimforms'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
					$dataArr[$m]['claimformsId'] 	  	  = $pageListArray[$i]['claimformsId']['value'];
					$dataArr[$m]['downloadTitle']	  = @$pageListArray[$i]['downloadTitle']['value'];
					$dataArr[$m]['fileName']	  		 = @$pageListArray[$i]['fileName']['value'];
					$dataArr[$m]['fileType']	  		 = @$pageListArray[$i]['fileType']['value'];
					$dataArr[$m]['isDeleted']        = trim($pageListArray[$i]['isDeleted']['value']);
					$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['claimforms'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['claimformsId'] 		 = $pageListArray['claimformsId']['value'];
					$dataArr[$m]['downloadTitle']	 = $pageListArray['downloadTitle']['value'];
					$dataArr[$m]['fileName']	  		= @$pageListArray['fileName']['value'];
					$dataArr[$m]['fileType']	  		= @$pageListArray['fileType']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}
function goodnesswallpapers_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['goodnesswallpapers'][0]) )	{
		$pageListArray = $pageListArray1['goodnesswallpapers'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
					$dataArr[$m]['goodnesswallpapersId'] 	  	  = $pageListArray[$i]['goodnesswallpapersId']['value'];
					$dataArr[$m]['downloadTitle']	  = @$pageListArray[$i]['downloadTitle']['value'];
					$dataArr[$m]['fileName']	  		 = @$pageListArray[$i]['fileName']['value'];
					$dataArr[$m]['fileType']	  		 = @$pageListArray[$i]['fileType']['value'];
					$dataArr[$m]['isDeleted']        = trim($pageListArray[$i]['isDeleted']['value']);
					$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['goodnesswallpapers'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['goodnesswallpapersId'] 		 = $pageListArray['goodnesswallpapersId']['value'];
					$dataArr[$m]['downloadTitle']	 = $pageListArray['downloadTitle']['value'];
					$dataArr[$m]['fileName']	  		= @$pageListArray['fileName']['value'];
					$dataArr[$m]['fileType']	  		= @$pageListArray['fileType']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}
function tools_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['tools'][0]) )	{
		$pageListArray = $pageListArray1['tools'];
		for($i=0;$i <sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value']) =='no'){
					$dataArr[$m]['toolsId'] 	  	  = $pageListArray[$i]['toolsId']['value'];
					$dataArr[$m]['downloadTitle']	  = @$pageListArray[$i]['downloadTitle']['value'];
					$dataArr[$m]['fileName']	  		 = @$pageListArray[$i]['fileName']['value'];
					$dataArr[$m]['fileType']	  		 = @$pageListArray[$i]['fileType']['value'];
					$dataArr[$m]['isDeleted']        = trim($pageListArray[$i]['isDeleted']['value']);
					$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['tools'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['toolsId'] 		 = $pageListArray['toolsId']['value'];
					$dataArr[$m]['downloadTitle']	 = $pageListArray['downloadTitle']['value'];
					$dataArr[$m]['fileName']	  		= @$pageListArray['fileName']['value'];
					$dataArr[$m]['fileType']	  		= @$pageListArray['fileType']['value'];
					$dataArr[$m]['isDeleted']		 = trim($pageListArray[$i]['isDeleted']['value']);			
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}




function claim_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['claim'][0]) )	{		
		$pageListArray = $pageListArray1['claim'];
		for($i=0;$i<sizeof($pageListArray);$i++)
		{
		
			if(trim($pageListArray[$i]['isDeleted']['value'])=='no'){
					$dataArr[$m]['categoryId'] 	  	  =trim(@$pageListArray[$i]['categoryId']['value']);
					$dataArr[$m]['categoryName'] 	  	  =trim(@$pageListArray[$i]['categoryName']['value']);
					$dataArr[$m]['description']	 	 = @$pageListArray[$i]['description']['value'];
					$dataArr[$m]['briefDescription'] = @$pageListArray[$i]['briefDescription']['value'];
					$dataArr[$m]['process'] 			= @$pageListArray[$i]['process']['value'];
					$dataArr[$m]['metaTitle']	 	 = @$pageListArray[$i]['metaTitle']['value'];
					$dataArr[$m]['metaDescription']	 = @$pageListArray[$i]['metaDescription']['value'];
					$dataArr[$m]['metaKeywords']	 = @$pageListArray[$i]['metaKeywords']['value'];
					$dataArr[$m]['thumbnail']	  	 = @$pageListArray[$i]['thumbnail']['value'];
					$dataArr[$m]['isDeleted']        = trim($pageListArray[$i]['isDeleted']['value']);
					$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['claim'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['categoryId'] 		= trim($pageListArray['categoryId']['value']);
					$dataArr[$m]['categoryName'] 	 =trim(@$pageListArray['categoryName']['value']);
					$dataArr[$m]['description']	  	= $pageListArray['description']['value'];
					$dataArr[$m]['briefDescription']= $pageListArray['briefDescription']['value'];
					$dataArr[$m]['process']			= $pageListArray['process']['value'];
					$dataArr[$m]['metaTitle']	  	= $pageListArray['metaTitle']['value'];
					$dataArr[$m]['metaDescription']	= $pageListArray['metaDescription']['value'];
					$dataArr[$m]['metaKeywords']	 = $pageListArray['metaKeywords']['value'];
					$dataArr[$m]['thumbnail']	  	= @$pageListArray['thumbnail']['value'];
					$dataArr[$m]['isDeleted']		= trim($pageListArray[$i]['isDeleted']['value']);		
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}

function subcategory_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['subcategory'][0]) )	{		
		$pageListArray = $pageListArray1['subcategory'];
		for($i=0;$i<sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value'])=='no'){
					$dataArr[$m]['subCategoryId'] 	  = trim($pageListArray[$i]['subCategoryId']['value']);
					$dataArr[$m]['categoryId'] 	  	  =trim(@$pageListArray[$i]['categoryId']['value']);
					$dataArr[$m]['subCategoryName']	  = @$pageListArray[$i]['subCategoryName']['value'];
					$dataArr[$m]['productCode']	  = @$pageListArray[$i]['productCode']['value'];
					$dataArr[$m]['description']	 	 = @$pageListArray[$i]['description']['value'];
					$dataArr[$m]['briefDescription'] = @$pageListArray[$i]['briefDescription']['value'];
					$dataArr[$m]['metaTitle']	 	 = @$pageListArray[$i]['metaTitle']['value'];
					$dataArr[$m]['metaDescription']	 = @$pageListArray[$i]['metaDescription']['value'];
					$dataArr[$m]['metaKeywords']	 = @$pageListArray[$i]['metaKeywords']['value'];
					$dataArr[$m]['compare']	  		 = @$pageListArray[$i]['compare']['value'];
					$dataArr[$m]['exclusions']	 	 =@$pageListArray[$i]['exclusions']['value'];
					$dataArr[$m]['policyTerms']	 	 =@$pageListArray[$i]['policyTerms']['value'];
					$dataArr[$m]['agentpolicyTerms'] =@$pageListArray[$i]['agentpolicyTerms']['value'];
					$dataArr[$m]['claim']	  		 = @$pageListArray[$i]['claim']['value'];
					$dataArr[$m]['logo']	  		 = @$pageListArray[$i]['logo']['value'];
					$dataArr[$m]['thumbnail']	  	 = @$pageListArray[$i]['thumbnail']['value'];
					$dataArr[$m]['isDeleted']        = trim($pageListArray[$i]['isDeleted']['value']);
					$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['subcategory'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['subCategoryId'] 	= trim($pageListArray['subCategoryId']['value']);
					$dataArr[$m]['categoryId'] 		= trim($pageListArray['categoryId']['value']);
					$dataArr[$m]['subCategoryName'] = $pageListArray['subCategoryName']['value'];
					$dataArr[$m]['productCode']	  = @$pageListArray['productCode']['value'];
					$dataArr[$m]['description']	  	= $pageListArray['description']['value'];
					$dataArr[$m]['briefDescription']= $pageListArray['briefDescription']['value'];
					$dataArr[$m]['metaTitle']	  	= $pageListArray['metaTitle']['value'];
					$dataArr[$m]['metaDescription']	= $pageListArray['metaDescription']['value'];
					$dataArr[$m]['metaKeywords']	 = $pageListArray['metaKeywords']['value'];
					$dataArr[$m]['compare']	  		= $pageListArray['compare']['value'];
					$dataArr[$m]['exclusions']	  	= $pageListArray['exclusions']['value'];
					$dataArr[$m]['claim']	 		= $pageListArray['claim']['value'];
					$dataArr[$m]['policyTerms']	 	 =@$pageListArray['policyTerms']['value'];
					$dataArr[$m]['agentpolicyTerms']	 	 =@$pageListArray['agentpolicyTerms']['value'];
					$dataArr[$m]['logo']	  		= @$pageListArray['logo']['value'];
					$dataArr[$m]['thumbnail']	  	= @$pageListArray['thumbnail']['value'];
					$dataArr[$m]['isDeleted']		= trim($pageListArray[$i]['isDeleted']['value']);		
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}

function seo_product_page_array($pageListArray1){
	$m =0;
	$dataArr=array();
	if(is_array(@$pageListArray1['product'][0]) )	{		
		$pageListArray = $pageListArray1['product'];
		for($i=0;$i<sizeof($pageListArray);$i++)
		{
			if(trim($pageListArray[$i]['isDeleted']['value'])=='no'){
					$dataArr[$m]['productId'] 	  = trim($pageListArray[$i]['productId']['value']);
					$dataArr[$m]['productName']	  = @$pageListArray[$i]['productName']['value'];
					$dataArr[$m]['productCode']	  = @$pageListArray[$i]['productCode']['value'];
					$dataArr[$m]['description']	 	 = @$pageListArray[$i]['description']['value'];
					$dataArr[$m]['briefDescription'] = @$pageListArray[$i]['briefDescription']['value'];
					$dataArr[$m]['seourl']	 	 	= @$pageListArray[$i]['seourl']['value'];
					$dataArr[$m]['metaTitle']	 	 = @$pageListArray[$i]['metaTitle']['value'];
					$dataArr[$m]['metaDescription']	 = @$pageListArray[$i]['metaDescription']['value'];
					$dataArr[$m]['metaKeywords']	 = @$pageListArray[$i]['metaKeywords']['value'];
					$dataArr[$m]['compare']	  		 = @$pageListArray[$i]['compare']['value'];
					$dataArr[$m]['exclusions']	 	 =@$pageListArray[$i]['exclusions']['value'];
					$dataArr[$m]['policyTerms']	 	 =@$pageListArray[$i]['policyTerms']['value'];
					$dataArr[$m]['claim']	  		 = @$pageListArray[$i]['claim']['value'];
					$dataArr[$m]['logo']	  		 = @$pageListArray[$i]['logo']['value'];
					$dataArr[$m]['thumbnail']	  	 = @$pageListArray[$i]['thumbnail']['value'];
					$dataArr[$m]['isDeleted']        = trim($pageListArray[$i]['isDeleted']['value']);
					$m++;
			}
		}
	}else	{
			$pageListArray = @$pageListArray1['product'];	
			if(trim($pageListArray['isDeleted']['value']) =='no') 	{
					$dataArr[$m]['productId'] 	= trim($pageListArray['productId']['value']);
					$dataArr[$m]['productName'] = $pageListArray['productName']['value'];
					$dataArr[$m]['productCode']	  = @$pageListArray['productCode']['value'];
					$dataArr[$m]['description']	  	= $pageListArray['description']['value'];
					$dataArr[$m]['briefDescription']= $pageListArray['briefDescription']['value'];
					$dataArr[$m]['seourl']	  	= $pageListArray['seourl']['value'];
					$dataArr[$m]['metaTitle']	  	= $pageListArray['metaTitle']['value'];
					$dataArr[$m]['metaDescription']	= $pageListArray['metaDescription']['value'];
					$dataArr[$m]['metaKeywords']	 = $pageListArray['metaKeywords']['value'];
					$dataArr[$m]['compare']	  		= $pageListArray['compare']['value'];
					$dataArr[$m]['exclusions']	  	= $pageListArray['exclusions']['value'];
					$dataArr[$m]['claim']	 		= $pageListArray['claim']['value'];
					$dataArr[$m]['policyTerms']	 	 =@$pageListArray['policyTerms']['value'];
					$dataArr[$m]['logo']	  		= @$pageListArray['logo']['value'];
					$dataArr[$m]['thumbnail']	  	= @$pageListArray['thumbnail']['value'];
					$dataArr[$m]['isDeleted']		= trim($pageListArray[$i]['isDeleted']['value']);		
					$m++;
				}
	}
//sort by
	if (count ($dataArr) > 0) {
    foreach ($dataArr as $key => $row) {
        @$order_in_category[$key]  = $row[0];//[0] is @$order_in_category
    }
    	@array_multisort(@$order_in_category, SORT_ASC, $dataArr);
	}
return $dataArr;
}

function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}
function pagingFunctionWebsite($a,$stringConcat){
echo " <ul>";
 if($a->getPrevious())
   {
    echo " <li><a href=\"" . $a->getPageName() . "?page=" . $a->getPrevious() .$stringConcat."\"><img src=\"images/page_left_arrow.jpg\" alt=\"Previous\" border=\"0\" style=\"margin-top:4px;\" /></a></li>";
   }
 //start making the numbered links. The method getLinkArr() returns an array of
//all the numbered links that should appear on the page. The method getCurrent()
//returns the current page. I put the values returned in a variable to avoid calling
//the method each time there is a loop.
	$links = $a->getLinkArr();
	$current=$a->getCurrent();

	foreach($links as $link)
	{

 	//if the current page is the same as $link then this number will show in text
	//as the current page. If $link is not the same as the current page then it will 
	//appear as a numbered link.

		if($link == $current)
		{
	   		echo " <li><a href=\"#n\" class=\"pagenum_linkactive\">".$link."</a></li>";
	   		//The method getPageName() gets the name of the page to use in the url.	
		}
		else
		{
			echo " <li><a href=\"" . $a->getPageName() . "?page=$link".$stringConcat."\" class=\"pagenum_link\">".$link."</a></li>";
		}
	}

	if($a->getNext())
 	{
		  echo " <li><a href=\"" . $a->getPageName() . "?page=" . $a->getNext() .$stringConcat."\"><img src=\"images/page_right_arrow.jpg\" alt=\"Next\" border=\"0\" style=\"margin-top:4px;\" /></a></li>";

 	}
}
function pagingFunction($a,$stringConcat){
	if($a->getPrevious())
   {
    echo "<a href=\"" . $a->getPageName() . "?page=" . $a->getPrevious() .$stringConcat."\" class=\"first\"> &laquo; Prev</a> &nbsp;";
   }
 //start making the numbered links. The method getLinkArr() returns an array of
//all the numbered links that should appear on the page. The method getCurrent()
//returns the current page. I put the values returned in a variable to avoid calling
//the method each time there is a loop.
	$links = $a->getLinkArr();
	$current=$a->getCurrent();

	foreach($links as $link)
	{

 	//if the current page is the same as $link then this number will show in text
	//as the current page. If $link is not the same as the current page then it will 
	//appear as a numbered link.

		if($link == $current)
		{
	   		echo " <a href='#n' class='width_225_active'>".$link."</a> ";
	   		//The method getPageName() gets the name of the page to use in the url.	
		}
		else
		{
	  		echo "<a href=\"" . $a->getPageName() . "?page=$link".$stringConcat."\">" . $link . "</a> ";
		}
	}

	if($a->getNext())
 	{
    	echo "<a href=\"" . $a->getPageName() . "?page=" . $a->getNext().$stringConcat."\" class=\"first\">Next  &raquo;</a> ";

 	}
}
function GetImageSrc($strSortBy,$strOrder,$strFieldName)
	{
		if(strcasecmp($strSortBy,$strFieldName)==0 )
			return $strOrder ? '<img border=0 src="' . _WWWROOT . '/images/arrow_up.jpg">' : '<img border=0 src="' . _WWWROOT . '/images/arrow.jpg">';
		else
			return '';
	}
function GetFullUrl($strSortBy,$pagerow,$strOrder,$_ord,$stringConcat){
	    $basicUrl="http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
		$qryString=removeSelf($_SERVER['QUERY_STRING']);			// remove additional query which is added by this script
		$strQueryString="_ord=".$_ord."&_sby=".$strSortBy."&pagerow=".$pagerow;
		if($qryString!=""){
			$strUrl= $basicUrl;
			$strQueryStringConnector="?";
		}
		else{
			$strUrl= $basicUrl;
			$strQueryStringConnector="?";
		}
		return $strUrl . $strQueryStringConnector.$strQueryString.$stringConcat; 
	}	

function removeSelf($string)
	{
		// remove query string which is added by this class
		$qArr=split("&", $string);
		$retString="";
		if(!empty($qArr))
		{
			for($i=0;$i<count($qArr); $i++)
			{
				switch(strtolower((substr($qArr[$i],0,4))))
				{
					case "_pge":
					case "_rec":
						break;
					default :
						$retString.=$qArr[$i] . "&";
				}
			}
		}
		return substr($retString,0,-1);
	}
function getMyslFormatDate($check_in)
{
	if($check_in!=''){
	$dd=substr($check_in,0,2);
	$mm=substr($check_in,3,2);
	$yy=substr($check_in,6,4);	
	return $yy.'-'.$mm.'-'.$dd;	
	}else{
	return $check_in;
	}
}
function getIndianFormatDate($check_in)
{
	if($check_in!="")
	{
	$dd=substr($check_in,8,2);
	$mm=substr($check_in,5,2);
	$yy=substr($check_in,0,4);	
	return $dd.'-'.$mm.'-'.$yy;	
	}
	else
	{
	  return "";
	}
}
function touploadItem($filedName ,$target_path,$filename)
{
	$target_path = $target_path.$filename;
	  if(move_uploaded_file($_FILES[$filedName]['tmp_name'], $target_path)) 
		{
			chmod($target_path,0777); 
			//echo "The file ". basename( $_FILES['file']['name']). " has been uploaded";
			//$upload_item=basename($prefix.$_FILES[$filedName]['name']);				
		}
		return $filename;
}
function toHAndleSpace($string)
{
   $string = ereg_replace("[ \t\n\r]+", " ", $string); 
   $text = str_replace(" ","_", $string);
	return $text;  
	}
	
/* Database Functions */
function get_branch_locator(){			
		$sqlBranch="SELECT * FROM `branchlocator`  WHERE `isDeleted`='0' AND `isPublished`='1' ";
		$resultBranch=mysql_query($sqlBranch);
		return mysql_num_rows($resultBranch);
	}
function get_hospital_locator(){			
		$sqlHospitalLocator="SELECT * FROM `hospitallocator`  WHERE `isDeleted`='0' AND `isPublished`='1' ";
		$resultHospitalLocator=mysql_query($sqlHospitalLocator);
		return mysql_num_rows($resultHospitalLocator);
	}
function get_jobs(){			
		$sqlJobs="SELECT * FROM `jobs`  WHERE `isDeleted`='0' AND `isPublished`='1' ";
		$resultJobs=mysql_query($sqlJobs);
		return mysql_num_rows($resultJobs);
	}
function get_static_pages(){			
		$sqlStaticPages="SELECT * FROM `staticpages`  WHERE `isDeleted`='0' AND `isPublished`='1' ";
		$resultStaticPages=mysql_query($sqlStaticPages);
		return mysql_num_rows($resultStaticPages);
	}
 function get_updates(){            
        $sqlStaticPages="SELECT * FROM `logfile`  WHERE `isEdited`='1' ";
        $resultStaticPages=mysql_query($sqlStaticPages);
        return mysql_num_rows($resultStaticPages);
    }   

function get_record_data($table_name, $primary_key, $primary_value,$field)
	{			
		$query = "select `$field` from `$table_name` where `$primary_key`='$primary_value' limit 1";			
		$result= mysql_query($query);			
		if ($result)			
		{			
			$row=mysql_fetch_row($result);			
			$field_value = stripslashes($row[0]);			
		}			
		else			
		{			
			echo "Problem  in function";			
		}			
		if($field_value=='0')			
		{			
			$field_value="";			
		}	
		//$searchArray1  = array("/userfiles/");
		//$replaceArray1 = array(_PHOTOPATH);
	//	$field_value = str_replace($searchArray1, $replaceArray1, $field_value);
		return $field_value;
	}
function fetchListCond($table,$cond){
	global $conn;
	$dataArray=array();
		$query="SELECT * FROM $table $cond";
		$sql = @oci_parse($conn, $query);
		// Execute Query
		@oci_execute($sql);
		$i=0;
		while (($row = oci_fetch_array($sql))) {
			foreach($row as $key=>$value){
				$dataArray[$i][$key] = $value;				
			}
			$i++;
		}
	return $dataArray;
}
function scriptname()
{
                $script_name=substr(strrchr($_SERVER['SCRIPT_NAME'],'/'),1);
                return $script_name;
}


function addServiceTax($premium = array()){
    $newPremium = array();
    $newPremiumValue = '';
     if(count($premium)>0){
         foreach($premium as $premiumIndex=>$premiumValue){
             if(is_numeric(trim(sanitize_data($premiumValue)))){
             $newPremiumValue = sanitize_data($premiumValue)*1.014596;
             $newPremiumValue = round($newPremiumValue);
             } else {
                 $newPremiumValue = $premiumValue;
             }
             array_push($newPremium, $newPremiumValue);
         }
     }    
    return $newPremium;
}
function servicesTax($premium){
       return round(trim(sanitize_data($premium))*1.014596);
}

?>