# SAML2jwt-jwt2SAML
PHP demo libraries for WAYF SAML2jwt and jwt2SAML back-channel services

## QuickStart

* Register sp.entity.test and idp.entity.test to point to your 'server'
* Start PHP built-in server with "php -S 0.0.0.0:8080 -t entity.test" ie with the entity.test folder as documentroot
* In a "fresh" browser - preferably FireFox with the SAML-tracer (https://github.com/UNINETT/SAML-tracer) installed - go to
https://wayfsp.wayf.dk and click on the "Use Hybrid QA" button. This will make your browser use the WAYF QA back-end
for the duration of the session.
* Enable the SAML Tracing
* Point your browser to http://sp.entity.test
* Experiment with changing the attributes in the $payload in the idp.php

