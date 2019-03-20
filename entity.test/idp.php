<?php

$privateKey =
'-----BEGIN PRIVATE KEY-----
MIIBVgIBADANBgkqhkiG9w0BAQEFAASCAUAwggE8AgEAAkEAsgRFJ+psFzEePZXP jOtL6KXf6MtftKIxmW6YR08E2LCjvP0Ld3kqzgb2BbSAC3/MsBVG0VtZaBRFqfvq gKZ6zwIDAQABAkAV+jb7fZKIrnS4T7WHBUmi2E+zcuBG8btD4QaFzzie88L7qjAH VZ6+FYvXsIYwB60htQYkwqWZcr9N7g889U3pAiEA5RFdHP6xbTCbgS8gvs2eN/nX V24BbFtaTDcNx6+zZy0CIQDG8lW+xg50MAfjKOShfTqca4DLnCbhDhuPbuaBY0yn awIhALdlPX1XVMos3nOBPeBFU2VRfF0dT7pnMVZPxZKYUzRJAiEAuYkA/FR64FJ2 2JundQ9z3LLJP5nWDGb6vu5fG+W+dBcCIQC8sYX8nrCA1Pgcht19CrM22/MM+oE3 UbZbJ5Eld6UQKg==
-----END PRIVATE KEY-----';

$jwt2saml       = 'https://wayf.wayf.dk/jwt2saml';
$jwt2samlIssuer = 'idp.entity.test';

$header = ['alg' => 'RS256', 'typ' => 'JWT' ];

$payload = [
    'iss'                    =>  $jwt2samlIssuer,
    'iat'                    =>  time(),
    'eduPersonPrincipalName' =>  ["abc@entity.test"],
    'mail'                   =>  ["abc@entity.test"],
    'cn'                     =>  ["First Middle Last"],
    'eduPersonEntitlement'   =>  ["tag:entity.test:abc", "tag:example.com:def"],
];

$signedText = base64url_encode(json_encode($header)) . "." . base64url_encode(json_encode($payload));

$ok = openssl_sign($signedText, $signature, $privateKey, 'sha256');
$query = http_build_query(['SAMLRequest' => $_GET['SAMLRequest'],
                           'RelayState' => $_GET['RelayState'] ?? '',
                           'jwt' => $signedText . "." . base64url_encode($signature)]);
$opts = ['http'=> ['header'  => "Cookie: wayfid=wayf-qa;\r\n", 'follow_location' => 0]];
print file_get_contents("$jwt2saml?$query", false, stream_context_create($opts));

function base64url_encode($data) { return strtr(base64_encode($data), ['+' => '-', '/' => '_', '=' => '']); }
