# Smarty User Content Policy

This extension makes changes to the *Smarty* User Content Policy introduced with CiviCRM versions `5.74.4` and `5.69.6`,
most notably allowing the use of the `{crmAPI}` *Smarty* tag in user content (such as message templates, mailings,
scheduled reminders, etc.), which is forbidden by the default user content policy.

When you have message templates (or other *Smarty* templates in configuration) that make use of the `{crmAPI}` *Smarty*
tag and can't replace them with something else, this extension re-allows that. It will, however, place an error message
in the status report, as this is effectively re-opening the security hole that got closed by introducing that strict
policy in the first place. But it gives you time to investigate where in your templates the `{crmAPI}` tag is being used
and replcae it (e.g. with tokens).

For more information on the Smarty User Content Policy introduced with the aforementioned security updates, see the
[update announcement](https://civicrm.org/blog/dev-team/civicrm-5744-5696-esr-security-release) and the
[security advisory](https://civicrm.org/advisory/civi-sa-2024-03-smarty-security-policy).

As a mid-term solution, you might consider another extension that provides a less insecure version of the `{crmAPI}`
tag: [smarty_reduced_security](https://github.com/eileenmcnaughton/smarty_reduced_security) - however, this is also
considered a transitional solution; also, it alters your templates in the database, so it is not easily reversable.
