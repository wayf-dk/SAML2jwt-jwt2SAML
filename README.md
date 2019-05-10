# SAML2jwt-jwt2SAML
PHP demo libraries for WAYF SAML2jwt and jwt2SAML back-channel services

## QuickStart

* Register sp.entity.test and idp.entity.test to point to your 'server'
* Start PHP built-in server with "php -S 0.0.0.0:8080 -t entity.test" ie with the entity.test folder as documentroot
* In a "fresh" browser - preferably FireFox with the SAML-tracer (https://github.com/UNINETT/SAML-tracer) installed - go to
https://wayfsp.wayf.dk and click on the "Use Hybrid QA" button. This will make your browser use the WAYF QA back-end
for the duration of the session.
* Enable the SAML Tracing
* Point your browser to http://sp.entity.test:8080
* Experiment with changing the attributes in the $payload in the idp.php

The idp.entity.test IdP is 'open' in the sense that you can make it send any attributes - as long as the eppn ends
with '@entity.test'.

It is though only member of the ad-hoc federation 'entity.test' so you will
restricted to send responses only to a SP that is also in the ad-hoc federation 'entity.test'.

The sp.entity.test SP is also member of the ad-hoc federation
'entity.test' and thus is allowed to use idp.entity.test as IdP.

If you want to use idp.entity.test as an IdP for testing your own SP you need to contact the WAYF secretariat
for adding it to the 'entity.test' ad-hoc federation.