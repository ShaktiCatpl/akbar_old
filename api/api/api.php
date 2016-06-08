<?php
require_once 'lib/nusoap.php';
    $xml_data = "<soap:Envelope xmlns:soap='http://www.w3.org/2003/05/soap-envelope' xmlns:rel='http://relinterface.insurance.symbiosys.c2lbiz.com' xmlns:xsd='http://intf.insurance.symbiosys.c2lbiz.com/xsd'>
<soap:Header/><soap:Body>
<rel:createPolicyEnhance> 
<rel:intIO>
<xsd:policy>
<xsd:addOns>EXPERTOPNENH1</xsd:addOns>
<xsd:businessTypeCd>NEWBUSINESS</xsd:businessTypeCd>
<xsd:baseProductId>11001001</xsd:baseProductId>
<xsd:baseAgentId>20008135</xsd:baseAgentId>
<xsd:coverType>INDIVIDUAL</xsd:coverType>
<xsd:partyDOList>
<xsd:birthDt>13/11/1979</xsd:birthDt>
<xsd:firstName>Reshma</xsd:firstName>
<xsd:genderCd>FEMALE</xsd:genderCd>
<xsd:guid>41</xsd:guid>
<xsd:lastName>Gaikwad</xsd:lastName>
<xsd:partyAddressDOList>
<xsd:addressLine1Lang1>Tes Address</xsd:addressLine1Lang1>
<xsd:addressLine2Lang1></xsd:addressLine2Lang1>
<xsd:addressTypeCd>PERMANENT</xsd:addressTypeCd>
<xsd:areaCd>NEW DELHI</xsd:areaCd>
<xsd:cityCd>NEW DELHI</xsd:cityCd>
<xsd:pinCode>110001</xsd:pinCode>
<xsd:stateCd>DELHI</xsd:stateCd>
</xsd:partyAddressDOList>
<xsd:partyContactDOList>
<xsd:contactNum>9990968100</xsd:contactNum>
<xsd:contactTypeCd>MOBILE</xsd:contactTypeCd>
<xsd:stdCode></xsd:stdCode>
</xsd:partyContactDOList>
<xsd:partyEmailDOList>
<xsd:emailAddress>reshma@logicalfire.com</xsd:emailAddress>
<xsd:emailTypeCd>PERSONAL</xsd:emailTypeCd>
</xsd:partyEmailDOList>
<xsd:partyIdentityDOList>
<xsd:identityNum></xsd:identityNum>
<xsd:identityTypeCd></xsd:identityTypeCd>
</xsd:partyIdentityDOList>
<xsd:relationCd>SELF</xsd:relationCd>
<xsd:roleCd>PROPOSER</xsd:roleCd>
<xsd:titleCd>MS</xsd:titleCd>
</xsd:partyDOList>
<xsd:partyDOList>
<xsd:birthDt>13/11/1979</xsd:birthDt>
<xsd:firstName>Reshma</xsd:firstName>
<xsd:genderCd>FEMALE</xsd:genderCd>
<xsd:guid>41</xsd:guid>
<xsd:lastName>gehlawat</xsd:lastName>
<xsd:partyAddressDOList>
<xsd:addressLine1Lang1>Tes Address</xsd:addressLine1Lang1>
<xsd:addressLine2Lang1></xsd:addressLine2Lang1>
<xsd:addressTypeCd>PERMANENT</xsd:addressTypeCd>
<xsd:areaCd>NEW DELHI</xsd:areaCd>
<xsd:cityCd>NEW DELHI</xsd:cityCd>
<xsd:pinCode>110001</xsd:pinCode>
<xsd:stateCd>DELHI</xsd:stateCd>
</xsd:partyAddressDOList>
<xsd:partyContactDOList>
<xsd:contactNum>9990968100</xsd:contactNum>
<xsd:contactTypeCd>MOBILE</xsd:contactTypeCd>
<xsd:stdCode>+91</xsd:stdCode>
</xsd:partyContactDOList>
<xsd:partyEmailDOList>
<xsd:emailAddress>reshma@logicalfire.com</xsd:emailAddress>
<xsd:emailTypeCd>PERSONAL</xsd:emailTypeCd>
</xsd:partyEmailDOList>
<xsd:partyIdentityDOList>
<xsd:identityNum></xsd:identityNum>
<xsd:identityTypeCd></xsd:identityTypeCd>
</xsd:partyIdentityDOList>
<xsd:partyQuestionDOList>
	<xsd:questionCd></xsd:questionCd>
	<xsd:questionSetCd></xsd:questionSetCd>
	<xsd:response></xsd:response>
</xsd:partyQuestionDOList>
<xsd:relationCd>SELF</xsd:relationCd>
<xsd:roleCd>PRIMARY</xsd:roleCd>
<xsd:titleCd>MS</xsd:titleCd>
<xsd:partyEmploymentDOList>
<xsd:occupationCd>I001</xsd:occupationCd>
</xsd:partyEmploymentDOList>
</xsd:partyDOList>
<xsd:policyAdditionalFieldsDOList>
    <!--Optional:-->
 <xsd:field1>51013</xsd:field1>
   <!--Optional:-->
<xsd:field2>PUNE</xsd:field2>
     <!--Optional:-->
<xsd:field3>9878545123</xsd:field3>
<xsd:fieldAgree>YES</xsd:fieldAgree>
<xsd:fieldAlerts>YES</xsd:fieldAlerts>
<xsd:fieldTc>YES</xsd:fieldTc>
</xsd:policyAdditionalFieldsDOList>
<xsd:policyNum></xsd:policyNum>
<xsd:proposalNum></xsd:proposalNum>
<xsd:quotationReferenceNum></xsd:quotationReferenceNum>
<xsd:sumInsured>001</xsd:sumInsured>
<xsd:term>3</xsd:term>
<xsd:uwDecisionCd></xsd:uwDecisionCd>
<xsd:isPremiumCalculation>YES</xsd:isPremiumCalculation>
</xsd:policy>
</rel:intIO>
</rel:createPolicyEnhance>
</soap:Body>
</soap:Envelope>";
   $client = new SoapClient("https://rhicluat.religare.com/relinterface/services/RelSymbiosysServices?wsdl");
   $wsdl=$client->__getFunctions();
   //$wsdl=$client->createPolicyEnhance();
   echo '<pre>';print_r($wsdl);exit;
   
?>