silverstripe-alertmanager
=========================

Manages emails, session and request alerts

Recommend also using v2.1.0 (SS4 compatible due to SwiftMailer < v6):
[wildbit/swiftmailer-postmark] (https://github.com/wildbit/swiftmailer-postmark/tree/2.1.0)

If you're using PostMark then you can use the following:

```yml
---
Name: somename
After:
  - '#emailconfig'
Only:
  environment: 'live'
---


DNADesign\AlertManager\PostMarkTransport:
  server_token: xxx

SilverStripe\Core\Injector\Injector:
  Swift_Transport: DNADesign\AlertManager\PostMarkTransport
  SilverStripe\Control\Email\Mailer:
    class: DNADesign\AlertManager\PostMarkSwiftMailer

SilverStripe\Control\Email\Email:
  admin_email:
    support@example.com: 'Support'
```
