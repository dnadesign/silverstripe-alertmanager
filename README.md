silverstripe-alertmanager
=========================

Manages emails, session and request alerts

Recommend also using:
wildbit/swiftmailer-postmark

If you're using PostMark then you can use the following:

---
Only:
  environment: 'live'
---

DNADesign\AlertManager\PostMarkTransport:
  server_token: xxx

SilverStripe\Core\Injector\Injector:
  Swift_Transport: DNADesign\AlertManager\PostMarkTransport
  SilverStripe\Control\Email\Mailer:
    class: DNADesign\AlertManager\PostMarkSwiftMailer
