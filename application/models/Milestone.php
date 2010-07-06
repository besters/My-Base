<?php

class Model_Milestone
{
   /**
    * Ukazatel na DbTable layer
    * @var Model_DbTable_Account
    */
   private $_dbTable;
   private $_milestones;

   public function __construct()
   {
      $this->_dbTable = new Model_DbTable_Milestone();
   }

   /**
    * Vraci z db seznam milniku ktere muzou byt pouzity jako rodicovske
    *
    * @return object Vysledek dotazu
    */
   public function getParentMilestonesList($projectId, $nullVal = null)
   {
      $milestone = $this->_dbTable->fetchAllEntry('idproject = ' . $projectId . ' AND parent IS NULL', array('idmilestone', 'name'));

      $return = array();

      if(!is_null($nullVal))
         $return[null] = $nullVal;

      foreach($milestone as $row){
         $return[$row->idmilestone] = $row->name;
      }

      return $return;
   }

   private function whereCondition($cond)
   {
      if(is_null($cond)){
         return 'iduser';
      }elseif(is_array($cond)){
         $return = 'iduser = ' . $cond[0];
         array_shift($cond);
         foreach($cond as $val){
            $return .= ' OR iduser = ' . $val;
         }
         return $return;
      }else{
         return 'iduser = ' . $cond;
      }
   }

   public function getLate($idproject)
   {
      $late = $this->_dbTable->get(array('idproject = ' . $idproject, 'datetime < ' . new Zend_Db_Expr('CURDATE()')), array('*'), null, null, null, true);
      return $late;
   }

   public function getUpcoming($idproject)
   {
      $upcoming = $this->_dbTable->get(array('idproject = ' . $idproject, 'datetime >= ' . new Zend_Db_Expr('CURDATE()'), 'datetime <= ' . new Zend_Db_Expr('CURDATE()+14')), array('*'), null, null, null, true);
      return $upcoming;
   }

   public function getMilestones($status, $iduser = null)
   {       
      $projectModel = new Model_Project();
      $idproject = $projectModel->getId();

      $milestones = $this->_dbTable->get(array('idproject = ' . $idproject, 'status = "' . $status . '"'), array('idmilestone', 'name', 'datetime', 'status'), 'datetime ASC', null, null, true);

      $milestoneUserModel = new Model_MilestoneUser();

      if(!empty($milestones)){
         $ids = array();
         foreach($milestones as $id){
            $ids[] = $id['idmilestone'];
         }
         $mu = $milestoneUserModel->getUsersIds($ids);

         $userMetaModel = new Model_UserMeta();

         $ids = array();
         foreach($mu as $id){
            $ids[] = $id['iduser'];
         }
         $users = $userMetaModel->getUsers($ids);

         foreach($milestones as $key => $val){
            $return[$key] = (object)$val;
            foreach($mu as $mukey => $muval){
               if($muval['idmilestone'] == $val['idmilestone']){
                  foreach($users as $user){
                     if($user['iduser'] == $muval['iduser']){
                        $return[$key]->users[$mukey] = (object)$user;
                     }
                  }
               }
            }
         }
         return $return;
      }
   }

   public function getActive()
   {
      return $this->getMilestones('active');
   }

   public function getComplete()
   {
      return $this->getMilestones('complete');
   }

   public function getPaused()
   {
      return $this->getMilestones('paused');
   }

   public function getCanceled()
   {
      return $this->getMilestones('canceled');
   }

   public function getDetail($id)
   {
      $detail = $this->_dbTable->get($id, array('*'));
      return $detail[0];
   }

   /**
    * Uklada novy/editovany milnik do DB
    *
    * @param array $formData Data z formulare
    * @param int $id ID editovaneho zaznamu
    * @return int ID ukladaneho zaznamu
    */
   public function save($formData, $id = null)
   {
      $user = new Model_User();
      $project = new Model_Project();

      $data = array(
          'idproject' => $project->getId(),
          'iduser' => $user->getUserId(),
          'idpriority' => empty($formData['idpriority']) ? null : $formData['idpriority'],
          'name' => $formData['name'],
          'datetime' => $formData['datetime'],
          'description' => empty($formData['description']) ? null : $formData['description'],
          'status' => $formData['status'],
          'parent' => empty($formData['parent']) ? null : $formData['parent']
      );

      $lastInsertId = $this->_dbTable->save($data, $id);

      $this->_dbTable->stream(Model_Stream::TYP_MILESTONE, Model_Stream::AKCE_CREATED, $formData['name'], $lastInsertId);

      return $lastInsertId;
   }

}
