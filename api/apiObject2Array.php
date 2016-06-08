<?php
	include_once('xml2array.php');
	include_once("domxml-php4-to-php5.php");
	function object2array($data,$objectType)
	{
		$outputArray = array();
		switch ($objectType){
		
		 case 'PolicyEnquiry':	
				$converter= new xml2array($data); 
				$dataArr=$converter->getResult();
				//echo "<pre>";print_r($dataArr);			
				$error  = @$dataArr['SOAP:Envelope']['SOAP:Body']['SOAP:Fault']['detail']['bpm:FaultDetails']['cordys:FaultDetailString']['#text'];				
				if(isset($error)){	
					$error = "Please try after some time.";
					$_SESSION['response_error'] = @$error;					
				}else{
					$outputArray['owner_number'] 	= @$dataArr['SOAP:Envelope']['SOAP:Body']['getPolicyEnquiryResponse']['RESMSG2']['copybook']['POLENQO-REC']['MESSAGE-DATA']['ADDITIONAL-FIELDS']['BGEN-OWNERNUM']['#text'];
					$outputArray['owner_name']   	= @$dataArr['SOAP:Envelope']['SOAP:Body']['getPolicyEnquiryResponse']['RESMSG2']['copybook']['POLENQO-REC']['MESSAGE-DATA']['ADDITIONAL-FIELDS']['BGEN-OWNERNAME']['#text'];
					
					$outputArray['policy_number'] 	= @$dataArr['SOAP:Envelope']['SOAP:Body']['getPolicyEnquiryResponse']['RESMSG2']['copybook']['POLENQO-REC']['MESSAGE-DATA']['ADDITIONAL-FIELDS']['BGEN-CHDRNUM']['#text'];
					$outputArray['dataArr']       	= @$dataArr['SOAP:Envelope']['SOAP:Body']['getPolicyEnquiryResponse']['RESMSG2']['copybook']['POLENQO-REC']['MESSAGE-DATA']['ADDITIONAL-FIELDS']['BGEN-DPNTDTL'];
					
					$counter = 0;
					$responseArray = array();
					
					if(is_array(@$outputArray['dataArr'])){		
						foreach(@$outputArray['dataArr'] as $key  => $value){ 	
								if(count($value) == 1){
									$counter = 0;
									$responseArray[$counter][$key] = $value;
								}else{
									if($value['BGEN-MEMNAME']['#text']){
										$responseArray[$counter] = $value;
									}
								}
							$counter++;			
						}
					}
					$_SESSION['dataArray'] 		= @$responseArray;
					$_SESSION['policyNumber'] 	= @$outputArray['policy_number'];
					$_SESSION['owner_name'] 	= @$outputArray['owner_name'];
					$_SESSION['owner_number'] 	= @$outputArray['owner_number'];					
				}	
				
				return $_SESSION;			
				break;
				case 'ALPeriodEnquiry':
				$converter= new xml2array($data); 
				$dataArr=$converter->getResult();
				$dataOut=array();
				$dataArray  = @$dataArr['SOAP:Envelope']['SOAP:Body']['GetZclhpfObjectbyParametersResponse']['tuple'];
				$c=0;	
				if(@$dataArray['old']['ZCLHPF']['CHDRNUM']['#text']!=''){
					$dataOut[$c]['CLMCOY']		=@$dataArray['old']['ZCLHPF']['CLMCOY']['#text'];
					$dataOut[$c]['PREAUTNO']	=@$dataArray['old']['ZCLHPF']['PREAUTNO']['#text'];
					$dataOut[$c]['GCOCCNO']		=@$dataArray['old']['ZCLHPF']['GCOCCNO']['#text'];
					$dataOut[$c]['CHDRNUM']		=@$dataArray['old']['ZCLHPF']['CHDRNUM']['#text'];
					$dataOut[$c]['MBRNO']		=@$dataArray['old']['ZCLHPF']['MBRNO']['#text'];
					$dataOut[$c]['DPNTNO']		=@$dataArray['old']['ZCLHPF']['DPNTNO']['#text'];
					$dataOut[$c]['CLNTCOY']		=@$dataArray['old']['ZCLHPF']['CLNTCOY']['#text'];
					$dataOut[$c]['CLNTNUM']		=@$dataArray['old']['ZCLHPF']['CLNTNUM']['#text'];
					$dataOut[$c]['GCSTS']		=@$dataArray['old']['ZCLHPF']['GCSTS']['#text'];
					$dataOut[$c]['CLAIMCUR']	=@$dataArray['old']['ZCLHPF']['CLAIMCUR']['#text'];
					$dataOut[$c]['CRATE']		=@$dataArray['old']['ZCLHPF']['CRATE']['#text'];
					$dataOut[$c]['PRODTYP']		=@$dataArray['old']['ZCLHPF']['PRODTYP']['#text'];
					$dataOut[$c]['DTEVISIT']	=@$dataArray['old']['ZCLHPF']['DTEVISIT']['#text'];
					$dataOut[$c]['GCDIAGCD']	=@$dataArray['old']['ZCLHPF']['GCDIAGCD']['#text'];
					$dataOut[$c]['PLANNO']		=@$dataArray['old']['ZCLHPF']['PLANNO']['#text'];
					$dataOut[$c]['CLAMNUM']		=@$dataArray['old']['ZCLHPF']['CLAMNUM']['#text'];
					$dataOut[$c]['PROVORG']		=@$dataArray['old']['ZCLHPF']['PROVORG']['#text'];
					$dataOut[$c]['AREACDE']		=@$dataArray['old']['ZCLHPF']['AREACDE']['#text'];
					$dataOut[$c]['REFERRER']	=@$dataArray['old']['ZCLHPF']['REFERRER']['#text'];
					$dataOut[$c]['CLAMTYPE']	=@$dataArray['old']['ZCLHPF']['CLAMTYPE']['#text'];
					$dataOut[$c]['CLIENT_CLAIM_REF']		=@$dataArray['old']['ZCLHPF']['CLIENT_CLAIM_REF']['#text'];
					$dataOut[$c]['GCDTHCLM']		=@$dataArray['old']['ZCLHPF']['GCDTHCLM']['#text'];
					$dataOut[$c]['APAIDAMT']		=@$dataArray['old']['ZCLHPF']['APAIDAMT']['#text'];
					$dataOut[$c]['REQNTYPE']		=@$dataArray['old']['ZCLHPF']['REQNTYPE']['#text'];
					$dataOut[$c]['CRDTCARD']		=@$dataArray['old']['ZCLHPF']['CRDTCARD']['#text'];
					$dataOut[$c]['WHOPAID']		=@$dataArray['old']['ZCLHPF']['WHOPAID']['#text'];
					$dataOut[$c]['DTEKNOWN']		=@$dataArray['old']['ZCLHPF']['DTEKNOWN']['#text'];
					$dataOut[$c]['GCFRPDTE']		=@$dataArray['old']['ZCLHPF']['GCFRPDTE']['#text'];
					$dataOut[$c]['RECVD_DATE']		=@$dataArray['old']['ZCLHPF']['RECVD_DATE']['#text'];
					$dataOut[$c]['MCFROM']		=@$dataArray['old']['ZCLHPF']['MCFROM']['#text'];
					$dataOut[$c]['MCTO']		=@$dataArray['old']['ZCLHPF']['MCTO']['#text'];
					$dataOut[$c]['GDEDUCT']		=@$dataArray['old']['ZCLHPF']['GDEDUCT']['#text'];
					$dataOut[$c]['COPAY']		=@$dataArray['old']['ZCLHPF']['COPAY']['#text'];
					$dataOut[$c]['MBRTYPE']		=@$dataArray['old']['ZCLHPF']['MBRTYPE']['#text'];
					$dataOut[$c]['PROVNET']		=@$dataArray['old']['ZCLHPF']['PROVNET']['#text'];
					$dataOut[$c]['AAD']		=@$dataArray['old']['ZCLHPF']['AAD']['#text'];
					$dataOut[$c]['THIRDRCVY']		=@$dataArray['old']['ZCLHPF']['THIRDRCVY']['#text'];
					$dataOut[$c]['THIRDPARTY']		=@$dataArray['old']['ZCLHPF']['THIRDPARTY']['#text'];
					$dataOut[$c]['TLMBRSHR']		=@$dataArray['old']['ZCLHPF']['TLMBRSHR']['#text'];
					$dataOut[$c]['TLHMOSHR']		=@$dataArray['old']['ZCLHPF']['TLHMOSHR']['#text'];
					$dataOut[$c]['DATEAUTH']		=@$dataArray['old']['ZCLHPF']['DATEAUTH']['#text'];
					$dataOut[$c]['GCAUTHBY']		=@$dataArray['old']['ZCLHPF']['GCAUTHBY']['#text'];
					$dataOut[$c]['GCOPRSCD']		=@$dataArray['old']['ZCLHPF']['GCOPRSCD']['#text'];
					$dataOut[$c]['REVLINK']		=@$dataArray['old']['ZCLHPF']['REVLINK']['#text'];
					$dataOut[$c]['TPRCVPND']		=@$dataArray['old']['ZCLHPF']['TPRCVPND']['#text'];
					$dataOut[$c]['PENDFROM']		=@$dataArray['old']['ZCLHPF']['PENDFROM']['#text'];
					$dataOut[$c]['MMPROD']		=@$dataArray['old']['ZCLHPF']['MMPROD']['#text'];
					$dataOut[$c]['HMOSHRMM']		=@$dataArray['old']['ZCLHPF']['HMOSHRMM']['#text'];
					$dataOut[$c]['TAKEUP']		=@$dataArray['old']['ZCLHPF']['TAKEUP']['#text'];
					$dataOut[$c]['DATACONV']		=@$dataArray['old']['ZCLHPF']['DATACONV']['#text'];
					$dataOut[$c]['CLRATE']		=@$dataArray['old']['ZCLHPF']['CLRATE']['#text'];
					$dataOut[$c]['REFNO']		=@$dataArray['old']['ZCLHPF']['REFNO']['#text'];
					$dataOut[$c]['UPDATE_IND']		=@$dataArray['old']['ZCLHPF']['UPDATE_IND']['#text'];
					$dataOut[$c]['ROOMTYPE']		=@$dataArray['old']['ZCLHPF']['ROOMTYPE']['#text'];
					$dataOut[$c]['BNFTGRP']		=@$dataArray['old']['ZCLHPF']['BNFTGRP']['#text'];
					$dataOut[$c]['CLMSRVTP']		=@$dataArray['old']['ZCLHPF']['CLMSRVTP']['#text'];
					$dataOut[$c]['REVERSAL_IND']		=@$dataArray['old']['ZCLHPF']['REVERSAL_IND']['#text'];					
					$dataOut[$c]['GRSKCLS']		=@$dataArray['old']['ZCLHPF']['GRSKCLS']['#text'];
					$dataOut[$c]['TIMEHH01']		=@$dataArray['old']['ZCLHPF']['TIMEHH01']['#text'];
					$dataOut[$c]['TIMEHH02']		=@$dataArray['old']['ZCLHPF']['TIMEHH02']['#text'];
					$dataOut[$c]['TIMEMM01']		=@$dataArray['old']['ZCLHPF']['TIMEMM01']['#text'];
					$dataOut[$c]['TIMEMM02']		=@$dataArray['old']['ZCLHPF']['TIMEMM02']['#text'];
					$dataOut[$c]['PATNTYN']		=@$dataArray['old']['ZCLHPF']['PATNTYN']['#text'];
					$dataOut[$c]['PEDYN']		=@$dataArray['old']['ZCLHPF']['PEDYN']['#text'];
					$dataOut[$c]['CAUSECD']		=@$dataArray['old']['ZCLHPF']['CAUSECD']['#text'];
					$dataOut[$c]['GTCFSHARE']		=@$dataArray['old']['ZCLHPF']['GTCFSHARE']['#text'];					
					$dataOut[$c]['TCFSHARE']		=@$dataArray['old']['ZCLHPF']['TCFSHARE']['#text'];
					$dataOut[$c]['ZTCFSHARE']		=@$dataArray['old']['ZCLHPF']['ZTCFSHARE']['#text'];
					$dataOut[$c]['CFYNFLG']		=@$dataArray['old']['ZCLHPF']['CFYNFLG']['#text'];
					$dataOut[$c]['DATEEND']		=@$dataArray['old']['ZCLHPF']['DATEEND']['#text'];
					$dataOut[$c]['DTEDCHRG']		=@$dataArray['old']['ZCLHPF']['DTEDCHRG']['#text'];
					$dataOut[$c]['TRAVELDUR']		=@$dataArray['old']['ZCLHPF']['TRAVELDUR']['#text'];
					$dataOut[$c]['INWRDNO']		=@$dataArray['old']['ZCLHPF']['INWRDNO']['#text'];
					$dataOut[$c]['PFACTOR01']		=@$dataArray['old']['ZCLHPF']['PFACTOR01']['#text'];
					$dataOut[$c]['PFACTOR02']		=@$dataArray['old']['ZCLHPF']['PFACTOR02']['#text'];					
					$dataOut[$c]['PRATANUM01']		=@$dataArray['old']['ZCLHPF']['PRATANUM01']['#text'];
					$dataOut[$c]['PRATANUM02']		=@$dataArray['old']['ZCLHPF']['PRATANUM02']['#text'];
					$dataOut[$c]['PRATADEN01']		=@$dataArray['old']['ZCLHPF']['PRATADEN01']['#text'];
					$dataOut[$c]['PRATADEN02']		=@$dataArray['old']['ZCLHPF']['PRATADEN02']['#text'];
					$dataOut[$c]['COPAYAMT']		=@$dataArray['old']['ZCLHPF']['COPAYAMT']['#text'];
					$dataOut[$c]['REPRCNGTOT']		=@$dataArray['old']['ZCLHPF']['REPRCNGTOT']['#text'];
					$dataOut[$c]['GCADMDT']			=@$dataArray['old']['ZCLHPF']['GCADMDT']['#text'];
					$dataOut[$c]['ZAMTDAY']			=@$dataArray['old']['ZCLHPF']['ZAMTDAY']['#text'];
					$dataOut[$c]['ZAMTDAYI']		=@$dataArray['old']['ZCLHPF']['ZAMTDAYI']['#text'];			
					$dataOut[$c]['ZRNBALW']			=@$dataArray['old']['ZCLHPF']['ZRNBALW']['#text'];
					$dataOut[$c]['ZICUALW']			=@$dataArray['old']['ZCLHPF']['ZICUALW']['#text'];
					$dataOut[$c]['CFCOPAY']			=@$dataArray['old']['ZCLHPF']['CFCOPAY']['#text'];
					$dataOut[$c]['ZSECSTS']			=@$dataArray['old']['ZCLHPF']['ZSECSTS']['#text'];
					$dataOut[$c]['ZCLMSTS']			=@$dataArray['old']['ZCLHPF']['ZCLMSTS']['#text'];
					$dataOut[$c]['CPTCODE']			=@$dataArray['old']['ZCLHPF']['CPTCODE']['#text'];
					$dataOut[$c]['USRHMO']			=@$dataArray['old']['ZCLHPF']['USRHMO']['#text'];
					$dataOut[$c]['USER_PROFILE']	=@$dataArray['old']['ZCLHPF']['USER_PROFILE']['#text'];
					$dataOut[$c]['JOB_NAME']		=@$dataArray['old']['ZCLHPF']['JOB_NAME']['#text'];
					$dataOut[$c]['DATIME']			=@$dataArray['old']['ZCLHPF']['DATIME']['#text'];
					$dataOut[$c]['LSURNAME']		=@$dataArray['old']['ZCLHPF']['LSURNAME']['#text'];
					$dataOut[$c]['LGIVNAME']		=@$dataArray['old']['ZCLHPF']['LGIVNAME']['#text'];
					$c++;
				}	
				for($k=0;$k<count(@$dataArray);$k++){
						if(trim(@$dataArray[$k]['old']['ZCLHPF']['CHDRNUM']['#text'])!=''){
					$dataOut[$c]['CLMCOY']		=@$dataArray[$k]['old']['ZCLHPF']['CLMCOY']['#text'];
					$dataOut[$c]['PREAUTNO']	=@$dataArray[$k]['old']['ZCLHPF']['PREAUTNO']['#text'];
					$dataOut[$c]['GCOCCNO']		=@$dataArray[$k]['old']['ZCLHPF']['GCOCCNO']['#text'];
					$dataOut[$c]['CHDRNUM']		=@$dataArray[$k]['old']['ZCLHPF']['CHDRNUM']['#text'];
					$dataOut[$c]['MBRNO']		=@$dataArray[$k]['old']['ZCLHPF']['MBRNO']['#text'];
					$dataOut[$c]['DPNTNO']		=@$dataArray[$k]['old']['ZCLHPF']['DPNTNO']['#text'];
					$dataOut[$c]['CLNTCOY']		=@$dataArray[$k]['old']['ZCLHPF']['CLNTCOY']['#text'];
					$dataOut[$c]['CLNTNUM']		=@$dataArray[$k]['old']['ZCLHPF']['CLNTNUM']['#text'];
					$dataOut[$c]['GCSTS']		=@$dataArray[$k]['old']['ZCLHPF']['GCSTS']['#text'];
					$dataOut[$c]['CLAIMCUR']	=@$dataArray[$k]['old']['ZCLHPF']['CLAIMCUR']['#text'];
					$dataOut[$c]['CRATE']		=@$dataArray[$k]['old']['ZCLHPF']['CRATE']['#text'];
					$dataOut[$c]['PRODTYP']		=@$dataArray[$k]['old']['ZCLHPF']['PRODTYP']['#text'];
					$dataOut[$c]['DTEVISIT']	=@$dataArray[$k]['old']['ZCLHPF']['DTEVISIT']['#text'];
					$dataOut[$c]['GCDIAGCD']	=@$dataArray[$k]['old']['ZCLHPF']['GCDIAGCD']['#text'];
					$dataOut[$c]['PLANNO']		=@$dataArray[$k]['old']['ZCLHPF']['PLANNO']['#text'];
					$dataOut[$c]['CLAMNUM']		=@$dataArray[$k]['old']['ZCLHPF']['CLAMNUM']['#text'];
					$dataOut[$c]['PROVORG']		=@$dataArray[$k]['old']['ZCLHPF']['PROVORG']['#text'];
					$dataOut[$c]['AREACDE']		=@$dataArray[$k]['old']['ZCLHPF']['AREACDE']['#text'];
					$dataOut[$c]['REFERRER']	=@$dataArray[$k]['old']['ZCLHPF']['REFERRER']['#text'];
					$dataOut[$c]['CLAMTYPE']	=@$dataArray[$k]['old']['ZCLHPF']['CLAMTYPE']['#text'];
					$dataOut[$c]['CLIENT_CLAIM_REF']		=@$dataArray[$k]['old']['ZCLHPF']['CLIENT_CLAIM_REF']['#text'];
					$dataOut[$c]['GCDTHCLM']		=@$dataArray[$k]['old']['ZCLHPF']['GCDTHCLM']['#text'];
					$dataOut[$c]['APAIDAMT']		=@$dataArray[$k]['old']['ZCLHPF']['APAIDAMT']['#text'];
					$dataOut[$c]['REQNTYPE']		=@$dataArray[$k]['old']['ZCLHPF']['REQNTYPE']['#text'];
					$dataOut[$c]['CRDTCARD']		=@$dataArray[$k]['old']['ZCLHPF']['CRDTCARD']['#text'];
					$dataOut[$c]['WHOPAID']		=@$dataArray[$k]['old']['ZCLHPF']['WHOPAID']['#text'];
					$dataOut[$c]['DTEKNOWN']		=@$dataArray[$k]['old']['ZCLHPF']['DTEKNOWN']['#text'];
					$dataOut[$c]['GCFRPDTE']		=@$dataArray[$k]['old']['ZCLHPF']['GCFRPDTE']['#text'];
					$dataOut[$c]['RECVD_DATE']		=@$dataArray[$k]['old']['ZCLHPF']['RECVD_DATE']['#text'];
					$dataOut[$c]['MCFROM']		=@$dataArray[$k]['old']['ZCLHPF']['MCFROM']['#text'];
					$dataOut[$c]['MCTO']		=@$dataArray[$k]['old']['ZCLHPF']['MCTO']['#text'];
					$dataOut[$c]['GDEDUCT']		=@$dataArray[$k]['old']['ZCLHPF']['GDEDUCT']['#text'];
					$dataOut[$c]['COPAY']		=@$dataArray[$k]['old']['ZCLHPF']['COPAY']['#text'];
					$dataOut[$c]['MBRTYPE']		=@$dataArray[$k]['old']['ZCLHPF']['MBRTYPE']['#text'];
					$dataOut[$c]['PROVNET']		=@$dataArray[$k]['old']['ZCLHPF']['PROVNET']['#text'];
					$dataOut[$c]['AAD']		=@$dataArray[$k]['old']['ZCLHPF']['AAD']['#text'];
					$dataOut[$c]['THIRDRCVY']		=@$dataArray[$k]['old']['ZCLHPF']['THIRDRCVY']['#text'];
					$dataOut[$c]['THIRDPARTY']		=@$dataArray[$k]['old']['ZCLHPF']['THIRDPARTY']['#text'];
					$dataOut[$c]['TLMBRSHR']		=@$dataArray[$k]['old']['ZCLHPF']['TLMBRSHR']['#text'];
					$dataOut[$c]['TLHMOSHR']		=@$dataArray[$k]['old']['ZCLHPF']['TLHMOSHR']['#text'];
					$dataOut[$c]['DATEAUTH']		=@$dataArray[$k]['old']['ZCLHPF']['DATEAUTH']['#text'];
					$dataOut[$c]['GCAUTHBY']		=@$dataArray[$k]['old']['ZCLHPF']['GCAUTHBY']['#text'];
					$dataOut[$c]['GCOPRSCD']		=@$dataArray[$k]['old']['ZCLHPF']['GCOPRSCD']['#text'];
					$dataOut[$c]['REVLINK']		=@$dataArray[$k]['old']['ZCLHPF']['REVLINK']['#text'];
					$dataOut[$c]['TPRCVPND']		=@$dataArray[$k]['old']['ZCLHPF']['TPRCVPND']['#text'];
					$dataOut[$c]['PENDFROM']		=@$dataArray[$k]['old']['ZCLHPF']['PENDFROM']['#text'];
					$dataOut[$c]['MMPROD']		=@$dataArray[$k]['old']['ZCLHPF']['MMPROD']['#text'];
					$dataOut[$c]['HMOSHRMM']		=@$dataArray[$k]['old']['ZCLHPF']['HMOSHRMM']['#text'];
					$dataOut[$c]['TAKEUP']		=@$dataArray[$k]['old']['ZCLHPF']['TAKEUP']['#text'];
					$dataOut[$c]['DATACONV']		=@$dataArray[$k]['old']['ZCLHPF']['DATACONV']['#text'];
					$dataOut[$c]['CLRATE']		=@$dataArray[$k]['old']['ZCLHPF']['CLRATE']['#text'];
					$dataOut[$c]['REFNO']		=@$dataArray[$k]['old']['ZCLHPF']['REFNO']['#text'];
					$dataOut[$c]['UPDATE_IND']		=@$dataArray[$k]['old']['ZCLHPF']['UPDATE_IND']['#text'];
					$dataOut[$c]['ROOMTYPE']		=@$dataArray[$k]['old']['ZCLHPF']['ROOMTYPE']['#text'];
					$dataOut[$c]['BNFTGRP']		=@$dataArray[$k]['old']['ZCLHPF']['BNFTGRP']['#text'];
					$dataOut[$c]['CLMSRVTP']		=@$dataArray[$k]['old']['ZCLHPF']['CLMSRVTP']['#text'];
					$dataOut[$c]['REVERSAL_IND']		=@$dataArray[$k]['old']['ZCLHPF']['REVERSAL_IND']['#text'];					
					$dataOut[$c]['GRSKCLS']		=@$dataArray[$k]['old']['ZCLHPF']['GRSKCLS']['#text'];
					$dataOut[$c]['TIMEHH01']		=@$dataArray[$k]['old']['ZCLHPF']['TIMEHH01']['#text'];
					$dataOut[$c]['TIMEHH02']		=@$dataArray[$k]['old']['ZCLHPF']['TIMEHH02']['#text'];
					$dataOut[$c]['TIMEMM01']		=@$dataArray[$k]['old']['ZCLHPF']['TIMEMM01']['#text'];
					$dataOut[$c]['TIMEMM02']		=@$dataArray[$k]['old']['ZCLHPF']['TIMEMM02']['#text'];
					$dataOut[$c]['PATNTYN']		=@$dataArray[$k]['old']['ZCLHPF']['PATNTYN']['#text'];
					$dataOut[$c]['PEDYN']		=@$dataArray[$k]['old']['ZCLHPF']['PEDYN']['#text'];
					$dataOut[$c]['CAUSECD']		=@$dataArray[$k]['old']['ZCLHPF']['CAUSECD']['#text'];
					$dataOut[$c]['GTCFSHARE']		=@$dataArray[$k]['old']['ZCLHPF']['GTCFSHARE']['#text'];					
					$dataOut[$c]['TCFSHARE']		=@$dataArray[$k]['old']['ZCLHPF']['TCFSHARE']['#text'];
					$dataOut[$c]['ZTCFSHARE']		=@$dataArray[$k]['old']['ZCLHPF']['ZTCFSHARE']['#text'];
					$dataOut[$c]['CFYNFLG']		=@$dataArray[$k]['old']['ZCLHPF']['CFYNFLG']['#text'];
					$dataOut[$c]['DATEEND']		=@$dataArray[$k]['old']['ZCLHPF']['DATEEND']['#text'];
					$dataOut[$c]['DTEDCHRG']		=@$dataArray[$k]['old']['ZCLHPF']['DTEDCHRG']['#text'];
					$dataOut[$c]['TRAVELDUR']		=@$dataArray[$k]['old']['ZCLHPF']['TRAVELDUR']['#text'];
					$dataOut[$c]['INWRDNO']		=@$dataArray[$k]['old']['ZCLHPF']['INWRDNO']['#text'];
					$dataOut[$c]['PFACTOR01']		=@$dataArray[$k]['old']['ZCLHPF']['PFACTOR01']['#text'];
					$dataOut[$c]['PFACTOR02']		=@$dataArray[$k]['old']['ZCLHPF']['PFACTOR02']['#text'];					
					$dataOut[$c]['PRATANUM01']		=@$dataArray[$k]['old']['ZCLHPF']['PRATANUM01']['#text'];
					$dataOut[$c]['PRATANUM02']		=@$dataArray[$k]['old']['ZCLHPF']['PRATANUM02']['#text'];
					$dataOut[$c]['PRATADEN01']		=@$dataArray[$k]['old']['ZCLHPF']['PRATADEN01']['#text'];
					$dataOut[$c]['PRATADEN02']		=@$dataArray[$k]['old']['ZCLHPF']['PRATADEN02']['#text'];
					$dataOut[$c]['COPAYAMT']		=@$dataArray[$k]['old']['ZCLHPF']['COPAYAMT']['#text'];
					$dataOut[$c]['REPRCNGTOT']		=@$dataArray[$k]['old']['ZCLHPF']['REPRCNGTOT']['#text'];
					$dataOut[$c]['GCADMDT']			=@$dataArray[$k]['old']['ZCLHPF']['GCADMDT']['#text'];
					$dataOut[$c]['ZAMTDAY']			=@$dataArray[$k]['old']['ZCLHPF']['ZAMTDAY']['#text'];
					$dataOut[$c]['ZAMTDAYI']		=@$dataArray[$k]['old']['ZCLHPF']['ZAMTDAYI']['#text'];			
					$dataOut[$c]['ZRNBALW']			=@$dataArray[$k]['old']['ZCLHPF']['ZRNBALW']['#text'];
					$dataOut[$c]['ZICUALW']			=@$dataArray[$k]['old']['ZCLHPF']['ZICUALW']['#text'];
					$dataOut[$c]['CFCOPAY']			=@$dataArray[$k]['old']['ZCLHPF']['CFCOPAY']['#text'];
					$dataOut[$c]['ZSECSTS']			=@$dataArray[$k]['old']['ZCLHPF']['ZSECSTS']['#text'];
					$dataOut[$c]['ZCLMSTS']			=@$dataArray[$k]['old']['ZCLHPF']['ZCLMSTS']['#text'];
					$dataOut[$c]['CPTCODE']			=@$dataArray[$k]['old']['ZCLHPF']['CPTCODE']['#text'];
					$dataOut[$c]['USRHMO']			=@$dataArray[$k]['old']['ZCLHPF']['USRHMO']['#text'];
					$dataOut[$c]['USER_PROFILE']	=@$dataArray[$k]['old']['ZCLHPF']['USER_PROFILE']['#text'];
					$dataOut[$c]['JOB_NAME']		=@$dataArray[$k]['old']['ZCLHPF']['JOB_NAME']['#text'];
					$dataOut[$c]['DATIME']			=@$dataArray[$k]['old']['ZCLHPF']['DATIME']['#text'];
					$dataOut[$c]['LSURNAME']		=@$dataArray[$k]['old']['ZCLHPF']['LSURNAME']['#text'];
					$dataOut[$c]['LGIVNAME']		=@$dataArray[$k]['old']['ZCLHPF']['LGIVNAME']['#text'];
							$c++;
						}					
				}
				return $dataOut;		
				break;
				case 'ClaimPeriodEnquiry':
				$converter= new xml2array($data); 
				$dataArr=$converter->getResult();
				$dataOut=array();
				$dataArray  = @$dataArr['SOAP:Envelope']['SOAP:Body']['GetGclhpfObjectsByParametersResponse']['tuple'];
				$c=0;	
				if(@$dataArray['old']['GCLHPF']['CLAMNUM']['#text']!=''){
					$dataOut[$c]['CLMCOY']		=@$dataArray['old']['GCLHPF']['CLMCOY']['#text'];
					$dataOut[$c]['PREAUTNO']	=@$dataArray['old']['GCLHPF']['PREAUTNO']['#text'];
					$dataOut[$c]['GCOCCNO']		=@$dataArray['old']['GCLHPF']['GCOCCNO']['#text'];
					$dataOut[$c]['CHDRNUM']		=@$dataArray['old']['GCLHPF']['CHDRNUM']['#text'];
					$dataOut[$c]['MBRNO']		=@$dataArray['old']['GCLHPF']['MBRNO']['#text'];
					$dataOut[$c]['DPNTNO']		=@$dataArray['old']['GCLHPF']['DPNTNO']['#text'];
					$dataOut[$c]['CLNTCOY']		=@$dataArray['old']['GCLHPF']['CLNTCOY']['#text'];
					$dataOut[$c]['CLNTNUM']		=@$dataArray['old']['GCLHPF']['CLNTNUM']['#text'];
					$dataOut[$c]['GCSTS']		=@$dataArray['old']['GCLHPF']['GCSTS']['#text'];
					$dataOut[$c]['CLAIMCUR']	=@$dataArray['old']['GCLHPF']['CLAIMCUR']['#text'];
					$dataOut[$c]['CRATE']		=@$dataArray['old']['GCLHPF']['CRATE']['#text'];
					$dataOut[$c]['PRODTYP']		=@$dataArray['old']['GCLHPF']['PRODTYP']['#text'];
					$dataOut[$c]['DTEVISIT']	=@$dataArray['old']['GCLHPF']['DTEVISIT']['#text'];
					$dataOut[$c]['GCDIAGCD']	=@$dataArray['old']['GCLHPF']['GCDIAGCD']['#text'];
					$dataOut[$c]['PLANNO']		=@$dataArray['old']['GCLHPF']['PLANNO']['#text'];
					$dataOut[$c]['CLAMNUM']		=@$dataArray['old']['GCLHPF']['CLAMNUM']['#text'];
					$dataOut[$c]['PROVORG']		=@$dataArray['old']['GCLHPF']['PROVORG']['#text'];
					$dataOut[$c]['AREACDE']		=@$dataArray['old']['GCLHPF']['AREACDE']['#text'];
					$dataOut[$c]['REFERRER']	=@$dataArray['old']['GCLHPF']['REFERRER']['#text'];
					$dataOut[$c]['CLAMTYPE']	=@$dataArray['old']['GCLHPF']['CLAMTYPE']['#text'];
					$dataOut[$c]['CLIENT_CLAIM_REF']		=@$dataArray['old']['GCLHPF']['CLIENT_CLAIM_REF']['#text'];
					$dataOut[$c]['GCDTHCLM']		=@$dataArray['old']['GCLHPF']['GCDTHCLM']['#text'];
					$dataOut[$c]['APAIDAMT']		=@$dataArray['old']['GCLHPF']['APAIDAMT']['#text'];
					$dataOut[$c]['REQNTYPE']		=@$dataArray['old']['GCLHPF']['REQNTYPE']['#text'];
					$dataOut[$c]['CRDTCARD']		=@$dataArray['old']['GCLHPF']['CRDTCARD']['#text'];
					$dataOut[$c]['WHOPAID']		=@$dataArray['old']['GCLHPF']['WHOPAID']['#text'];
					$dataOut[$c]['DTEKNOWN']		=@$dataArray['old']['GCLHPF']['DTEKNOWN']['#text'];
					$dataOut[$c]['GCFRPDTE']		=@$dataArray['old']['GCLHPF']['GCFRPDTE']['#text'];
					$dataOut[$c]['RECVD_DATE']		=@$dataArray['old']['GCLHPF']['RECVD_DATE']['#text'];
					$dataOut[$c]['MCFROM']		=@$dataArray['old']['GCLHPF']['MCFROM']['#text'];
					$dataOut[$c]['MCTO']		=@$dataArray['old']['GCLHPF']['MCTO']['#text'];
					$dataOut[$c]['GDEDUCT']		=@$dataArray['old']['GCLHPF']['GDEDUCT']['#text'];
					$dataOut[$c]['COPAY']		=@$dataArray['old']['GCLHPF']['COPAY']['#text'];
					$dataOut[$c]['MBRTYPE']		=@$dataArray['old']['GCLHPF']['MBRTYPE']['#text'];
					$dataOut[$c]['PROVNET']		=@$dataArray['old']['GCLHPF']['PROVNET']['#text'];
					$dataOut[$c]['AAD']		=@$dataArray['old']['GCLHPF']['AAD']['#text'];
					$dataOut[$c]['THIRDRCVY']		=@$dataArray['old']['GCLHPF']['THIRDRCVY']['#text'];
					$dataOut[$c]['THIRDPARTY']		=@$dataArray['old']['GCLHPF']['THIRDPARTY']['#text'];
					$dataOut[$c]['TLMBRSHR']		=@$dataArray['old']['GCLHPF']['TLMBRSHR']['#text'];
					$dataOut[$c]['TLHMOSHR']		=@$dataArray['old']['GCLHPF']['TLHMOSHR']['#text'];
					$dataOut[$c]['DATEAUTH']		=@$dataArray['old']['GCLHPF']['DATEAUTH']['#text'];
					$dataOut[$c]['GCAUTHBY']		=@$dataArray['old']['GCLHPF']['GCAUTHBY']['#text'];
					$dataOut[$c]['GCOPRSCD']		=@$dataArray['old']['GCLHPF']['GCOPRSCD']['#text'];
					$dataOut[$c]['REVLINK']		=@$dataArray['old']['GCLHPF']['REVLINK']['#text'];
					$dataOut[$c]['TPRCVPND']		=@$dataArray['old']['GCLHPF']['TPRCVPND']['#text'];
					$dataOut[$c]['PENDFROM']		=@$dataArray['old']['GCLHPF']['PENDFROM']['#text'];
					$dataOut[$c]['MMPROD']		=@$dataArray['old']['GCLHPF']['MMPROD']['#text'];
					$dataOut[$c]['HMOSHRMM']		=@$dataArray['old']['GCLHPF']['HMOSHRMM']['#text'];
					$dataOut[$c]['TAKEUP']		=@$dataArray['old']['GCLHPF']['TAKEUP']['#text'];
					$dataOut[$c]['DATACONV']		=@$dataArray['old']['GCLHPF']['DATACONV']['#text'];
					$dataOut[$c]['CLRATE']		=@$dataArray['old']['GCLHPF']['CLRATE']['#text'];
					$dataOut[$c]['REFNO']		=@$dataArray['old']['GCLHPF']['REFNO']['#text'];
					$dataOut[$c]['UPDATE_IND']		=@$dataArray['old']['GCLHPF']['UPDATE_IND']['#text'];
					$dataOut[$c]['ROOMTYPE']		=@$dataArray['old']['GCLHPF']['ROOMTYPE']['#text'];
					$dataOut[$c]['BNFTGRP']		=@$dataArray['old']['GCLHPF']['BNFTGRP']['#text'];
					$dataOut[$c]['CLMSRVTP']		=@$dataArray['old']['GCLHPF']['CLMSRVTP']['#text'];
					$dataOut[$c]['REVERSAL_IND']		=@$dataArray['old']['GCLHPF']['REVERSAL_IND']['#text'];					
					$dataOut[$c]['GRSKCLS']		=@$dataArray['old']['GCLHPF']['GRSKCLS']['#text'];
					$dataOut[$c]['TIMEHH01']		=@$dataArray['old']['GCLHPF']['TIMEHH01']['#text'];
					$dataOut[$c]['TIMEHH02']		=@$dataArray['old']['GCLHPF']['TIMEHH02']['#text'];
					$dataOut[$c]['TIMEMM01']		=@$dataArray['old']['GCLHPF']['TIMEMM01']['#text'];
					$dataOut[$c]['TIMEMM02']		=@$dataArray['old']['GCLHPF']['TIMEMM02']['#text'];
					$dataOut[$c]['PATNTYN']		=@$dataArray['old']['GCLHPF']['PATNTYN']['#text'];
					$dataOut[$c]['PEDYN']		=@$dataArray['old']['GCLHPF']['PEDYN']['#text'];
					$dataOut[$c]['CAUSECD']		=@$dataArray['old']['GCLHPF']['CAUSECD']['#text'];
					$dataOut[$c]['GTCFSHARE']		=@$dataArray['old']['GCLHPF']['GTCFSHARE']['#text'];					
					$dataOut[$c]['TCFSHARE']		=@$dataArray['old']['GCLHPF']['TCFSHARE']['#text'];
					$dataOut[$c]['ZTCFSHARE']		=@$dataArray['old']['GCLHPF']['ZTCFSHARE']['#text'];
					$dataOut[$c]['CFYNFLG']		=@$dataArray['old']['GCLHPF']['CFYNFLG']['#text'];
					$dataOut[$c]['DATEEND']		=@$dataArray['old']['GCLHPF']['DATEEND']['#text'];
					$dataOut[$c]['DTEDCHRG']		=@$dataArray['old']['GCLHPF']['DTEDCHRG']['#text'];
					$dataOut[$c]['TRAVELDUR']		=@$dataArray['old']['GCLHPF']['TRAVELDUR']['#text'];
					$dataOut[$c]['INWRDNO']		=@$dataArray['old']['GCLHPF']['INWRDNO']['#text'];
					$dataOut[$c]['PFACTOR01']		=@$dataArray['old']['GCLHPF']['PFACTOR01']['#text'];
					$dataOut[$c]['PFACTOR02']		=@$dataArray['old']['GCLHPF']['PFACTOR02']['#text'];					
					$dataOut[$c]['PRATANUM01']		=@$dataArray['old']['GCLHPF']['PRATANUM01']['#text'];
					$dataOut[$c]['PRATANUM02']		=@$dataArray['old']['GCLHPF']['PRATANUM02']['#text'];
					$dataOut[$c]['PRATADEN01']		=@$dataArray['old']['GCLHPF']['PRATADEN01']['#text'];
					$dataOut[$c]['PRATADEN02']		=@$dataArray['old']['GCLHPF']['PRATADEN02']['#text'];
					$dataOut[$c]['COPAYAMT']		=@$dataArray['old']['GCLHPF']['COPAYAMT']['#text'];
					$dataOut[$c]['REPRCNGTOT']		=@$dataArray['old']['GCLHPF']['REPRCNGTOT']['#text'];
					$dataOut[$c]['GCADMDT']			=@$dataArray['old']['GCLHPF']['GCADMDT']['#text'];
					$dataOut[$c]['ZAMTDAY']			=@$dataArray['old']['GCLHPF']['ZAMTDAY']['#text'];
					$dataOut[$c]['ZAMTDAYI']		=@$dataArray['old']['GCLHPF']['ZAMTDAYI']['#text'];			
					$dataOut[$c]['ZRNBALW']			=@$dataArray['old']['GCLHPF']['ZRNBALW']['#text'];
					$dataOut[$c]['ZICUALW']			=@$dataArray['old']['GCLHPF']['ZICUALW']['#text'];
					$dataOut[$c]['CFCOPAY']			=@$dataArray['old']['GCLHPF']['CFCOPAY']['#text'];
					$dataOut[$c]['ZSECSTS']			=@$dataArray['old']['GCLHPF']['ZSECSTS']['#text'];
					$dataOut[$c]['ZCLMSTS']			=@$dataArray['old']['GCLHPF']['ZCLMSTS']['#text'];
					$dataOut[$c]['CPTCODE']			=@$dataArray['old']['GCLHPF']['CPTCODE']['#text'];
					$dataOut[$c]['USRHMO']			=@$dataArray['old']['GCLHPF']['USRHMO']['#text'];
					$dataOut[$c]['USER_PROFILE']	=@$dataArray['old']['GCLHPF']['USER_PROFILE']['#text'];
					$dataOut[$c]['JOB_NAME']		=@$dataArray['old']['GCLHPF']['JOB_NAME']['#text'];
					$dataOut[$c]['DATIME']			=@$dataArray['old']['GCLHPF']['DATIME']['#text'];
					$dataOut[$c]['LSURNAME']		=@$dataArray['old']['GCLHPF']['LSURNAME']['#text'];
					$dataOut[$c]['LGIVNAME']		=@$dataArray['old']['GCLHPF']['LGIVNAME']['#text'];
					$c++;
				}	
				for($k=0;$k<count(@$dataArray);$k++){
						if(trim(@$dataArray[$k]['old']['GCLHPF']['CLAMNUM']['#text'])!=''){
					$dataOut[$c]['CLMCOY']		=@$dataArray[$k]['old']['GCLHPF']['CLMCOY']['#text'];
					$dataOut[$c]['PREAUTNO']	=@$dataArray[$k]['old']['GCLHPF']['PREAUTNO']['#text'];
					$dataOut[$c]['GCOCCNO']		=@$dataArray[$k]['old']['GCLHPF']['GCOCCNO']['#text'];
					$dataOut[$c]['CHDRNUM']		=@$dataArray[$k]['old']['GCLHPF']['CHDRNUM']['#text'];
					$dataOut[$c]['MBRNO']		=@$dataArray[$k]['old']['GCLHPF']['MBRNO']['#text'];
					$dataOut[$c]['DPNTNO']		=@$dataArray[$k]['old']['GCLHPF']['DPNTNO']['#text'];
					$dataOut[$c]['CLNTCOY']		=@$dataArray[$k]['old']['GCLHPF']['CLNTCOY']['#text'];
					$dataOut[$c]['CLNTNUM']		=@$dataArray[$k]['old']['GCLHPF']['CLNTNUM']['#text'];
					$dataOut[$c]['GCSTS']		=@$dataArray[$k]['old']['GCLHPF']['GCSTS']['#text'];
					$dataOut[$c]['CLAIMCUR']	=@$dataArray[$k]['old']['GCLHPF']['CLAIMCUR']['#text'];
					$dataOut[$c]['CRATE']		=@$dataArray[$k]['old']['GCLHPF']['CRATE']['#text'];
					$dataOut[$c]['PRODTYP']		=@$dataArray[$k]['old']['GCLHPF']['PRODTYP']['#text'];
					$dataOut[$c]['DTEVISIT']	=@$dataArray[$k]['old']['GCLHPF']['DTEVISIT']['#text'];
					$dataOut[$c]['GCDIAGCD']	=@$dataArray[$k]['old']['GCLHPF']['GCDIAGCD']['#text'];
					$dataOut[$c]['PLANNO']		=@$dataArray[$k]['old']['GCLHPF']['PLANNO']['#text'];
					$dataOut[$c]['CLAMNUM']		=@$dataArray[$k]['old']['GCLHPF']['CLAMNUM']['#text'];
					$dataOut[$c]['PROVORG']		=@$dataArray[$k]['old']['GCLHPF']['PROVORG']['#text'];
					$dataOut[$c]['AREACDE']		=@$dataArray[$k]['old']['GCLHPF']['AREACDE']['#text'];
					$dataOut[$c]['REFERRER']	=@$dataArray[$k]['old']['GCLHPF']['REFERRER']['#text'];
					$dataOut[$c]['CLAMTYPE']	=@$dataArray[$k]['old']['GCLHPF']['CLAMTYPE']['#text'];
					$dataOut[$c]['CLIENT_CLAIM_REF']		=@$dataArray[$k]['old']['GCLHPF']['CLIENT_CLAIM_REF']['#text'];
					$dataOut[$c]['GCDTHCLM']		=@$dataArray[$k]['old']['GCLHPF']['GCDTHCLM']['#text'];
					$dataOut[$c]['APAIDAMT']		=@$dataArray[$k]['old']['GCLHPF']['APAIDAMT']['#text'];
					$dataOut[$c]['REQNTYPE']		=@$dataArray[$k]['old']['GCLHPF']['REQNTYPE']['#text'];
					$dataOut[$c]['CRDTCARD']		=@$dataArray[$k]['old']['GCLHPF']['CRDTCARD']['#text'];
					$dataOut[$c]['WHOPAID']		=@$dataArray[$k]['old']['GCLHPF']['WHOPAID']['#text'];
					$dataOut[$c]['DTEKNOWN']		=@$dataArray[$k]['old']['GCLHPF']['DTEKNOWN']['#text'];
					$dataOut[$c]['GCFRPDTE']		=@$dataArray[$k]['old']['GCLHPF']['GCFRPDTE']['#text'];
					$dataOut[$c]['RECVD_DATE']		=@$dataArray[$k]['old']['GCLHPF']['RECVD_DATE']['#text'];
					$dataOut[$c]['MCFROM']		=@$dataArray[$k]['old']['GCLHPF']['MCFROM']['#text'];
					$dataOut[$c]['MCTO']		=@$dataArray[$k]['old']['GCLHPF']['MCTO']['#text'];
					$dataOut[$c]['GDEDUCT']		=@$dataArray[$k]['old']['GCLHPF']['GDEDUCT']['#text'];
					$dataOut[$c]['COPAY']		=@$dataArray[$k]['old']['GCLHPF']['COPAY']['#text'];
					$dataOut[$c]['MBRTYPE']		=@$dataArray[$k]['old']['GCLHPF']['MBRTYPE']['#text'];
					$dataOut[$c]['PROVNET']		=@$dataArray[$k]['old']['GCLHPF']['PROVNET']['#text'];
					$dataOut[$c]['AAD']		=@$dataArray[$k]['old']['GCLHPF']['AAD']['#text'];
					$dataOut[$c]['THIRDRCVY']		=@$dataArray[$k]['old']['GCLHPF']['THIRDRCVY']['#text'];
					$dataOut[$c]['THIRDPARTY']		=@$dataArray[$k]['old']['GCLHPF']['THIRDPARTY']['#text'];
					$dataOut[$c]['TLMBRSHR']		=@$dataArray[$k]['old']['GCLHPF']['TLMBRSHR']['#text'];
					$dataOut[$c]['TLHMOSHR']		=@$dataArray[$k]['old']['GCLHPF']['TLHMOSHR']['#text'];
					$dataOut[$c]['DATEAUTH']		=@$dataArray[$k]['old']['GCLHPF']['DATEAUTH']['#text'];
					$dataOut[$c]['GCAUTHBY']		=@$dataArray[$k]['old']['GCLHPF']['GCAUTHBY']['#text'];
					$dataOut[$c]['GCOPRSCD']		=@$dataArray[$k]['old']['GCLHPF']['GCOPRSCD']['#text'];
					$dataOut[$c]['REVLINK']		=@$dataArray[$k]['old']['GCLHPF']['REVLINK']['#text'];
					$dataOut[$c]['TPRCVPND']		=@$dataArray[$k]['old']['GCLHPF']['TPRCVPND']['#text'];
					$dataOut[$c]['PENDFROM']		=@$dataArray[$k]['old']['GCLHPF']['PENDFROM']['#text'];
					$dataOut[$c]['MMPROD']		=@$dataArray[$k]['old']['GCLHPF']['MMPROD']['#text'];
					$dataOut[$c]['HMOSHRMM']		=@$dataArray[$k]['old']['GCLHPF']['HMOSHRMM']['#text'];
					$dataOut[$c]['TAKEUP']		=@$dataArray[$k]['old']['GCLHPF']['TAKEUP']['#text'];
					$dataOut[$c]['DATACONV']		=@$dataArray[$k]['old']['GCLHPF']['DATACONV']['#text'];
					$dataOut[$c]['CLRATE']		=@$dataArray[$k]['old']['GCLHPF']['CLRATE']['#text'];
					$dataOut[$c]['REFNO']		=@$dataArray[$k]['old']['GCLHPF']['REFNO']['#text'];
					$dataOut[$c]['UPDATE_IND']		=@$dataArray[$k]['old']['GCLHPF']['UPDATE_IND']['#text'];
					$dataOut[$c]['ROOMTYPE']		=@$dataArray[$k]['old']['GCLHPF']['ROOMTYPE']['#text'];
					$dataOut[$c]['BNFTGRP']		=@$dataArray[$k]['old']['GCLHPF']['BNFTGRP']['#text'];
					$dataOut[$c]['CLMSRVTP']		=@$dataArray[$k]['old']['GCLHPF']['CLMSRVTP']['#text'];
					$dataOut[$c]['REVERSAL_IND']		=@$dataArray[$k]['old']['GCLHPF']['REVERSAL_IND']['#text'];					
					$dataOut[$c]['GRSKCLS']		=@$dataArray[$k]['old']['GCLHPF']['GRSKCLS']['#text'];
					$dataOut[$c]['TIMEHH01']		=@$dataArray[$k]['old']['GCLHPF']['TIMEHH01']['#text'];
					$dataOut[$c]['TIMEHH02']		=@$dataArray[$k]['old']['GCLHPF']['TIMEHH02']['#text'];
					$dataOut[$c]['TIMEMM01']		=@$dataArray[$k]['old']['GCLHPF']['TIMEMM01']['#text'];
					$dataOut[$c]['TIMEMM02']		=@$dataArray[$k]['old']['GCLHPF']['TIMEMM02']['#text'];
					$dataOut[$c]['PATNTYN']		=@$dataArray[$k]['old']['GCLHPF']['PATNTYN']['#text'];
					$dataOut[$c]['PEDYN']		=@$dataArray[$k]['old']['GCLHPF']['PEDYN']['#text'];
					$dataOut[$c]['CAUSECD']		=@$dataArray[$k]['old']['GCLHPF']['CAUSECD']['#text'];
					$dataOut[$c]['GTCFSHARE']		=@$dataArray[$k]['old']['GCLHPF']['GTCFSHARE']['#text'];					
					$dataOut[$c]['TCFSHARE']		=@$dataArray[$k]['old']['GCLHPF']['TCFSHARE']['#text'];
					$dataOut[$c]['ZTCFSHARE']		=@$dataArray[$k]['old']['GCLHPF']['ZTCFSHARE']['#text'];
					$dataOut[$c]['CFYNFLG']		=@$dataArray[$k]['old']['GCLHPF']['CFYNFLG']['#text'];
					$dataOut[$c]['DATEEND']		=@$dataArray[$k]['old']['GCLHPF']['DATEEND']['#text'];
					$dataOut[$c]['DTEDCHRG']		=@$dataArray[$k]['old']['GCLHPF']['DTEDCHRG']['#text'];
					$dataOut[$c]['TRAVELDUR']		=@$dataArray[$k]['old']['GCLHPF']['TRAVELDUR']['#text'];
					$dataOut[$c]['INWRDNO']		=@$dataArray[$k]['old']['GCLHPF']['INWRDNO']['#text'];
					$dataOut[$c]['PFACTOR01']		=@$dataArray[$k]['old']['GCLHPF']['PFACTOR01']['#text'];
					$dataOut[$c]['PFACTOR02']		=@$dataArray[$k]['old']['GCLHPF']['PFACTOR02']['#text'];					
					$dataOut[$c]['PRATANUM01']		=@$dataArray[$k]['old']['GCLHPF']['PRATANUM01']['#text'];
					$dataOut[$c]['PRATANUM02']		=@$dataArray[$k]['old']['GCLHPF']['PRATANUM02']['#text'];
					$dataOut[$c]['PRATADEN01']		=@$dataArray[$k]['old']['GCLHPF']['PRATADEN01']['#text'];
					$dataOut[$c]['PRATADEN02']		=@$dataArray[$k]['old']['GCLHPF']['PRATADEN02']['#text'];
					$dataOut[$c]['COPAYAMT']		=@$dataArray[$k]['old']['GCLHPF']['COPAYAMT']['#text'];
					$dataOut[$c]['REPRCNGTOT']		=@$dataArray[$k]['old']['GCLHPF']['REPRCNGTOT']['#text'];
					$dataOut[$c]['GCADMDT']			=@$dataArray[$k]['old']['GCLHPF']['GCADMDT']['#text'];
					$dataOut[$c]['ZAMTDAY']			=@$dataArray[$k]['old']['GCLHPF']['ZAMTDAY']['#text'];
					$dataOut[$c]['ZAMTDAYI']		=@$dataArray[$k]['old']['GCLHPF']['ZAMTDAYI']['#text'];			
					$dataOut[$c]['ZRNBALW']			=@$dataArray[$k]['old']['GCLHPF']['ZRNBALW']['#text'];
					$dataOut[$c]['ZICUALW']			=@$dataArray[$k]['old']['GCLHPF']['ZICUALW']['#text'];
					$dataOut[$c]['CFCOPAY']			=@$dataArray[$k]['old']['GCLHPF']['CFCOPAY']['#text'];
					$dataOut[$c]['ZSECSTS']			=@$dataArray[$k]['old']['GCLHPF']['ZSECSTS']['#text'];
					$dataOut[$c]['ZCLMSTS']			=@$dataArray[$k]['old']['GCLHPF']['ZCLMSTS']['#text'];
					$dataOut[$c]['CPTCODE']			=@$dataArray[$k]['old']['GCLHPF']['CPTCODE']['#text'];
					$dataOut[$c]['USRHMO']			=@$dataArray[$k]['old']['GCLHPF']['USRHMO']['#text'];
					$dataOut[$c]['USER_PROFILE']	=@$dataArray[$k]['old']['GCLHPF']['USER_PROFILE']['#text'];
					$dataOut[$c]['JOB_NAME']		=@$dataArray[$k]['old']['GCLHPF']['JOB_NAME']['#text'];
					$dataOut[$c]['DATIME']			=@$dataArray[$k]['old']['GCLHPF']['DATIME']['#text'];
					$dataOut[$c]['LSURNAME']		=@$dataArray[$k]['old']['GCLHPF']['LSURNAME']['#text'];
					$dataOut[$c]['LGIVNAME']		=@$dataArray[$k]['old']['GCLHPF']['LGIVNAME']['#text'];
							$c++;
						}					
				}
				return $dataOut;		
				break;
				case 'GETPDF':
				$converter= new xml2array($data); 
				$dataArr=$converter->getResult();
				$dataOut=array();
				$searchArray=array("<Status>","<FilePath>","<StreamData>");
				$searchArray1=array("</Status>","</FilePath>","</StreamData>");
				$dataArray1=str_replace($searchArray,"",@$dataArr['soapenv:Envelope']['soapenv:Body']['ns2:GET_PDFResponse']['return']['#text']);
				$textReturn=str_replace($searchArray1,"&",@$dataArray1);	
				$dataParse=explode("&",@$textReturn);
				$dataOut['Status']=@$dataParse[0];
				$dataOut['FilePath']=@$dataParse[1];
				$dataOut['StreamData']=@$dataParse[2];
				return $dataOut;		
				break;
						case 'ClaimEnquiry':
				$converter= new xml2array($data); 
				$dataArr=$converter->getResult();
				$dataOut=array();
				$dataArray  = @$dataArr['SOAP:Envelope']['SOAP:Body']['GetClaimEnquiryResponse']['CLMALLISTIImplResponse'];		
				$dataArray['RESMSG1']=@$dataArr['SOAP:Envelope']['SOAP:Body']['GetClaimEnquiryResponse']['CLMALLISTIImplResponse']['RESMSG2']['copybook']['LEADER-HEADER'];
				$dataArray['RESMSG2']=@$dataArr['SOAP:Envelope']['SOAP:Body']['GetClaimEnquiryResponse']['CLMALLISTIImplResponse']['RESMSG3']['copybook']['CLMALLISTO-REC'];
				if(@$dataArray['RESMSG1']['MSGREFNO']['#text']!=''){
				$dataOut['MSGREFNO']	=@$dataArray['RESMSG1']['MSGREFNO']['#text'];
				$dataOut['USRPRF']		=@$dataArray['RESMSG1']['USRPRF']['#text'];
				$dataOut['WKSID']		=@$dataArray['RESMSG1']['WKSID']['#text'];
				$dataOut['OBJID']		=@$dataArray['RESMSG1']['OBJID']['#text'];
				$dataOut['VRBID']		=@$dataArray['RESMSG1']['VRBID']['#text'];
				$dataOut['TOTMSGLNG']	=@$dataArray['RESMSG1']['TOTMSGLNG']['#text'];
				$dataOut['OPMODE']		=@$dataArray['RESMSG1']['OPMODE']['#text'];
				$dataOut['CMTCONTROL']	=@$dataArray['RESMSG1']['CMTCONTROL']['#text'];
				$dataOut['RSPMODE']		=@$dataArray['RESMSG1']['RSPMODE']['#text'];
				$dataOut['MSGINTENT']	=@$dataArray['RESMSG1']['MSGINTENT']['#text'];
				$dataOut['MORE-IND']	=@$dataArray['RESMSG1']['MORE-IND']['#text'];
				$dataOut['ERRLVL']		=@$dataArray['RESMSG1']['ERRLVL']['#text'];
				
				$dataOut['MSGID']		=@$dataArray['RESMSG2']['MESSAGE-HEADER']['MSGID']['#text'];
				$dataOut['MSGLNG']		=@$dataArray['RESMSG2']['MESSAGE-HEADER']['MSGLNG']['#text'];
				$dataOut['MSGCNT']		=@$dataArray['RESMSG2']['MESSAGE-HEADER']['MSGCNT']['#text'];
				$dataOut['MSGLNG']		=@$dataArray['RESMSG2']['MESSAGE-HEADER']['MSGLNG']['#text'];
				
				$dataOut['MSGLNG']		=@$dataArray['RESMSG2']['MESSAGE-DATA']['MSGLNG']['#text'];
				$outputArray['dataArr'] = @$dataArray['RESMSG2']['MESSAGE-DATA']['ADDITIONAL-FIELDS'];
				$c=0;
				if(trim(@$outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-MEMNAME']['#text'])!=''){
					$dataOut['claimList'][$c]['BGEN-MEMNAME']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-MEMNAME']['#text'];
					$dataOut['claimList'][$c]['BGEN-INWRDNO']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-INWRDNO']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLAMNUM']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-CLAMNUM']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLNTNUM']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-CLNTNUM']['#text'];
					$dataOut['claimList'][$c]['BGEN-BNFTGRP']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-BNFTGRP']['#text'];
					$dataOut['claimList'][$c]['BGEN-GCSTS']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-GCSTS']['#text'];
					$dataOut['claimList'][$c]['BGEN-GCSECSTS']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-GCSECSTS']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLMSRVTP']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-CLMSRVTP']['#text'];
					$dataOut['claimList'][$c]['BGEN-DTEVISIT']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-DTEVISIT']['#text'];
					$dataOut['claimList'][$c]['BGEN-INCURRED']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-INCURRED']['#text'];
					$dataOut['claimList'][$c]['BGEN-TLHMOSHR']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-TLHMOSHR']['#text'];
					$dataOut['claimList'][$c]['BGEN-GCOCCNO']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-GCOCCNO']['#text'];
					$c++;
					for($k=0;$k<count(@$outputArray['dataArr']['BGEN-CLAIMALDTL']);$k++){
						if(trim(@$outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-MEMNAME']['#text'])!=''){
					$dataOut['claimList'][$c]['BGEN-MEMNAME']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-MEMNAME']['#text'];
					$dataOut['claimList'][$c]['BGEN-INWRDNO']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-INWRDNO']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLAMNUM']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-CLAMNUM']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLNTNUM']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL']['BGEN-CLNTNUM']['#text'];
					$dataOut['claimList'][$c]['BGEN-BNFTGRP']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-BNFTGRP']['#text'];
					$dataOut['claimList'][$c]['BGEN-GCSTS']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-GCSTS']['#text'];
					$dataOut['claimList'][$c]['BGEN-GCSECSTS']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-GCSECSTS']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLMSRVTP']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-CLMSRVTP']['#text'];
					$dataOut['claimList'][$c]['BGEN-DTEVISIT']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-DTEVISIT']['#text'];
					$dataOut['claimList'][$c]['BGEN-INCURRED']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-INCURRED']['#text'];
					$dataOut['claimList'][$c]['BGEN-TLHMOSHR']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-TLHMOSHR']['#text'];
					$dataOut['claimList'][$c]['BGEN-GCOCCNO']['#text']		= $outputArray['dataArr']['BGEN-CLAIMALDTL'][$k]['BGEN-GCOCCNO']['#text'];
					$c++;
						}
					}		
			}
				
				}				
				return $dataOut;		
				break;
				case 'ClaimDetails':
				$converter= new xml2array($data); 
				$dataArr=$converter->getResult();
				$dataOut=array();
				
				$dataArray  = @$dataArr['SOAP:Envelope']['SOAP:Body']['GetClaimEnquiryResponse']['CLMALDETLIImplResponse'];	
			$dataArray['RESMSG1']=@$dataArr['SOAP:Envelope']['SOAP:Body']['GetClaimEnquiryResponse']['CLMALDETLIImplResponse']['RESMSG2']['copybook']['LEADER-HEADER'];
				$dataArray['RESMSG2']=@$dataArr['SOAP:Envelope']['SOAP:Body']['GetClaimEnquiryResponse']['CLMALDETLIImplResponse']['RESMSG3']['copybook']['CLMALDETLO-REC'];
			
				if(@$dataArray['RESMSG1']['MSGREFNO']['#text']!=''){
				$dataOut['MSGREFNO']	=@$dataArray['RESMSG1']['MSGREFNO']['#text'];
				$dataOut['USRPRF']		=@$dataArray['RESMSG1']['USRPRF']['#text'];
				$dataOut['WKSID']		=@$dataArray['RESMSG1']['WKSID']['#text'];
				$dataOut['OBJID']		=@$dataArray['RESMSG1']['OBJID']['#text'];
				$dataOut['VRBID']		=@$dataArray['RESMSG1']['VRBID']['#text'];
				$dataOut['TOTMSGLNG']	=@$dataArray['RESMSG1']['TOTMSGLNG']['#text'];
				$dataOut['OPMODE']		=@$dataArray['RESMSG1']['OPMODE']['#text'];
				$dataOut['CMTCONTROL']	=@$dataArray['RESMSG1']['CMTCONTROL']['#text'];
				$dataOut['RSPMODE']		=@$dataArray['RESMSG1']['RSPMODE']['#text'];
				$dataOut['MSGINTENT']	=@$dataArray['RESMSG1']['MSGINTENT']['#text'];
				$dataOut['MORE-IND']	=@$dataArray['RESMSG1']['MORE-IND']['#text'];
				$dataOut['ERRLVL']		=@$dataArray['RESMSG1']['ERRLVL']['#text'];				
				$dataOut['MSGID']		=@$dataArray['RESMSG2']['MESSAGE-HEADER']['MSGID']['#text'];
				$dataOut['MSGLNG']		=@$dataArray['RESMSG2']['MESSAGE-HEADER']['MSGLNG']['#text'];
				$dataOut['MSGCNT']		=@$dataArray['RESMSG2']['MESSAGE-HEADER']['MSGCNT']['#text'];
				$dataOut['MSGLNG']		=@$dataArray['RESMSG2']['MESSAGE-HEADER']['MSGLNG']['#text'];
				
				$dataOut['MSGLNG']		=@$dataArray['RESMSG2']['MESSAGE-DATA']['MSGLNG']['#text'];
				$outputArray['dataArr'] = @$dataArray['RESMSG2']['MESSAGE-DATA']['ADDITIONAL-FIELDS'];
				$c=0;
				if(trim(@$outputArray['dataArr']['BGEN-MEMNAME']['#text'])!=''){
					$dataOut['claimList'][$c]['BGEN-MEMNAME']['#text']		= $outputArray['dataArr']['BGEN-MEMNAME']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLAMNUM']['#text']		= $outputArray['dataArr']['BGEN-CLAMNUM']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLNTNUM']['#text']		= $outputArray['dataArr']['BGEN-CLNTNUM']['#text'];
					$dataOut['claimList'][$c]['BGEN-CNAME']['#text']		= @$outputArray['dataArr']['BGEN-CNAME']['#text'];
					$dataOut['claimList'][$c]['BGEN-DATIME']['#text']		= @$outputArray['dataArr']['BGEN-DATIME']['#text'];
					$dataOut['claimList'][$c]['BGEN-AMNT']['#text']			= @$outputArray['dataArr']['BGEN-AMNT']['#text'];
					$dataOut['claimList'][$c]['BGEN-BNFTGRP']['#text']		= $outputArray['dataArr']['BGEN-BNFTGRP']['#text'];
					$dataOut['claimList'][$c]['BGEN-GCSTS']['#text']		= $outputArray['dataArr']['BGEN-GCSTS']['#text'];
					$dataOut['claimList'][$c]['BGEN-CLMSRVTP']['#text']		= $outputArray['dataArr']['BGEN-CLMSRVTP']['#text'];
					$dataOut['claimList'][$c]['BGEN-DTEVISIT']['#text']		= $outputArray['dataArr']['BGEN-DTEVISIT']['#text'];
				//	$dataOut['claimList'][$c]['BGEN-DOCRCVDT']['#text']		= $outputArray['dataArr']['BGEN-DOCRCVDT']['#text'];
					$dataOut['claimList'][$c]['BGEN-INCURRED']['#text']		= $outputArray['dataArr']['BGEN-INCURRED']['#text'];
					$dataOut['claimList'][$c]['BGEN-TLHMOSHR']['#text']		= $outputArray['dataArr']['BGEN-TLHMOSHR']['#text'];	
					$dataOut['claimList'][$c]['BGEN-MBRNO']['#text']		= $outputArray['dataArr']['BGEN-MBRNO']['#text'];
					$dataOut['claimList'][$c]['BGEN-DPNTNO']['#text']		= $outputArray['dataArr']['BGEN-DPNTNO']['#text'];	
					$dataOut['claimList'][$c]['BGEN-CHDRNUM']['#text']		= $outputArray['dataArr']['BGEN-CHDRNUM']['#text'];
					$dataOut['claimList'][$c]['BGEN-PRODTYP']['#text']		= $outputArray['dataArr']['BGEN-PRODTYP']['#text'];	
					$dataOut['claimList'][$c]['BGEN-PLANNO']['#text']		= $outputArray['dataArr']['BGEN-PLANNO']['#text'];	
					$dataOut['claimList'][$c]['BGEN-DIAGCDE']['#text']		= $outputArray['dataArr']['BGEN-DIAGCDE']['#text'];	
					$dataOut['claimList'][$c]['BGEN-PROVORG']['#text']		= $outputArray['dataArr']['BGEN-PROVORG']['#text'];	
					$dataOut['claimList'][$c]['BGEN-GCFRPDTE']['#text']		= $outputArray['dataArr']['BGEN-GCFRPDTE']['#text'];	
					$dataOut['claimList'][$c]['BGEN-DTEVISIT']['#text']		= $outputArray['dataArr']['BGEN-DTEVISIT']['#text'];	
					$dataOut['claimList'][$c]['BGEN-DTEDCHRG']['#text']		= $outputArray['dataArr']['BGEN-DTEDCHRG']['#text'];	
					$dataOut['claimList'][$c]['BGEN-DOCRCVDT']['#text']		= $outputArray['dataArr']['BGEN-DOCRCVDT']['#text'];
					$dataOut['claimList'][$c]['BGEN-REJDATE']['#text']		= @$outputArray['dataArr']['BGEN-REJDATE']['#text'];
					$dataOut['claimList'][$c]['BGEN-REASONDESC']['#text']		= @$outputArray['dataArr']['BGEN-REASONDESC']['#text'];	
					$dataOut['claimList'][$c]['BGEN-TLMBRSHR']['#text']		= $outputArray['dataArr']['BGEN-TLMBRSHR']['#text'];	
					$dataOut['claimList'][$c]['BGEN-DDEDUCT']['#text']		= $outputArray['dataArr']['BGEN-DDEDUCT']['#text'];	
					$dataOut['claimList'][$c]['BGEN-COPAYAMT']['#text']		= $outputArray['dataArr']['BGEN-COPAYAMT']['#text'];
					$dataOut['claimList'][$c]['BGEN-GCOCCNO']['#text']		= $outputArray['dataArr']['BGEN-GCOCCNO']['#text'];
					$dataOut['claimList'][$c]['BGEN-SURNAME']['#text']		= $outputArray['dataArr']['BGEN-SURNAME']['#text'];
					$dataOut['claimList'][$c]['BGEN-PATNTYN']['#text']		= $outputArray['dataArr']['BGEN-PATNTYN']['#text'];
					$dataOut['claimList'][$c]['BGEN-REMDTE']['#text']		="";
					$dataOut['claimList'][$c]['BGEN-REMDTETWO']['#text']	="";
					$dataOut['claimList'][$c]['BGEN-REMDTETHE']['#text']	="";
					for($f=0;$f<count(@$outputArray['dataArr']['BGEN-FOLLOWUPS']['FILLER']);$f++){
						if($outputArray['dataArr']['BGEN-FOLLOWUPS']['FILLER'][$f]['BGEN-REMDTE']['#text']!=''){
						$dataOut['claimList'][$c]['BGEN-REMDTE']['#text']		= $outputArray['dataArr']['BGEN-FOLLOWUPS']['FILLER'][$f]['BGEN-REMDTE']['#text'];
						}
						if($outputArray['dataArr']['BGEN-FOLLOWUPS']['FILLER'][$f]['BGEN-REMDTETWO']['#text']!=''){
						$dataOut['claimList'][$c]['BGEN-REMDTETWO']['#text']		= $outputArray['dataArr']['BGEN-FOLLOWUPS']['FILLER'][$f]['BGEN-REMDTETWO']['#text'];
						}
						if($outputArray['dataArr']['BGEN-FOLLOWUPS']['FILLER'][$f]['BGEN-REMDTETHE']['#text']!=''){
						$dataOut['claimList'][$c]['BGEN-REMDTETHE']['#text']		= $outputArray['dataArr']['BGEN-FOLLOWUPS']['FILLER'][$f]['BGEN-REMDTETHE']['#text'];
						}
					}
					if(@$outputArray['dataArr']['BGEN-DISSALWNCE']['BGEN-ZRCODE']['#text']!=''){

					$dataOut['claimList']['DISSALWNCE'][$c]['BGEN-MEMNAME']['#text']		= @$outputArray['dataArr']['BGEN-DISSALWNCE']['BGEN-ZRCODE']['#text'];
					$dataOut['claimList']['DISSALWNCE'][$c]['BGEN-CLAMNUM']['#text']		= @$outputArray['dataArr']['BGEN-DISSALWNCE']['BGEN-DISALOWAMT']['#text'];
					$c++;
					}
					for($k=0;$k<count(@$outputArray['dataArr']['BGEN-DISSALWNCE']['BGEN-ZRCODE']);$k++){
					$dataOut['claimList']['DISSALWNCE'][$c]['BGEN-MEMNAME']['#text']		= @$outputArray['dataArr']['BGEN-DISSALWNCE']['BGEN-ZRCODE'][$k]['#text'];
					$dataOut['claimList']['DISSALWNCE'][$c]['BGEN-CLAMNUM']['#text']		= @$outputArray['dataArr']['BGEN-DISSALWNCE']['BGEN-DISALOWAMT'][$k]['#text'];
						$c++;
					}
					//Deficiency Type	
					$f=0;
					if(@$outputArray['dataArr']['BGEN-FOLLOWUPS']['BGEN-GFUPCDE']['#text']!=''){
						$dataOut['claimList']['Deficiency'][$f]['BGEN-GFUPCDE']['#text']		= @$outputArray['dataArr']['BGEN-FOLLOWUPS']['BGEN-GFUPCDE']['#text'];
						$f++;
					}
					for($k=0;$k<count(@$outputArray['dataArr']['BGEN-FOLLOWUPS']['BGEN-GFUPCDE']);$k++){
						$dataOut['claimList']['Deficiency'][$f]['BGEN-GFUPCDE']['#text']		= @$outputArray['dataArr']['BGEN-FOLLOWUPS']['BGEN-GFUPCDE'][$k]['#text'];
						$f++;
					}		
					//Deficiency Status
					$f=0;
					if(@$outputArray['dataArr']['BGEN-FOLLOWUPS']['BGEN-GFUPSTS']['#text']!=''){
						$dataOut['claimList']['Deficiency'][$f]['BGEN-GFUPSTS']['#text']		= @$outputArray['dataArr']['BGEN-FOLLOWUPS']['BGEN-GFUPSTS']['#text'];
						$f++;
					}
					for($k=0;$k<count(@$outputArray['dataArr']['BGEN-FOLLOWUPS']['BGEN-GFUPSTS']);$k++){
						$dataOut['claimList']['Deficiency'][$f]['BGEN-GFUPSTS']['#text']		= @$outputArray['dataArr']['BGEN-FOLLOWUPS']['BGEN-GFUPSTS'][$k]['#text'];
						$f++;
					}		
					//start case note
					$f=0;
					if(trim(@$outputArray['dataArr']['BGEN-CASENOTE']['#text'])!=''){
					$dataOut['claimList']['CASENOTE'][$f]['BGEN-CASENOTE']['#text']		= @$outputArray['dataArr']['BGEN-CASENOTE']['#text'];
					$f++;
					}
					for($k=0;$k<count(@$outputArray['dataArr']['BGEN-CASENOTE']);$k++){
						if(trim(@$outputArray['dataArr']['BGEN-CASENOTE'][$k]['#text'])!=''){
							$dataOut['claimList']['CASENOTE'][$f]['BGEN-CASENOTE']['#text']		= @$outputArray['dataArr']['BGEN-CASENOTE'][$k]['#text'];
							$f++;
						}
					}		
					//end case note
					//start SYMPTOM
					$f=0;
					if(trim(@$outputArray['dataArr']['BGEN-SYMPTOM']['#text'])!=''){
					$dataOut['claimList']['SYMPTOM'][$f]['BGEN-SYMPTOM']['#text']		= @$outputArray['dataArr']['BGEN-SYMPTOM']['#text'];
					$f++;
					}
					for($k=0;$k<count(@$outputArray['dataArr']['BGEN-CASENOTE']);$k++){
						if(trim(@$outputArray['dataArr']['BGEN-SYMPTOM'][$k]['#text'])!=''){
							$dataOut['claimList']['SYMPTOM'][$f]['BGEN-SYMPTOM']['#text']		= @$outputArray['dataArr']['BGEN-SYMPTOM'][$k]['#text'];
							$f++;
						}
					}		
					//end SYMPTOM
				}
				
				}				
				return $dataOut;		
				break;
				
		}		
		
	}
?>