<?php
ini_set("display_errors", 1);

require_once 'inc/conf.php';
//session_start();
include_once("conf/session.php");
include_once('api/api/xml2array.php');
include_once("api/api/domxml-php4-to-php5.php");
include_once("inc/travelConf.php");
$fileNameRequest = time();



function dateformateChange($val) {
    return date("d/m/Y", strtotime($val));
}

function fixArrayOfCheckboxes($checks) {
    $newChecks = array();
    for ($i = 0; $i < count($checks); $i++) {
        if ($checks[$i] == '0' && $checks[$i + 1] > 0) {
            $newChecks[] = $checks[$i + 1];
            $i++;
        } else {
            $newChecks[] = '0';
        }
    }
    return $newChecks;
}

$dependents = array();

if (isset($_POST)) {
    $tripEndDate = sanitize_data($_POST['endDate']);
    $tripStartDate = sanitize_data($_POST['startDate']);
    $tripTypeCd = sanitize_data($_POST['tripType']);
    $nomineeName = sanitize_data($_POST['ValidNomniee']);
    $maximumtripduration = sanitize_data($_POST['maximumtripduration']);
    $proposalageGroupOfEldestMember = $_POST['proposalageGroupOfEldestMember'];
    $pedQuestion = @$_POST['pedQuestion'];
    
    $sourceData = array(
        "NomineeName" => $nomineeName,
        "tripEndDate" => $tripEndDate,
        "tripStartDate" => $tripStartDate,
        "tripTypeCd" => $tripTypeCd,
        "ValidCityName" => sanitize_data($_POST['ValidCityName']),
        "pedQuestion" => $pedQuestion,);
 //"maximumtripduration" => $maximumtripduration,
    
    

    /*
      if (isset($_POST)) {
      $rmCode = sanitize_data($_POST['rmCode']);
      $branchCode = sanitize_data($_POST['branchCode']);
      $tripEndDate = sanitize_data($_POST['tripEndDate']);
      $tripEndDate = sanitize_data($_POST['tripEndDate']);

      $tripStartDate = sanitize_data($_POST['tripStartDate']);
      $tripTypeCd = sanitize_data($_POST['tripTypeCd']);
      $TripStartIndia = sanitize_data($_POST['TripStartIndia']);
      $nomineeName = sanitize_data($_POST['NomineeName']);

      $sourceData = array(
      "quotationReferenceNum" => sanitize_data($_POST['quotationReferenceNum']),
      "rmCode" => $rmCode,
      "branchCode" => $branchCode,
      "NomineeName" => $nomineeName,
      "ValidCityName" => sanitize_data($_POST['ValidCityName']),
      "tripEndDate" => $tripEndDate,
      "tripStartDate" => $tripStartDate,
      "tripTypeCd" => $tripTypeCd,
      "TripStartIndia" => $TripStartIndia,
      );
     */

    for ($i = 0; $i < count($_POST['relationCd']); $i++) {
        $dependents[$i] = array(
            'relationCd' => sanitize_data($_POST['relationCd'][$i]),
            'titleCd' => sanitize_data($_POST['titleCd'][$i]),
            'firstNameCd' => sanitize_data($_POST['firstNameCd'][$i]),
            'lastNameCd' => sanitize_data($_POST['lastNameCd'][$i]),
            'dOBCd' => sanitize_data($_POST['dOBCd'][$i]),
            'passportCd' => sanitize_data($_POST['passport'][$i])
        );
    }

    //echo '<pre>'; print_r($_POST);exit;
    
    $sumInsured = sanitize_data($_POST['proposalSumInsured']);
    $baseProductId = sanitize_data($_POST['proposalProductCode']);
    //$proposalDummySi = sanitize_data($_POST['proposalDummySi']);

    $qnaT = $_POST['questions'];
    $qna = base64_encode(json_encode($qnaT));
    
    $businessTypeCd = "NEWBUSINESS";
    //$baseAgentId = sanitize_data($_POST["agentId"]);
    $baseAgentId = "20008325";
    $totalMember = sanitize_data($_POST['totalAdultMember']);

    /*
      if ($totalMember == 1) {
      $coverType = "INDIVIDUAL";
      } else {
      $coverType = "FAMILYFLOATER";
      }
     */

    $coverType = "INDIVIDUAL";
    $birthDt = sanitize_data($_POST['DOB']);
    $firstName = sanitize_data($_POST['ValidFName']);
    $lastName = sanitize_data($_POST['ValidLName']);
    $titleCd = sanitize_data($_POST['ValidTitle']);

    if ($titleCd == 'MR') {
        $genderCd = "MALE";
    } else if ($titleCd == "MS") {
        $genderCd = "FEMALE";
    }

    $guid = time();
    $checkclickid = sanitize_data($_POST['checkclickid']);
    //$addons = sanitize_data($_POST['addOns']);
    $state = sanitize_data($_POST['ValidStateName']);
    $addressLine1Lang1 = sanitize_data($_POST['ValidAddressOne']);
    $addressLine1Lang2 = sanitize_data($_POST['ValidAddressTwo']);
    $addressTypeCd = "PERMANENT";
    $areaCd = sanitize_data($_POST['ValidCityName']);
    
    $pinCode = sanitize_data($_POST['ValidPinCode']);
    //$stateCd = sanitize_data($_POST['ValidStateName']);
    $stateCD = 'NEW Delhi';
    $contactNum = sanitize_data($_POST['ValidMobileNumber']);

    $contactTypeCd = 'MOBILE';
    $emailAddress = sanitize_data_email($_POST['ValidEmail']);
    
    //$saveandcontinueemail = sanitize_data_email($_POST['saveandcontinueemail']);
     $proposalTenourCode = sanitize_data($_POST['proposalTenourCode']);
    //$ValidPanCard = sanitize_data($_POST['ValidPanCard']);

    $emailTypeCd = 'PERSONAL';
    $addressTypeCdC = 'COMMUNICATION';
    $relationCd = 'SELF';
    $roleCd = 'PROPOSER';
    
    $source = sanitize_data($_POST['source']);
    $fieldTc = sanitize_data($_POST['validTermCondition']);
    
    
    //$totalChildMember = sanitize_data($_POST['totalChildMember']);
    //$proposalageGroupOfEldestMember = $_POST['proposalageGroupOfEldestMember'];
    // $fieldAlerts = sanitize_data($_POST['recivedSms']);
    //$SICREDITCARD = sanitize_data($_POST['SICREDITCARD']);

    $primaryData = '';
    $PREMIUM_AMOUNT = str_replace(',', '', $_POST['permiumamountValid']);
    $new = md5("NEW");
    $requestedID = sanitize_data($_POST['proposalRequestId']);
    $dependents = json_encode($dependents);
    $conn = dbConnect();


    if ($requestedID == $new || $checkclickid == 1) {
        $sql = "INSERT INTO REFERENCE_TRAVELDATA 
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
    UTM_SOURCE,
    BUYMODE
   ) values 
            (REFERENCE_TRAVELDATA_SEQ.nextval,
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
            'Travel',
            '" . time() . "',
            '" . json_encode($sourceData) . "',
            '" . $SICREDITCARD . "'
) ";
       
        $stdid = @oci_parse($conn, $sql);
        $r = @oci_execute($stdid);

        $qu2 = "select REFERENCE_TRAVELDATA_SEQ.currval from dual";
        $stdids2 = @oci_parse($conn, $qu2);
        @oci_execute($stdids2);
        $lastinsertId2 = oci_fetch_assoc($stdids2);
        $policyId = $lastinsertId2['CURRVAL'];
    } else {
        $updateSql = "UPDATE REFERENCE_TRAVELDATA SET  
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
    UPDATED_TS = '" . time() . "',
    BUYMODE = '" . $SICREDITCARD . "'
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
    if (isset($TripStartIndia)) {
        $TripStartIndia = "YES";
    }

/*
    if ($tripTypeCd == 'MULTI') {
        $maxTripPeriod = $proposalTenourCode;
        $proposalTenourCode = no_of_days($tripStartDate, $tripEndDate);
    } else {
        $maxTripPeriod = '';
    }

*/

    if ($checkclickid == 1) {
        $kgid = $guid + 100;
        for ($i = 0; $i < $totalMember; $i++) {
            $questionData = '';

            if ($dependents[$i]['titleCd'] == 'MR') {
                $genderCdP = "MALE";
            } else if ($dependents[$i]['titleCd'] == 'MS') {
                $genderCdP = "FEMALE";
            }

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

                                    $resultFinalArray = fixArrayOfCheckboxes($gTemVal['qus']);
                                //echo '<pre>';print_r($resultFinalArray);

                                if (isset($gTemVal['qus'][$i])) {

                                    if ($qTemId == "1") {
                                        $qTemId = "pedYesNo";
                                        $questionDataSetCD = "pedYesNoTravel";
                                        $response = $gTemVal['qus'][$i];
                                        $questionData.='<xsd:partyQuestionDOList>
                                            <xsd:questionCd>' . $qTemId . '</xsd:questionCd>
                                            <xsd:questionSetCd>' . $questionDataSetCD . '</xsd:questionSetCd>
                                            <xsd:response>' . $response . '</xsd:response>
                                            </xsd:partyQuestionDOList>';
                                    } else {
                                        $questionDataSetCD = $questionIDTravel[$qTemId]['qSetId'];
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
                                    if ($qTemId == 210) {
                                        $questionData.='<xsd:partyQuestionDOList>
                                    <xsd:questionCd>otherDiseasesDescription</xsd:questionCd>
                                    <xsd:questionSetCd>PEDotherDetailsTravel</xsd:questionSetCd>
                                    <xsd:response>' . $gTemVal['other'][$i] . '</xsd:response>
                                    </xsd:partyQuestionDOList>';
                                    }
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

            $ValidPanCard1 = '';
            if ($dependents[$i]['relationCd'] == 'SELF') {
                $kgid = $guid;
                //$ValidPanCard1 = $ValidPanCard;
                $ValidPanCard1 = 'CRRPK5700R';
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
                <xsd:partyEmailDOList>
                <xsd:emailAddress>" . $emailAddress . "</xsd:emailAddress>
                <xsd:emailTypeCd>" . $emailTypeCd . "</xsd:emailTypeCd>
                </xsd:partyEmailDOList>
                 <xsd:partyIdentityDOList>
                <xsd:identityNum>" . $dependents[$i]['passportCd'] . "</xsd:identityNum>
                <xsd:identityTypeCd>PASSPORT</xsd:identityTypeCd>
                </xsd:partyIdentityDOList>
                <xsd:partyIdentityDOList>
                        <xsd:identityNum>" . $ValidPanCard1 . "</xsd:identityNum>
                        <xsd:identityTypeCd>PAN</xsd:identityTypeCd>
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
                        <rel:createPolicyTravel> 
                        <rel:intIO>
                        <xsd:policy>
                        " . $addOnBenifit . "
                        <xsd:businessTypeCd>" . $businessTypeCd . "</xsd:businessTypeCd>
                        <xsd:baseProductId>" . $baseProductId . "</xsd:baseProductId>
                        <xsd:baseAgentId>". $baseAgentId ."</xsd:baseAgentId>
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
                        <xsd:identityNum>" . $ValidPanCard . "</xsd:identityNum>
                        <xsd:identityTypeCd>PAN</xsd:identityTypeCd>
                        </xsd:partyIdentityDOList>
                        
                        <xsd:relationCd>" . $relationCd . "</xsd:relationCd>
                        <xsd:roleCd>" . $roleCd . "</xsd:roleCd>
                        <xsd:titleCd>" . $titleCd . "</xsd:titleCd>
                        " . $questionDataSetQuest . "
                        </xsd:partyDOList>" . $primaryData . "
                        <xsd:policyAdditionalFieldsDOList>
                            <!--Optional:-->
                         <xsd:field1>" . $branchCode . "</xsd:field1>
                           <!--Optional:-->
                        <xsd:field2>" . $rmCode . "</xsd:field2>
                             <!--Optional:-->
                        <xsd:field3></xsd:field3>
                        <xsd:fieldAgree>YES</xsd:fieldAgree>
                        <xsd:field10>" . $nomineeName . "</xsd:field10>
                        <xsd:fieldAlerts>YES</xsd:fieldAlerts>
                        <xsd:fieldTc>" . $fieldTc . "</xsd:fieldTc>
                        <xsd:field20>2</xsd:field20>
                        <xsd:tripStart>YES</xsd:tripStart>";

        $xmlData .= "</xsd:policyAdditionalFieldsDOList>
                        <xsd:policyNum></xsd:policyNum>
                        <xsd:proposalNum></xsd:proposalNum>
                        <xsd:quotationReferenceNum></xsd:quotationReferenceNum>
                        <xsd:sumInsured>002</xsd:sumInsured>
                        <xsd:policyCommencementDt>" . dateformateChange($tripStartDate) . "</xsd:policyCommencementDt>
                        <xsd:policyMaturityDt>" . dateformateChange($tripEndDate) . "</xsd:policyMaturityDt>
                        <xsd:maxTripPeriod>" . $maxTripPeriod . "</xsd:maxTripPeriod>
                        <xsd:term></xsd:term>
                        <xsd:travelGeographyCd>" . $baseProductId . "</xsd:travelGeographyCd>
                        <xsd:tripTypeCd>SINGLE</xsd:tripTypeCd>
                        <xsd:uwDecisionCd></xsd:uwDecisionCd>
                        <xsd:isPremiumCalculation>YES</xsd:isPremiumCalculation>
                        </xsd:policy>
                        </rel:intIO>
                        </rel:createPolicyTravel>
                        </soap:Body>
                        </soap:Envelope>";


        //$_SESSION['xmlrequestfile'] = $fileNameRequest . "_createPolicyTravel_Request.xml";

        file_put_contents("data/travel/" .$fileNameRequest . "_createPolicyTravel_Request.xml",$xmlData);
        $options = array(
            'trace' => true,
            'exceptions' => 1,
            'style' => SOAP_DOCUMENT,
            'use' => SOAP_LITERAL,
            'soap_version' => SOAP_1_2,
        );



        $client = new SoapClient(WSDLURL, $options);
        $location = ENDPOINTURL;
        $action = "urn:createPolicyTravel";
        $res = $client->__doRequest($xmlData, $location, $action, SOAP_1_2);
        $xml = new xml2array($res);
        $dataArr = $xml->getResult();

        // echo '<pre>';
        // print_r($dataArr);
        //  exit;
        
        

        file_put_contents("data/travel/".$fileNameRequest . "_createPolicyTravel_Response.xml", $res);
        $getPropasalNumber = sanitize_data($dataArr['soapenv:Envelope']['soapenv:Body']['ns:createPolicyTravelResponse']['ns:return']['int-policy-data-iO']['policy']['proposal-num']['#text']);
        $checkagent = sanitize_data($dataArr['soapenv:Envelope']['soapenv:Body']['ns:createPolicyTravelResponse']['ns:return']['int-policy-data-iO']['policy']['is-agent-float']['#text']);
        $checkagent1 = 0;
        
        

        if (isset($checkagent)) {
            if ($checkagent == 'True') {
                $checkagent1 = 1;
            }
        }

        $getPropasalPrimiumNumber = sanitize_data($dataArr['soapenv:Envelope']['soapenv:Body']['ns:createPolicyTravelResponse']['ns:return']['int-policy-data-iO']['policy']['premium']['#text']);
        $errorData = $dataArr['soapenv:Envelope']['soapenv:Body']['ns:createPolicyTravelResponse']['ns:return']['int-policy-data-iO']['error-lists']['err-description']['#text'];
//echo $errorData;
              
        if ($errorData!= '') {
            $errorMSGE = "Service response-" . $errorData . '.Please try again';
        } else {
            $errorMSGE = '';
        }

  //        exit;
          
        $checkId = hash('sha256', "proposal-$policyId");
        if ($getPropasalNumber != '') {
        $updateSqlProposal = "UPDATE REFERENCE_TRAVELDATA SET  
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

            file_put_contents("data/userconfirmation/" . $fileNameRequest . "_User_Confirmation_Request.xml", $checkUserCreation);
            $client = new SoapClient(WSDLURL, $options);
            $location = ENDPOINTURL;
            $action = "urn:userConfirmation";
            $res = $client->__doRequest($checkUserCreation, $location, $action, SOAP_1_2);
            file_put_contents("data/userconfirmation/" . $fileNameRequest . "_User_Confirmation_Respose.xml", $res);
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


                file_put_contents("data/usercration/" . $fileNameRequest . "_User_Creation_Request.xml", $userCreation);
                $action1 = "urn:userCreation";
                $res1 = $client->__doRequest($userCreation, $location, $action1, SOAP_1_2);
                file_put_contents("data/usercration/" . $fileNameRequest . "_User_Creation_Response.xml", $res1);

                $xmlUserData = new xml2array($res1);
                $dataArrUserData = $xmlUserData->getResult();
                // echo '<pre>';print_r($dataArrUserData);exit;
                $userEmailID = $dataArrUserData['soapenv:Envelope']['soapenv:Body']['ns:userCreationResponse']['ns:return']['int-user-creation-iOResponse']['user-id']['#text'];
                $userpasswordId = $dataArrUserData['soapenv:Envelope']['soapenv:Body']['ns:userCreationResponse']['ns:return']['int-user-creation-iOResponse']['password']['#text'];

                $sqlUser = "INSERT INTO TBL_USER_CREATION (ID, USER_EMAIL, USER_PASSWORD,USER_STATUS) values (TBL_USER_CREATION_SEQ.nextval,'" . $userEmailID . "','" . $userpasswordId . "',
            '0' ) ";
                $stdidUser = @oci_parse($conn, $sqlUser);
                @oci_execute($stdidUser);

                //  echo $sqlUser; exit;
            }


            if (isset($getPropasalPrimiumNumber) && ($getPropasalPrimiumNumber != '')) {
                if ($getPropasalPrimiumNumber > 196) {
                    header("LOCATION:index.php?id=$policyId&code=$checkId&status=1&checkagent=$checkagent1");
                    //header("LOCATION:travel.php?id=$policyId&code=$checkId&status=1&checkagent=$checkagent1");
                    exit;
                } else {
                    if ($errorMSGE != '') {
                        if ($getPropasalNumber != '') {
                            $_SESSION['errorMSGE'] = "Your Proposal Number is <b>$getPropasalNumber</b>. <br />" . $errorMSGE;
                        } else {
                            $_SESSION['errorMSGE'] = $errorMSGE;
                        }
                    } else {
                        $_SESSION['errorMSGE'] = "This action is not allowed. For further assitance contact our customer support on 1800-200-4488.";
                    }
                    
                    header("LOCATION:index.php?id=$policyId&code=$checkId");
                    exit;
                }
            } else {
                $_SESSION['errorMSGE'] = $errorMSGE;
                header("LOCATION:index.php?id=$policyId&code=$checkId");
                exit;
            }
        } else {
            $_SESSION['errorMSGE'] = $errorMSGE;
            header("LOCATION:index.php?id=$policyId&code=$checkId");
            exit;
        }
    } else {

        $query['leadstage'] = sanitize_data("tr-Semi filled Proposal");
        $query['subject'] = sanitize_data("tr-Semi filled Proposal");
        $query['rhiproduct'] = sanitize_data("Travel");
        $query['mobilephone'] = sanitize_data($contactNum);
        $query['agentid'] = sanitize_data($baseAgentId);
        $query['rhi_suminsured'] = sanitize_data($proposalDummySi);
        $query['rhi_premium'] = sanitize_data($PREMIUM_AMOUNT);
        $query['rhi_noofyears'] = sanitize_data($proposalTenourCode);
        $subject = 'Travel Proposal Page';

        $productName = travelToText($baseProductId);
        saveContinueMailTravel($titleCd, $firstName, $lastName, $saveandcontinueemail, $subject, $proposalTenourCode, $baseProductId, $totalMember, $proposalageGroupOfEldestMember, $PREMIUM_AMOUNT, $proposalDummySi, $policyId, $productName, $query);
    }
} else {
    header("LOCATION:error.php");
    exit;
}
?>