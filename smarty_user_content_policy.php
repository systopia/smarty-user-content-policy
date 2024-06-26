<?php

declare(strict_types = 1);

// phpcs:disable PSR1.Files.SideEffects
require_once 'smarty_user_content_policy.civix.php';
// phpcs:enable

use CRM_SmartyUserContentPolicy_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function smarty_user_content_policy_civicrm_config(?\CRM_Core_Config &$config = NULL): void {
  _smarty_user_content_policy_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function smarty_user_content_policy_civicrm_install(): void {
  _smarty_user_content_policy_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function smarty_user_content_policy_civicrm_enable(): void {
  _smarty_user_content_policy_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_userContentPolicy().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_userContentPolicy
 */
function smarty_user_content_policy_civicrm_userContentPolicy(CRM_Core_Smarty_UserContentPolicy $policy): void {
  // Enable access to '{crmAPI}'
  $policy->disabled_tags = array_diff($policy->disabled_tags, ['crmAPI']);
}

/**
 * Implements hook_civicrm_check().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_check
 */
function smarty_user_content_policy_civicrm_check(array &$messages, ?array $statusNames, bool $includeDisabled): void {
  $message = new CRM_Utils_Check_Message(
    E::LONG_NAME . ':smarty-insecure-policy',
    '<p>' . E::ts(
      <<<EOT
      Warning: Smarty is running with an insecure user content policy. Review your Smarty User Content Policy Settings.
      EOT
    ) . '</p>'
    . '<p>' . E::ts(
      <<<EOT
      The security update with CiviCRM versions %1 and %2 introduced a security policy for Smarty, explicitly
      disallowing certain Smarty features (most notably the %3 tag in user content, such as message templates, mailings,
      etc.). The extension "Smarty User Content Policy" made changes to the policy allowing Smarty features that are
      considered insecure, which should be a temporary measure to give you time for revisiting your templates and other
      configuration that contain the now-forbidden features, and replace them with secure alternatives. Once done so,
      re-enable the default Smarty User Content Policy by uninstalling the "Smarty User Content Policy" extension.
      EOT,
      [
        1 => '<code>5.74.4</code>',
        2 => '<code>5.69.6</code>',
        3 => '<code>{crmAPI}</code>',
      ]
    ) . '</p>',
    E::ts('Insecure Smarty User Content Policy'),
    CRM_Core_Config::environment() == 'Production' ? \Psr\Log\LogLevel::ERROR : \Psr\Log\LogLevel::WARNING,
    'fa-bug'
  );
  $message->addAction(
    E::ts('Disable the Smarty User Content Policy extension'),
    FALSE,
    'href',
    ['url' => 'civicrm/admin/extensions?action=disable&id=smarty-user-content-policy&key=smarty-user-content-policy'],
    'fa-cogs'
  );
  $messages[] = $message;
}
