<?php

$publicKey   =
'-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA54K3rUT473T2Ot5VRXW0UdB72beHrXZbfw5q5Z+1VWvAfQImlgIUYAxQFwMWQ+ChwD5ekHapp0X792cSsgNtNWDGrJ7AHRM5aYyioySeuSZLTHQCJEcgG2TMhYVqb4TAa0UYDkfDeyMY+gNeDhwZPvfW6gKS2wfkQu354UNdIE5SDHIrNl/w1NdFsuSwh0/E2BnTh7klrAWjVydhtNVhByV4yo5hjesgNfEDwFObhlgI2TEs7S/tgrv6Z8XlPVDkLsVeK+hAj4DaaL+oaXAu36gPzWN1iSL+/sCldmLSx1xGi8D0fjIUK/i1Pl/8+W7xgnxpdIaknyABM+2Rj26X1wIDAQAB
-----END PUBLIC KEY-----';

$saml2jwt       = 'https://wayf.wayf.dk/saml2jwt';
$saml2jwtIssuer = 'sp.entity.test';
$saml2jwtACS    = 'http://entity.test:8080/sp';
$idplist        = []; //['idp.entity.test'];

$query = ['acs'    =>  $saml2jwtACS,
          'issuer' =>  $saml2jwtIssuer];

if (empty($_POST['SAMLResponse'])) {

    $query['idplist'] = join(',', $idplist);
    $opts = ['http'=> ['header'  => "Cookie: wayfid=wayf-qa;\r\n", 'follow_location' => 0]];
    file_get_contents($saml2jwt . '?' . http_build_query($query), false, stream_context_create($opts));
    array_walk($http_response_header, function($header) { header($header, false); });
    exit;

} else {

    $opts = ['http'=> ['method'  => 'POST',
                       'content' => http_build_query(array_merge($query, $_POST)),
                       'header'  => "Cookie: wayfid=wayf-qa;\r\n" .
                                    "Content-Type: application/x-www-form-urlencoded", ]];

    $jwt =  file_get_contents($saml2jwt, false, stream_context_create($opts));
    list($header, $body, $signature) = explode(".", $jwt);
    $ok = openssl_verify("$header.$body", base64url_decode($signature), $publicKey, 'sha256');
    $payload =  $ok === 1 ? json_decode(base64url_decode($body), true) : [];

    header('content-type: text/plain');

    foreach(['iat', 'nbf', 'exp'] as $k ) {
//        $payload[$k] = date(DATE_ISO8601, $payload[$k]);
    }

    print_r($payload);
}

function base64url_decode($b64url) { return base64_decode(strtr($b64url, ['-' => '+', '_' => '/'])); }
