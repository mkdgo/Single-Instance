<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


$spBaseUrl = $GLOBALS['SCHOOL']['full_url'];

$settingsInfo = array (
       'sp' => array (
            'entityId' => $spBaseUrl.'/demo1/metadata.php',
            'assertionConsumerService' => array (
                'url' => $spBaseUrl.'/a1/index/acs',
            ),
            'singleLogoutService' => array (
                'url' => $spBaseUrl.'/a1/index/sls',
            ),
            'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:unspecified',
        ),
        'idp' => array (
            'entityId' => 'https://app.onelogin.com/saml/metadata/397365',
            'singleSignOnService' => array (
                'url' => 'https://app.onelogin.com/trust/saml2/http-post/sso/397365',
            ),
            'singleLogoutService' => array (
                'url' => $spBaseUrl.'/a1',
//                'url' => 'https://app.onelogin.com/trust/saml2/http-redirect/slo/397365',
            ),
            'x509cert' => 'MIIEFDCCAvygAwIBAgIUT5zV5a/N4HFRN+kT03DTTepabr8wDQYJKoZIhvcNAQEF
BQAwVzELMAkGA1UEBhMCVVMxEDAOBgNVBAoMB0VkaWZhY2UxFTATBgNVBAsMDE9u
ZUxvZ2luIElkUDEfMB0GA1UEAwwWT25lTG9naW4gQWNjb3VudCA0NzI5ODAeFw0x
NDA5MTAxNzI5NTlaFw0xOTA5MTExNzI5NTlaMFcxCzAJBgNVBAYTAlVTMRAwDgYD
VQQKDAdFZGlmYWNlMRUwEwYDVQQLDAxPbmVMb2dpbiBJZFAxHzAdBgNVBAMMFk9u
ZUxvZ2luIEFjY291bnQgNDcyOTgwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEK
AoIBAQC6Rm+fAtIjltRLDp75yWK5Or5aWJ3pOrCAyVPSCRakU4d5qZ4h1IaE0oHH
YuwdhHy25+X1/l2ak1QP7RTEt6lU262UFeFJ7z24cRL8UZIb3CCIDor9w64JdtLx
WFpU9nMYMuvv+mXrHB300gIPpg71EK+/WHp+NCCB76SwBk0h3TjfUq69M4D630QP
YVf+MYm39OEpzQ9EXzDddGLG7qImoAHlBv9ECnN9jog6NOGSZkDtvZ8HD2jBGrKu
/jc4kb4H7vdGS/nKT0js8uPd7DDmvrLw5cXEDIcR0qzIryzVu9XEVjAS0JnsZMd4
HrCeT6N2d+fPOfP6hcspkpYzXpnfAgMBAAGjgdcwgdQwDAYDVR0TAQH/BAIwADAd
BgNVHQ4EFgQUlRejizcEog9AGb9tnLh7hEWGz/EwgZQGA1UdIwSBjDCBiYAUlRej
izcEog9AGb9tnLh7hEWGz/GhW6RZMFcxCzAJBgNVBAYTAlVTMRAwDgYDVQQKDAdF
ZGlmYWNlMRUwEwYDVQQLDAxPbmVMb2dpbiBJZFAxHzAdBgNVBAMMFk9uZUxvZ2lu
IEFjY291bnQgNDcyOTiCFE+c1eWvzeBxUTfpE9Nw003qWm6/MA4GA1UdDwEB/wQE
AwIHgDANBgkqhkiG9w0BAQUFAAOCAQEAfzuPU/DpWTJvQU75ji46kZkP7xmknFkY
+U01ofFYQSdJZHJe1l/6WaOie676nMd8mwnGgUXgoy0TpdcPOXqoEMklftuKRq1R
4yBzbwbkW4s3GpM7FaX/7MZvrYcMw9fk95nDztgYekP7HJaK4aP8SjA3VMiEa942
R3cgMFmnPqc0LEP6woBjVVDzaB1nkTOUBXlj4Ei/2+x7/kY28+rKqApKnJYCrDuK
uihcMFZdOMySHMdTBWSz3pArXRYGXxXTV5d53Zr2I9ctxgIC7EW0mMxpCh1t2Qiy
U/sVoPVY+luJXXnKCOB7KCgPeGaKBhtY7uYlQ529c8y6BlP2DqtCxw==',
        ),
    );

$config['onelogininfo'] = $settingsInfo;
?>