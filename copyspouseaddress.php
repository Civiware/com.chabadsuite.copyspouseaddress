<?php

require_once 'copyspouseaddress.civix.php';
use CRM_Copyspouseaddress_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function copyspouseaddress_civicrm_config(&$config) {
  _copyspouseaddress_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function copyspouseaddress_civicrm_xmlMenu(&$files) {
  _copyspouseaddress_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function copyspouseaddress_civicrm_install() {
  _copyspouseaddress_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function copyspouseaddress_civicrm_postInstall() {
  _copyspouseaddress_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function copyspouseaddress_civicrm_uninstall() {
  _copyspouseaddress_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function copyspouseaddress_civicrm_enable() {
  _copyspouseaddress_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function copyspouseaddress_civicrm_disable() {
  _copyspouseaddress_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function copyspouseaddress_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _copyspouseaddress_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function copyspouseaddress_civicrm_managed(&$entities) {
  _copyspouseaddress_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function copyspouseaddress_civicrm_caseTypes(&$caseTypes) {
  _copyspouseaddress_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function copyspouseaddress_civicrm_angularModules(&$angularModules) {
  _copyspouseaddress_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function copyspouseaddress_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _copyspouseaddress_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function copyspouseaddress_civicrm_entityTypes(&$entityTypes) {
  _copyspouseaddress_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_alterSettingsMetaData().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsMetaData
 *
 */
function copyspouseaddress_civicrm_alterSettingsMetaData(&$settingsMetadata, $domainID, $profile) {
  $settingsMetadata['share_spouse_address_loc_type'] = [
    'group_name' => 'CiviCRM Preferences',
    'group' => 'core',
    'name' => 'share_spouse_address_loc_type',
    'type' => 'Array',
    'html_type' => 'Select',
    'quick_form_type' => 'Select',
    'html_attributes' => [],
    'pseudoconstant' => [
      'callback' => 'CRM_CopySpouseAddress_BAO_CopySpouseAddress::getLocationTypes',
    ],
    'default' => NULL,
    'add' => '5.8',
    'title' => 'Share spouse address type',
    'is_domain' => '1',
    'is_contact' => 0,
    'description' => NULL,
    'help_text' => NULL,
  ];
  $settingsMetadata['share_spouse_address_cron_run'] = [
    'group_name' => 'CiviCRM Preferences',
    'group' => 'core',
    'name' => 'share_spouse_address_cron_run',
    'type' => 'Boolean',
    'html_type' => 'radio',
    'quick_form_type' => 'YesNo',
    'html_attributes' => [],
    'default' => 0,
    'add' => '5.8',
    'title' => 'Share spouse run only via cron',
    'is_domain' => '1',
    'is_contact' => 0,
    'description' => NULL,
    'help_text' => NULL,
  ];
}

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 */
function copyspouseaddress_civicrm_preProcess($formName, &$form) {
  if ('CRM_Admin_Form_Setting_Miscellaneous' == $formName) {
    $vars = $form->getVar('_settings');
    $vars['share_spouse_address_loc_type'] = CRM_Core_BAO_Setting::SYSTEM_PREFERENCES_NAME;
    $vars['share_spouse_address_cron_run'] = CRM_Core_BAO_Setting::SYSTEM_PREFERENCES_NAME;
    $form->setVar('_settings', $vars);
    CRM_Core_Region::instance('page-body')->add(array(
     'template' => 'CRM/CopySpouseAddress/Admin/Form/Setting/DisplayExtra.tpl',
    ));
  }
}

/**
 * Implements hook_civicrm_pre().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pre
 */
function copyspouseaddress_civicrm_pre($op, $objectName, $id, &$params) {
  if ($op == 'delete' && $objectName == 'Relationship') {
    _copyspouseaddress_civicrm_checkAndDeleteAddress($id);
  }

  if ($op == 'edit' && $objectName == 'Relationship') {
    $rel = civicrm_api3('Relationship', 'getsingle', [
      'return' => ["contact_id_a", 'is_active'],
      'id' => $id,
    ]);
    if (isset($params['is_active'])
      && $rel['is_active'] != $params['is_active']
    ) {
      if ($params['is_active'] == 1) {
        CRM_Core_Smarty::singleton()->assign("rel_copy_address_{$id}", $rel['contact_id_a']);
        return;
      }
      CRM_CopySpouseAddress_BAO_CopySpouseAddress::processSpouse(
        $rel['contact_id_a'],
        FALSE,
        !$params['is_active']
      );
    }
  }
}

function _copyspouseaddress_civicrm_checkAndDeleteAddress($relId) {
  try {
    $results = civicrm_api3('Relationship', 'get', [
      'return' => ["contact_id_a", "contact_id_b"],
      'id' => $relId,
      'relationship_type_id.name_a_b' => ['IN' => ["Spouse of", "Partner of"]],
    ])['values'];
    foreach ($results as $result) {
      CRM_CopySpouseAddress_BAO_CopySpouseAddress::deleteSharedAddress(
        $result['contact_id_a'],
        $result['contact_id_b']
      );
    }
  }
  catch (Exception $e) {
  }
}

/**
 * Implements hook_civicrm_post().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_post
 */
function copyspouseaddress_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if ($op == 'create' && $objectName == 'Address') {
    $locationTypeId = civicrm_api3('Setting', 'getvalue', [
      'name' => "share_spouse_address_loc_type",
    ]);
    if ($objectRef->location_type_id == $locationTypeId) {
      CRM_CopySpouseAddress_BAO_CopySpouseAddress::processSpouse(
        $objectRef->contact_id
      );
    }
  }

  if ($op == 'edit' && $objectName == 'Relationship' && $objectRef->is_active == 1) {
    $isCopy = CRM_Core_Smarty::singleton()->get_template_vars("rel_copy_address_{$objectId}");
    if ($isCopy) {
      CRM_CopySpouseAddress_BAO_CopySpouseAddress::processSpouse($isCopy);
      CRM_Core_Smarty::singleton()->assign("rel_copy_address_{$objectId}", FALSE);
    }
  }

  if ($op == 'create' && $objectName == 'Relationship') {
    try {
      $relationshipName = civicrm_api3('RelationshipType', 'getvalue', [
        'return' => "id",
        'id' => $objectRef->relationship_type_id,
        'name_a_b' => ['IN' => ["Spouse of", "Partner of"]],
      ]);
      CRM_CopySpouseAddress_BAO_CopySpouseAddress::processSpouse(
        $objectRef->contact_id_a
      );
    }
    catch (Exception $e) {
    }
  }
}
