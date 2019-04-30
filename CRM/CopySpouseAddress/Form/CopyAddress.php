<?php
/**
 * @file
 * This provides the Sync Pull into CiviCRM from Constant Contact form.
 */

class CRM_CopySpouseAddress_Form_CopyAddress extends CRM_Core_Form {

  const QUEUE_NAME = 'cc-pull';
  const END_URL    = 'civicrm/bulk/copy/spouseaddress';
  const END_PARAMS = 'state=done';
  /**
   * Function to pre processing
   *
   * @return None
   * @access public
   */
  function preProcess() {
    parent::preProcess();
  }

  /**
   * Function to actually build the form
   *
   * @return None
   * @access public
   */
  public function buildQuickForm() {
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Copy Spouse Address'),
        'isDefault' => TRUE,
      ),
      array(
        'type' => 'cancel',
        'name' => ts('Cancel'),
      ),
    ));
  }

  /**
   * Function to process the form
   *
   * @access public
   *
   * @return None
   */
  public function postProcess() {
    $submitValues = $this->_submitValues;
    $runner = self::getRunner($submitValues);
    if ($runner) {
      // Run Everything in the Queue via the Web.
      $runner->runAllViaWeb();
    } else {
      CRM_Core_Session::setStatus(ts('Nothing to copy.'));
    }
  }

  /**
   * Set up the queue.
   */
  public static function getRunner($submitValues) {
    // Setup the Queue
    $queue = CRM_Queue_Service::singleton()->create(array(
      'name'  => self::QUEUE_NAME,
      'type'  => 'Sql',
      'reset' => TRUE,
    ));
    $result = civicrm_api3('RelationshipType', 'get', [
      'return' => ["id"],
      'name_a_b' => ['IN' => ["Spouse of", "Partner of"]],
    ])['values'];
    $rType = implode(',', array_keys($result));

    $query = "
      SELECT count(cr.id)
      FROM civicrm_relationship cr
        INNER JOIN civicrm_contact ccA ON ccA.id = contact_id_a
          AND cr.relationship_type_id IN ($rType) AND ccA.is_deleted = 0
          AND cr.is_active = 1
        INNER JOIN civicrm_contact ccB ON ccB.id = contact_id_b
          AND ccA.is_deleted = 0";
    $contactCount = CRM_Core_DAO::singleValueQuery($query);
    $batchSize = 50;
    for ($startId = 0; $startId <= $contactCount; $startId += $batchSize) {
      $endId = $startId + $batchSize;
      $queue->createItem( new CRM_Queue_Task(
        ['CRM_CopySpouseAddress_Form_CopyAddress', 'copyAddress'],
        [$startId, $batchSize],
        "Copy address($startId => $endId): Copy spouse address... "
      ));
    }

    // Setup the Runner
    $runnerParams = [
      'title' => ts('Copy Spouse address'),
      'queue' => $queue,
      'errorMode'=> CRM_Queue_Runner::ERROR_ABORT,
      'onEndUrl' => CRM_Utils_System::url(self::END_URL, self::END_PARAMS, TRUE, NULL, FALSE),
    ];

    $runner = new CRM_Queue_Runner($runnerParams);
    return $runner;
  }

  public static function copyAddress(CRM_Queue_TaskContext $ctx, $startId, $endId) {
    $result = civicrm_api3('RelationshipType', 'get', [
      'return' => ["id"],
      'name_a_b' => ['IN' => ["Spouse of", "Partner of"]],
    ])['values'];
    $rType = implode(',', array_keys($result));
    $sql = "
      SELECT contact_id_a, contact_id_b
      FROM civicrm_relationship cr
        INNER JOIN civicrm_contact ccA ON ccA.id = contact_id_a
          AND cr.relationship_type_id IN ($rType) AND ccA.is_deleted = 0
          AND cr.is_active = 1
        INNER JOIN civicrm_contact ccB ON ccB.id = contact_id_b
          AND ccA.is_deleted = 0
      LIMIT $startId, $endId
    ";
    $result = CRM_Core_DAO::executeQuery($sql);
    while ($result->fetch()) {
      CRM_CopySpouseAddress_BAO_CopySpouseAddress::shareAddress(
        $result->contact_id_a,
        $result->contact_id_b
      );
    }
    return CRM_Queue_Task::TASK_SUCCESS;
  }
}
