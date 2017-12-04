silverstripe-alertmanager
=========================

Manages emails, session and request alerts

Recommend also using:
markguinn/silverstripe-email-helpers
wildbit/swiftmailer-postmark

---
Only:
  environment: 'live'
---
SilverStripe\Core\Injector\Injector:
  Swift_Transport: \Postmark\Transport
