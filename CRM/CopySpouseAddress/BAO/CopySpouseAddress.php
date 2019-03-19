<?php

class CRM_CopySpouseAddress_BAO_CopySpouseAddress {

  /**
   * Get all active location types.
   *
   */
  public static function getLocationTypes() {
    return CRM_Core_PseudoConstant::get('CRM_Core_DAO_Address', 'location_type_id');
  }

  /**
   * Copy address of spouse if not present.
   *
   */
  public static function shareAddress($contactIdA, $contactIdB) {
    $locationTypeId = civicrm_api3('Setting', 'getvalue', [
      'name' => "share_spouse_address_loc_type",
    ]);
    foreach ([
      'A',
      'B'
    ] as $name) {
      $contactId = "contactId{$name}";
      $addressVariableName = "contactAddress_{$name}";
      $$addressVariableName = [];
      try {
        $$addressVariableName = civicrm_api3('Address', 'getsingle', [
          'contact_id' => $$contactId,
          'location_type_id' => $locationTypeId,
          'options' => ['limit' => 1],
        ]);
      }
      catch (Exception $e) {
      }
    }
    if (!empty($contactAddress_A) && !empty($contactAddress_B)) {
      return;
    }
    if (empty($contactAddress_A) && empty($contactAddress_B)) {
      return;
    }
    if (empty($contactAddress_A)) {
      $masterContactAddress = $contactAddress_B;
      $childContactId = $contactIdA;
    }
    else {
      $masterContactAddress = $contactAddress_A;
      $childContactId = $contactIdB;
    }
    $masterContactAddress['contact_id'] = $childContactId;
    $masterContactAddress['master_id'] = $masterContactAddress['id'];
    unset($masterContactAddress['id']);
    civicrm_api3('Address', 'create', $masterContactAddress);
  }

  /**
   * Delete shared address of spouse if present.
   *
   */
  public static function deleteSharedAddress($contactIdA, $contactIdB) {
    $locationTypeId = civicrm_api3('Setting', 'getvalue', [
      'name' => "share_spouse_address_loc_type",
    ]);
    $query = "
      DELETE ca.*
      FROM `civicrm_address` ca
      INNER JOIN civicrm_address ca2 ON ca2.id = ca.master_id
        AND ca.location_type_id = {$locationTypeId}
        AND ca.contact_id IN($contactIdA, $contactIdB)
        AND ca2.contact_id IN($contactIdA, $contactIdB)";
    CRM_Core_DAO::executeQuery($query);
  }

  /**
   * Process shared address copy.
   *
   */
  public static function processSpouse($contactId, $cronJob = FALSE, $isDelete = FALSE) {
    if (!$cronJob && !$isDelete) {
      $runViaOnlyCron = civicrm_api3('Setting', 'getvalue', [
        'name' => "share_spouse_address_cron_run",
      ]);
      if ($runViaOnlyCron) {
        return;
      }
    }

    $result = civicrm_api3('RelationshipType', 'get', [
      'return' => ["id"],
      'name_a_b' => ['IN' => ["Spouse of", "Partner of"]],
    ])['values'];
    $rType = implode(',', array_keys($result));

    $query = "
      SELECT contact_id_a, contact_id_b
      FROM civicrm_relationship cr
        INNER JOIN civicrm_contact ccA ON ccA.id = contact_id_a
          AND cr.relationship_type_id IN ($rType) AND ccA.is_deleted = 0
          AND cr.is_active = 1
        INNER JOIN civicrm_contact ccB ON ccB.id = contact_id_b
          AND ccA.is_deleted = 0
      WHERE (ccA.id = {$contactId} OR ccB.id = {$contactId})";
    $result = CRM_Core_DAO::executeQuery($query);
    while ($result->fetch()) {
      if ($isDelete) {
        self::deleteSharedAddress($result->contact_id_a, $result->contact_id_b);
      }
      else {
        self::shareAddress($result->contact_id_a, $result->contact_id_b);
      }
    }
  }

}
