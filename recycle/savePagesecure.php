<?php
include_once("conf/session.php");
require_once 'inc/conf.php';
include_once('api/xml2array.php');
include_once("api/domxml-php4-to-php5.php");
$fileNameRequest = time();
function fixArrayOfCheckboxes($checks) {
    $newChecks = array();
    for( $i = 0; $i < count( $checks ); $i++ ) {
        if( $checks[ $i ] == '0' && $checks[ $i + 1 ] > 0 ) {
            $newChecks[] = $checks[ $i + 1 ];
            $i++;
        }
        else {
            $newChecks[] = '0';
        }
    }
    return $newChecks;
}
//echo '<pre>';print_r($_POST);exit;
$dependents = array();
if (isset($_POST)) {
    $sourceData=array(
        "quotationReferenceNum" => sanitize_data($_POST['quotationReferenceNum']),
        "rmCode" => sanitize_data($_POST['rmCode']),
        "branchCode" => sanitize_data($_POST['relationCd']),
        "ValidCityName" => sanitize_data($_POST['ValidCityName']),
        "NomineeName" => sanitize_data($_POST['NomineeName']),
        "nomineeRelation" => sanitize_data($_POST['nomineeRelation']),
    );
    
    for ($i = 0; $i < count($_POST['relationCd']); $i++) {
        $dependents[$i] = array(
            'relationCd' => sanitize_data($_POST['relationCd'][$i]),
            'titleCd' => sanitize_data($_POST['titleCd'][$i]),
            'firstNameCd' => sanitize_data($_POST['firstNameCd'][$i]),
            'lastNameCd' => sanitize_data($_POST['lastNameCd'][$i]),
            'dOBCd' => sanitize_data($_POST['dOBCd'][$i])
        );
    }
    $nomineeName = sanitize_data($_POST['NomineeName']);
    $nomineeRelation = sanitize_data($_POST['nomineeRelation']);
    $checkclickid = sanitize_data($_POST['checkclickid']);
   	// $sumInsured = sanitize_data($_POST['proposalSumInsured']);
   	//$sumInsured = "001";
    //$baseProductId = sanitize_data($_POST['proposalProductCode']);
    $baseProductId = 30003002;//30001003
    $proposalDummySi = sanitize_data($_POST['proposalDummySi']);
	if($proposalDummySi=='2000000') {
		$sumInsured = "002";
	}	else {
		$sumInsured = "001";
	}
    $qnaT = $_POST['questions'];
    $qna = base64_encode(json_encode($qnaT));
    $businessTypeCd = "NEWBUSINESS";
    $baseAgentId = sanitize_data($_POST["agentId"]);
   // $baseAgentId="20008802";
    $totalMember = sanitize_data($_POST['totalAdultMember']);
    if ($totalMember == 1) {
        $coverType = "INDIVIDUAL";
    } else {
        $coverType = "FAMILYFLOATER";
    }
    $birthDt = sanitize_data($_POST['DOB']);
    $firstName = sanitize_data($_POST['ValidFName']);
    $titleCd = sanitize_data($_POST['ValidTitle']);
    if ($titleCd == 'MR') {
        $genderCd = "MALE";
    } else if ($titleCd == "MS") {
        $genderCd = "FEMALE";
    }
    //$guid = 41;
    $guid = time();
    $addons = sanitize_data($_POST['addOns']);
    $lastName = sanitize_data($_POST['ValidLName']);
    $state = sanitize_data($_POST['ValidStateName']);
    $addressLine1Lang1 = sanitize_data($_POST['ValidAddressOne']);
    $addressLine1Lang2 = sanitize_data($_POST['ValidAddressTwo']);
    $addressTypeCd = "PERMANENT";
    $areaCd = sanitize_data($_POST['ValidCityName']);
    $pinCode = sanitize_data($_POST['ValidPinCode']);
    $stateCd = sanitize_data($_POST['ValidStateName']);
    $contactNum = sanitize_data($_POST['ValidMobileNumber']);
    $contactTypeCd = sanitize_data('MOBILE');
    $emailAddress = sanitize_data_email($_POST['ValidEmail']);
    $saveandcontinueemail = sanitize_data_email($_POST['saveandcontinueemail']);
    $proposalTenourCode = sanitize_data($_POST['proposalTenourCode']);
    $ValidPanCard = sanitize_data($_POST['ValidPanCard']);
    $emailTypeCd = 'PERSONAL';
    $addressTypeCdC = 'COMMUNICATION';
    $relationCd = 'SELF';
    $roleCd = 'PROPOSER';
    $source = sanitize_data($_POST['source']);
    $fieldTc = sanitize_data($_POST['validTermCondition']);
    $totalChildMember = sanitize_data($_POST['totalChildMember']);
    $proposalageGroupOfEldestMember = sanitize_data($_POST['proposalageGroupOfEldestMember']);
    $fieldAlerts = sanitize_data($_POST['recivedSms']);
    $primaryData = '';
    $PREMIUM_AMOUNT = str_replace(',', '', $_POST['permiumamountValid']);
    $new = md5("NEW");
    $requestedID = sanitize_data($_POST['proposalRequestId']);
    $dependents = json_encode($dependents);
    $conn = dbConnect();
     if ($requestedID == $new || $checkclickid == 1) {
        $sql = "INSERT INTO REFERENCE_DATA 
    (REFERENCE_ID,
    AGENT_ID,
    INITIALS,
    FIRST_NAME,
    LAST_NAME,
    GENDER,
    DOB,
    EMAIL_ID,
    ADDRESS_1,
    ADDRESS_2,
    PIN_CODE,
    DEPENDENT_DETAIL,
    MOBILE_NO,
    INSURANCE_AMT,
    PREMIUM_AMT,
    QNA,
    COVERTYPE,
    PRODUCTCODE,
    SUMINSURED,
    MEMBER_COUNT,
    CHILDREN,
    ELDEST_MEMBER_AGE,
    TNC_AGREED,
    RECEIVE_ALERTS,
    STATE,
    TENURE,
    ADD_ONS,
    PREMIUM_AMOUNT,
    PANCARD_NUMBER,
    SOURCE,
    CREATED_TS,
    PAN_NO,
    UPDATED_TS,
    UTM_SOURCE
   ) values 
            (REFERENCE_DATA_SEQ.nextval,
            '" . $baseAgentId . "',
            '" . $titleCd . "',
            '" . $firstName . "',
            '" . $lastName . "',
            '" . $genderCd . "',
            '" . $birthDt . "',
            '" . $emailAddress . "',
            '" . $addressLine1Lang1 . "',
            '" . $addressLine1Lang2 . "',
            '" . $pinCode . "',
            '" . $dependents . "',
            '" . $contactNum . "',
            '" . $proposalDummySi . "',
            '',
            '" . $qna . "',
            '" . $coverType . "',
            '" . $baseProductId . "',
            '" . $sumInsured . "',
            '" . $totalMember . "',
            '" . $totalChildMember . "',
            '" . $proposalageGroupOfEldestMember . "',
            '" . $fieldTc . "',
            '" . $fieldAlerts . "',
            '" . $state . "',
            '" . $proposalTenourCode . "',
            '" . $addons . "',
            '" . $PREMIUM_AMOUNT . "',
            '" . $ValidPanCard . "',
            '" . $source . "',
            '" . time() . "',
            'SECURE',
            '" . time() . "',
            '".json_encode($sourceData)."'
) ";
     
       // echo $sql; exit;
     
        $stdid = @oci_parse($conn, $sql);
        $r = @oci_execute($stdid);

        $qu2 = "select REFERENCE_DATA_SEQ.currval from dual";
        $stdids2 = @oci_parse($conn, $qu2);
        @oci_execute($stdids2);
        $lastinsertId2 = oci_fetch_assoc($stdids2);
        $policyId = $lastinsertId2['CURRVAL'];
    } else {
        $updateSql = "UPDATE REFERENCE_DATA SET  
    INITIALS='" . $titleCd . "',
    AGENT_ID='" . $baseAgentId . "',
    FIRST_NAME='" . $firstName . "',
    LAST_NAME='" . $lastName . "',
    GENDER='" . $genderCd . "',
    DOB='" . $birthDt . "',
    STATE='" . $state . "',
    EMAIL_ID='" . $emailAddress . "',
    ADDRESS_1='" . $addressLine1Lang1 . "',
    ADDRESS_2='" . $addressLine1Lang2 . "',
    PIN_CODE='" . $pinCode . "',
    DEPENDENT_DETAIL='" . $dependents . "',
    MOBILE_NO='" . $contactNum . "',
    INSURANCE_AMT='" . $proposalDummySi . "',
    PREMIUM_AMT='',
    QNA='" . $qna . "',
    COVERTYPE='" . $coverType . "',
    PRODUCTCODE='" . $baseProductId . "',
    SUMINSURED='" . $sumInsured . "',
    MEMBER_COUNT='" . $totalMember . "',
    CHILDREN='" . $totalChildMember . "',
    ELDEST_MEMBER_AGE='" . $proposalageGroupOfEldestMember . "',
    TENURE = '" . $proposalTenourCode . "',   
    TNC_AGREED='" . $fieldTc . "',
    RECEIVE_ALERTS='" . $fieldAlerts . "',
    ADD_ONS='" . $addons . "',
    PREMIUM_AMOUNT='" . $PREMIUM_AMOUNT . "',
    SOURCE = '" . $source . "',
    PANCARD_NUMBER = '" . $ValidPanCard . "',
    UPDATED_TS = '".time()."',
    UTM_SOURCE = '".json_encode($sourceData)."'
    WHERE REFERENCE_ID = $requestedID";
        $updateStdid = @oci_parse($conn, $updateSql);
        $r = @oci_execute($updateStdid);
        $policyId = $requestedID;
        //echo $updateSql;exit;
    }
    $dependents = json_decode($dependents, true);
    if (isset($fieldTc)) {
        $fieldTc = "YES";
    }
    if (isset($fieldAlerts)) {
        $fieldAlerts = "YES";
    }
    if ($checkclickid == 1) {
        $kgid = $guid;
        for ($i = 0; $i < $totalMember; $i++) {
            $questionData = '';

            if ($dependents[$i]['titleCd'] == 'MR') {
                $genderCdP = "MALE";
            } else if ($dependents[$i]['titleCd'] == 'MS') {
                $genderCdP = "FEMALE";
            }
            // echo '<pre>';print_r($qnaT);exit;
            /*foreach ($qnaT as $qSetId => $gSetVal) {
                  
                    if ($gSetVal == '1') {
                                    $questionData.='<xsd:partyQuestionDOList>
                                <xsd:questionCd>' . $qSetId . '</xsd:questionCd>
                                <xsd:questionSetCd>HEDSecureDetails</xsd:questionSetCd>
                                <xsd:response>YES</xsd:response>
                                </xsd:partyQuestionDOList>';
                                } else {
                                      $questionData.='<xsd:partyQuestionDOList>
                                <xsd:questionCd>' . $qSetId . '</xsd:questionCd>
                                <xsd:questionSetCd>HEDSecureDetails</xsd:questionSetCd>
                                <xsd:response>NO</xsd:response>
                                </xsd:partyQuestionDOList>';
                                }
                
                
                
            }*/
			foreach ($qnaT as $qSetId => $gSetVal) {

                foreach ($gSetVal as $qId => $gVal) {

                    if ($qId == 'subQuestion' || $gSetVal[$qId] == '0') {
                        continue;
                    } else {
                        if (in_array('qus', array_keys($gSetVal['subQuestion']))) {
                            if ($gVal == 1) {

                                if ($gSetVal['subQuestion']['qus'][$i] != '0') {
                                    $questionData.='<xsd:partyQuestionDOList>
                                <xsd:questionCd>' . $qId . '</xsd:questionCd>
                                <xsd:questionSetCd>' . $qSetId . '</xsd:questionSetCd>
                                <xsd:response>' . $gSetVal['subQuestion']['qus'][$i] . '</xsd:response>
                                </xsd:partyQuestionDOList>';
                                }
                            }
                        } else {
                            $response = "NO";
                            foreach ($gSetVal['subQuestion'] as $qTemId => $gTemVal) {
                                if (!isset($gTemVal['qus'])) {
                                    continue;
                                }
                                
                               $resultFinalArray =   fixArrayOfCheckboxes($gTemVal['qus']);
                            //   echo '<pre>';print_r($resultFinalArray);
                               
                               if (isset($gTemVal['qus'][$i])) {
                                    
                                    if ($qTemId == "1") {
                                        $qTemId = "pedYesNo";
                                        $questionDataSetCD = "yesNoExist";
                                        $response = $gTemVal['qus'][$i];
                                        
                                        $questionData.='<xsd:partyQuestionDOList>
                                            <xsd:questionCd>' . $qTemId . '</xsd:questionCd>
                                            <xsd:questionSetCd>' . $questionDataSetCD . '</xsd:questionSetCd>
                                            <xsd:response>' . $response . '</xsd:response>
                                            </xsd:partyQuestionDOList>'; 
                                    } else {
                                        $questionDataSetCD = $questionIDArray[$qTemId]['qSetId'];
                                    }
                                    if ($response == "YES") {
                                        if (isset($resultFinalArray[$i]) && $resultFinalArray[$i] > 0) {
                                          $questionData.='<xsd:partyQuestionDOList>
                                            <xsd:questionCd>' . $qTemId . '</xsd:questionCd>
                                            <xsd:questionSetCd>' . $questionDataSetCD . '</xsd:questionSetCd>
                                            <xsd:response>' . $response . '</xsd:response>
                                            </xsd:partyQuestionDOList>'; 
                                        }
                                    }
                                }

                                if (isset($resultFinalArray[$i]) && $resultFinalArray[$i] > 0) {
                                    $index = $i; //intval($resultFinalArray[$i]) - 1;
                                    $mmyy = $monthArray[$gTemVal['mm'][$index]] . '/' . $gTemVal['yy'][$index];

                                    $questionData.='<xsd:partyQuestionDOList>
                                    <xsd:questionCd>' . $questionIDArray[$qTemId]['yearQId'] . '</xsd:questionCd>
                                    <xsd:questionSetCd>' . $questionIDArray[$qTemId]['qSetId'] . '</xsd:questionSetCd>
                                    <xsd:response>' . $mmyy . '</xsd:response>
                                    </xsd:partyQuestionDOList>';
                                }
                            }
                        }
                    }
                }
            }
            if ($questionData == '') {
                $questionData.='<xsd:partyQuestionDOList>
                                    <xsd:questionCd></xsd:questionCd>
                                    <xsd:questionSetCd></xsd:questionSetCd>
                                    <xsd:response></xsd:response>
                                    </xsd:partyQuestionDOList>';
            }
            if($dependents[$i]['relationCd'] == 'SELF'){
                $kgid=$guid;
            }
            
            $primaryData.="<xsd:partyDOList>
                <xsd:birthDt>" . $dependents[$i]['dOBCd'] . "</xsd:birthDt>
                <xsd:firstName>" . $dependents[$i]['firstNameCd'] . "</xsd:firstName>
                <xsd:genderCd>" . $genderCdP . "</xsd:genderCd>
                <xsd:guid>" . $kgid . "</xsd:guid>
                <xsd:lastName>" . $dependents[$i]['lastNameCd'] . "</xsd:lastName>
                <xsd:partyAddressDOList>
                <xsd:addressLine1Lang1>" . $addressLine1Lang1 . "</xsd:addressLine1Lang1>
                <xsd:addressLine2Lang1>" . $addressLine1Lang2 . "</xsd:addressLine2Lang1>
                <xsd:addressTypeCd>" . $addressTypeCd . "</xsd:addressTypeCd>
                <xsd:areaCd>" . $areaCd . "</xsd:areaCd>
                <xsd:cityCd>" . $areaCd . "</xsd:cityCd>
                <xsd:pinCode>" . $pinCode . "</xsd:pinCode>
                <xsd:stateCd>" . $stateCd . "</xsd:stateCd>
                <xsd:countryCd>IND</xsd:countryCd>
                </xsd:partyAddressDOList>
                <xsd:partyAddressDOList>
                <xsd:addressLine1Lang1>" . $addressLine1Lang1 . "</xsd:addressLine1Lang1>
                <xsd:addressLine2Lang1>" . $addressLine1Lang2 . "</xsd:addressLine2Lang1>
                <xsd:addressTypeCd>" . $addressTypeCdC . "</xsd:addressTypeCd>
                <xsd:areaCd>" . $areaCd . "</xsd:areaCd>
                <xsd:cityCd>" . $areaCd . "</xsd:cityCd>
                <xsd:pinCode>" . $pinCode . "</xsd:pinCode>
                <xsd:stateCd>" . $stateCd . "</xsd:stateCd>
                <xsd:countryCd>IND</xsd:countryCd>
                </xsd:partyAddressDOList>
                <xsd:partyContactDOList>
                <xsd:contactNum>" . $contactNum . "</xsd:contactNum>
                <xsd:contactTypeCd>" . $contactTypeCd . "</xsd:contactTypeCd>
                <xsd:stdCode>+91</xsd:stdCode>
                </xsd:partyContactDOList>
                <xsd:partyEmailDOList>
                <xsd:emailAddress>" . $emailAddress . "</xsd:emailAddress>
                <xsd:emailTypeCd>" . $emailTypeCd . "</xsd:emailTypeCd>
                </xsd:partyEmailDOList>
                <xsd:partyIdentityDOList>
                <xsd:identityNum></xsd:identityNum>
                <xsd:identityTypeCd></xsd:identityTypeCd>
                </xsd:partyIdentityDOList>" . $questionData . "
                
                <xsd:relationCd>" . $dependents[$i]['relationCd'] . "</xsd:relationCd>
                <xsd:roleCd>PRIMARY</xsd:roleCd>
                <xsd:titleCd>" . $dependents[$i]['titleCd'] . "</xsd:titleCd>
                <xsd:partyEmploymentDOList>
                <xsd:occupationCd>I001</xsd:occupationCd>
                </xsd:partyEmploymentDOList>
                </xsd:partyDOList>";
            $kgid++;
        }

        if ($addons == 'YES') {
            $addOnBenifit = "<xsd:addOns>" . $addonsData . "</xsd:addOns>";
        }

  if (in_array("SELF", $_POST['relationCd'])) {
            $questionDataSetQuest = "";
        } else {
            $questionDataSetQuest = '<xsd:partyQuestionDOList>
                                    <xsd:questionCd></xsd:questionCd>
                                    <xsd:questionSetCd></xsd:questionSetCd>
                                    <xsd:response></xsd:response>
                                    </xsd:partyQuestionDOList>';
        }
        $xmlData = "<soap:Envelope xmlns:soap='http://www.w3.org/2003/05/soap-envelope' xmlns:rel='http://relinterface.insurance.symbiosys.c2lbiz.com' xmlns:xsd='http://intf.insurance.symbiosys.c2lbiz.com/xsd'>
                        <soap:Header/><soap:Body>
                        <rel:createPolicySecure> 
                        <rel:intIO>
                        <xsd:policy>
                        " . $addOnBenifit . "
                        <xsd:businessTypeCd>" . $businessTypeCd . "</xsd:businessTypeCd>
                        <xsd:baseProductId>" . $baseProductId . "</xsd:baseProductId>
                        <xsd:baseAgentId>" . $baseAgentId . "</xsd:baseAgentId>
                        <xsd:coverType>" . $coverType . "</xsd:coverType>
                        <xsd:partyDOList>
                        <xsd:birthDt>" . $birthDt . "</xsd:birthDt>
                        <xsd:firstName>" . $firstName . "</xsd:firstName>
                        <xsd:genderCd>" . $genderCd . "</xsd:genderCd>
                        <xsd:guid>" . $guid . "</xsd:guid>
                        <xsd:lastName>" . $lastName . "</xsd:lastName>
                        <xsd:partyAddressDOList>
                        <xsd:addressLine1Lang1>" . $addressLine1Lang1 . "</xsd:addressLine1Lang1>
                        <xsd:addressLine2Lang1>" . $addressLine1Lang2 . "</xsd:addressLine2Lang1>
                        <xsd:addressTypeCd>" . $addressTypeCd . "</xsd:addressTypeCd>
                        <xsd:areaCd>" . $areaCd . "</xsd:areaCd>
                        <xsd:cityCd>" . $areaCd . "</xsd:cityCd>
                        <xsd:pinCode>" . $pinCode . "</xsd:pinCode>
                        <xsd:stateCd>" . $stateCd . "</xsd:stateCd>
                         <xsd:countryCd>IND</xsd:countryCd>
                        </xsd:partyAddressDOList>
                        <xsd:partyAddressDOList>
                <xsd:addressLine1Lang1>" . $addressLine1Lang1 . "</xsd:addressLine1Lang1>
                <xsd:addressLine2Lang1>" . $addressLine1Lang2 . "</xsd:addressLine2Lang1>
                <xsd:addressTypeCd>" . $addressTypeCdC . "</xsd:addressTypeCd>
                <xsd:areaCd>" . $areaCd . "</xsd:areaCd>
                <xsd:cityCd>" . $areaCd . "</xsd:cityCd>
                <xsd:pinCode>" . $pinCode . "</xsd:pinCode>
                <xsd:stateCd>" . $stateCd . "</xsd:stateCd>
                <xsd:countryCd>IND</xsd:countryCd>
                </xsd:partyAddressDOList>
                        <xsd:partyContactDOList>
                        <xsd:contactNum>" . $contactNum . "</xsd:contactNum>
                        <xsd:contactTypeCd>" . $contactTypeCd . "</xsd:contactTypeCd>
                        <xsd:stdCode>+91</xsd:stdCode>
                        </xsd:partyContactDOList>
                        <xsd:partyEmailDOList>
                        <xsd:emailAddress>" . $emailAddress . "</xsd:emailAddress>
                        <xsd:emailTypeCd>" . $emailTypeCd . "</xsd:emailTypeCd>
                        </xsd:partyEmailDOList>
                        <xsd:partyIdentityDOList>
                        <xsd:identityNum>".$ValidPanCard."</xsd:identityNum>
                        <xsd:identityTypeCd>PAN</xsd:identityTypeCd>
                        </xsd:partyIdentityDOList>
                        <xsd:relationCd>" . $relationCd . "</xsd:relationCd>
                        <xsd:roleCd>" . $roleCd . "</xsd:roleCd>
                        <xsd:titleCd>" . $titleCd . "</xsd:titleCd>
                            " . $questionDataSetQuest . "
                        </xsd:partyDOList>" . $primaryData . "
                        <xsd:policyAdditionalFieldsDOList>
                            <!--Optional:-->
                         <xsd:field1></xsd:field1>
                           <!--Optional:-->
                        <xsd:field2></xsd:field2>
                             <!--Optional:-->
                        <xsd:field3></xsd:field3>
                        <xsd:field10>".$nomineeName."</xsd:field10>
                        <xsd:field12>".$nomineeRelation."</xsd:field12>
                        <xsd:fieldAgree>YES</xsd:fieldAgree>
                        <xsd:fieldAlerts>" . $fieldAlerts . "</xsd:fieldAlerts>
                        <xsd:fieldTc>" . $fieldTc . "</xsd:fieldTc>
                        
                        </xsd:policyAdditionalFieldsDOList>
                        <xsd:policyNum></xsd:policyNum>
                        <xsd:proposalNum></xsd:proposalNum>
                        <xsd:quotationReferenceNum></xsd:quotationReferenceNum>
                        <xsd:sumInsured>" . $sumInsured . "</xsd:sumInsured>
                        <xsd:term>" . $proposalTenourCode . "</xsd:term>
                        
                        <xsd:uwDecisionCd></xsd:uwDecisionCd>
                        <xsd:isPremiumCalculation>YES</xsd:isPremiumCalculation>
                        </xsd:policy>
                        </rel:intIO>
                        </rel:createPolicySecure>
                        </soap:Body>
                        </soap:Envelope>";


        file_put_contents("data/secure/" . $fileNameRequest . "_createPolicySecure_Request.xml", $xmlData);
        $options = array(
            'trace' => true,
            'exceptions' => 1,
            'style' => SOAP_DOCUMENT,
            'use' => SOAP_LITERAL,
            'soap_version' => SOAP_1_2,
        );
        $client = new SoapClient(WSDLURL, $options);
        $location = ENDPOINTURL;
        $action = "urn:createPolicySecure";
        $res = $client->__doRequest($xmlData, $location, $action, SOAP_1_2);
       
        $xml = new xml2array($res);
        $dataArr = $xml->getResult();
        file_put_contents("data/secure/" . $fileNameRequest . "_createPolicySecure_Response.xml", $res);
        $getPropasalNumber = $dataArr['soapenv:Envelope']['soapenv:Body']['ns:createPolicySecureResponse']['ns:return']['int-policy-data-iO']['policy']['proposal-num']['#text'];
        $getPropasalPrimiumNumber = $dataArr['soapenv:Envelope']['soapenv:Body']['ns:createPolicySecureResponse']['ns:return']['int-policy-data-iO']['policy']['premium']['#text'];
        $errorData = $dataArr['soapenv:Envelope']['soapenv:Body']['ns:createPolicySecureResponse']['ns:return']['int-policy-data-iO']['error-lists']['err-description']['#text'];
        if($errorData != ''){
           $errorMSGE = "Service response-".$errorData.'.Please try again'; 
        } else {
            $errorMSGE = '';
        }
        $checkId= hash('sha256', "proposal-$policyId");
        if ($getPropasalNumber != '') {
            $updateSqlProposal = "UPDATE REFERENCE_DATA SET  
               PROPOSAL_ID='" . $getPropasalNumber . "',PREMIUM_AMT='" . $getPropasalPrimiumNumber . "' WHERE REFERENCE_ID =$policyId";
            $updateStdidProposal = @oci_parse($conn, $updateSqlProposal);
            $r = @oci_execute($updateStdidProposal);
            /* check User Profile */
 $checkUserCreation = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:rel="http://relinterface.insurance.symbiosys.c2lbiz.com" xmlns:xsd="http://intf.insurance.symbiosys.c2lbiz.com/xsd">
   <soap:Header/>
   <soap:Body>
      <rel:UserConfirmation>
         <!--Optional:-->
         <rel:intIO>
            <!--Optional:-->
            <xsd:errorLists>?</xsd:errorLists>
            <!--Optional:-->
            <xsd:listErrorListList>?</xsd:listErrorListList>
            <xsd:userId>' . $emailAddress . '</xsd:userId>
         </rel:intIO>
      </rel:UserConfirmation>
   </soap:Body>
</soap:Envelope>';
            file_put_contents("data/secure/" . $fileNameRequest . "_User_Confirmation_Request.xml", $checkUserCreation);
            $client = new SoapClient(WSDLURL, $options);
            $location = ENDPOINTURL;
            $action = "urn:userConfirmation";
            $res = $client->__doRequest($checkUserCreation, $location, $action, SOAP_1_2);
            file_put_contents("data/secure/" . $fileNameRequest . "_User_Confirmation_Respose.xml", $res);
            $xml = new xml2array($res);
            $dataArr = $xml->getResult();
            $checkUserData = $dataArr['soapenv:Envelope']['soapenv:Body']['ns:UserConfirmationResponse']['ns:return']['int-get-user-confirmation-iO']['user-confirmation-flag']['#text'];

            if ($checkUserData == 'NO') {
            $userCreation = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:rel="http://relinterface.insurance.symbiosys.c2lbiz.com" xmlns:xsd="http://intf.insurance.symbiosys.c2lbiz.com/xsd">
   <soap:Header/>
   <soap:Body>
      <rel:userCreation>
         <!--Optional:-->
         <rel:intIO>
            <!--Optional:-->
            <xsd:errorLists>?</xsd:errorLists>
            <!--Optional:-->
            <xsd:listErrorListList>?</xsd:listErrorListList>
            <!--Optional:-->
            <xsd:contactNum>' . $contactNum . '</xsd:contactNum>
            <!--Optional:-->
            <xsd:contactPhoneNum>' . $contactNum . '</xsd:contactPhoneNum>
            <!--Optional:-->
            <xsd:dateOfBirth>' . $birthDt . '</xsd:dateOfBirth>
            <!--Optional:-->
            <xsd:emailId>' . $emailAddress . '</xsd:emailId>
            <!--Optional:-->
            <xsd:firstname>' . $firstName . '</xsd:firstname>
            <!--Optional:-->
            <xsd:password></xsd:password>
            <!--Optional:-->
            <xsd:stdCode>91</xsd:stdCode>
            <!--Optional:-->
            <xsd:surname>' . $firstName . '</xsd:surname>
            <!--Optional:-->
            <xsd:title>' . $titleCd . '</xsd:title>
            <!--Optional:-->
            <xsd:userId></xsd:userId>
         </rel:intIO>
      </rel:userCreation>
   </soap:Body>
</soap:Envelope>';
                file_put_contents("data/" . $fileNameRequest . "_User_Creation_Request.xml", $userCreation);
                $action1 = "urn:userCreation";
                $res1 = $client->__doRequest($userCreation, $location, $action1, SOAP_1_2);
                file_put_contents("data/" . $fileNameRequest . "_User_Creation_Response.xml", $res1);
                
                 $xmlUserData = new xml2array($res1);
                  $dataArrUserData = $xmlUserData->getResult();
                 // echo '<pre>';print_r($dataArrUserData);exit;
                  $userEmailID = $dataArrUserData['soapenv:Envelope']['soapenv:Body']['ns:userCreationResponse']['ns:return']['int-user-creation-iOResponse']['user-id']['#text'];
                  $userpasswordId = $dataArrUserData['soapenv:Envelope']['soapenv:Body']['ns:userCreationResponse']['ns:return']['int-user-creation-iOResponse']['password']['#text'];
               
          $sqlUser = "INSERT INTO TBL_USER_CREATION 
    (ID,
    USER_EMAIL,
    USER_PASSWORD,
    USER_STATUS
   ) values 
            (TBL_USER_CREATION_SEQ.nextval,
            '" . $userEmailID . "',
            '" . $userpasswordId . "',
            '0' ) ";
              $stdidUser = @oci_parse($conn, $sqlUser);
               @oci_execute($stdidUser); 
               
           //  echo $sqlUser; exit;
                  
            }


           
            if (isset($getPropasalPrimiumNumber) && ($getPropasalPrimiumNumber != '')) {
                if($getPropasalPrimiumNumber >0) {
                header("LOCATION:secure.php?id=$policyId&code=$checkId&status=1");
                exit;
				} else {
                   $_SESSION['errorMSGE'] = "This action is not allowed. For further assitance contact our customer support on 1800-200-4488.";
                header("LOCATION:secure.php?id=$policyId&code=$checkId");
                exit;
				}
            } else {
                $_SESSION['errorMSGE'] = $errorMSGE;
                header("LOCATION:secure.php?id=$policyId&code=$checkId");
                exit;
            }
        } else {
            $_SESSION['errorMSGE'] = $errorMSGE;
            header("LOCATION:secure.php?id=$policyId&code=$checkId");
            exit;
        }
    } else {
        
          $query['leadstage'] = sanitize_data("Se-Semi filled Proposal");
          $query['subject'] = sanitize_data("Se-Semi filled Proposal");
          $query['rhiproduct'] = sanitize_data("SECURE");
          $query['mobilephone'] = sanitize_data($contactNum);
          $query['agentid'] = sanitize_data($baseAgentId);
          $query['rhi_suminsured'] = sanitize_data($proposalDummySi);
          $query['rhi_premium'] = sanitize_data($PREMIUM_AMOUNT);
          $query['rhi_noofyears'] = sanitize_data($proposalTenourCode);
          $subject = 'Secure Proposal Page';
          saveContinueMailAssure($titleCd,$firstName,$lastName,$saveandcontinueemail, $subject, $proposalTenourCode, $totalChildMember, $totalMember, $proposalageGroupOfEldestMember, $PREMIUM_AMOUNT, $proposalDummySi, $policyId,'SECURE',$query);
    }
} else {
    header("LOCATION:error.php");
    exit;
}
?>