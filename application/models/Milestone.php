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

   public function getMilestones($iduser = null)
   {
      $condition = $this->whereCondition($iduser);
      $projectModel = new Model_Project();
      $idproject = $projectModel->getId();
      $this->_milestones = $this->_dbTable->getMilestones($condition, $idproject);
      return $this;
   }

   public function getActive()
   {
      return $this->statusCond('active');
   }

   public function getComplete()
   {
      return $this->statusCond('complete');
   }

   public function getPaused()
   {
      return $this->statusCond('paused');
   }

   public function getCanceled()
   {
      return $this->statusCond('canceled');
   }

   private function statusCond($cond)
   {
      $return = array();

      foreach($this->_milestones as $key => $val){
         if($val->status == $cond){
            $val->user = explode(',', $val->user);
            $val->iduser = explode(',', $val->iduser);
            $return[$key] = $val;
         }
      }
      return $return;
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
      return $lastInsertId;
   }

}
