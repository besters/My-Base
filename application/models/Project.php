<?php

class Model_Project
{
   /**
    * Ukazatel na DbTable layer
    * @var Model_DbTable_Account
    */
   private $_dbTable;

   public function __construct()
   {
      $this->_dbTable = new Model_DbTable_Project();
   }

   /**
    * Zjistuje ID projektu
    *
    * @param string $project Nazev projektu
    * @return int Id projektu
    *
    * @todo Zjistovat id projektu podle jeho nazvu
    */
   public function getId($project = null)
   {
      $request = Zend_Controller_Front::getInstance()->getRequest();
      return $request->getParam('projekt');
   }

   /**
    * Vraci z db seznam projektu pro aktivni ucet
    *
    * @return object Vysledek dotazu
    * @todo upload obrazku a pripadny resize
    */
   public function getProjectsList()
   {
      $result = $this->_dbTable->getFullProjectList($this->_dbTable->getAccountId());

      return $result;
   }

   /**
    * Uklada novy/editovany projekt do DB a presmerovava na nastaveni prav
    *
    * @param array $formData Data z formulare
    * @param int $id ID editovaneho zaznamu
    * @return int ID ukladaneho zaznamu
    */
   public function save($formData, $id = null)
   {
      $data = array(
          'name' => $formData['name'],
          'description' => empty($formData['description']) ? null : $formData['description'],
          'iduser' => $formData['iduser'],
          'idcompany' => empty($formData['idcompany']) ? null : $formData['idcompany'],
          'img' => $formData['img'],
          'idaccount' => $this->_dbTable->getAccountId(),
          'status' => 'active'
      );

      $lastInsertId = $this->_dbTable->save($data, $id);

      $this->_dbTable->stream(Model_Stream::TYP_PROJECT, Model_Stream::AKCE_CREATED, $formData['name'], $lastInsertId);

      return $lastInsertId;
   }

   /**
    * Zjisti ID vedouciho projektu
    *
    * @param in $idproject id projektu
    * @return string
    */
   public function getLeader($idproject)
   {
      $leader = $this->_dbTable->getRow($idproject, array('iduser'));
      return $leader['iduser'];
   }

   public function getProjectInfo($idproject)
   {
      //$return = $this->_dbTable->get('idproject = '. $idproject, array('idproject', 'idaccount', 'iduser', 'idcompany', 'name', 'description', 'img', 'status'), null, null, 1);

      $return = $this->_dbTable->getProjectInfo($idproject);

      return $return;
   }

   public function getName($idproject)
   {
      $return = $this->_dbTable->get('idproject = '. $idproject, array('name'), null, null, 1);
      return $return;
   }

   public function getProgressData($idproject) {

        $result = $this->_dbTable->getFullProgressData($idproject);
        $rowCount = count($result);

        $complete = Array(
               'resolved' , 'complete' , 'closed'
        );

        $narray = Array();

        foreach($result as $data){
            if(in_array($data['status'] , $complete)){
                $narray[]=$data['status'];
            }
        }

        $RowComplete = count($narray);


        $percentage = round(100 / $rowCount * $RowComplete);

        $progresslist = array(
            'complete' => $RowComplete,
            'tasks' => $rowCount,
            'percentage' => $percentage
        );

        return $progresslist;
    }


}

