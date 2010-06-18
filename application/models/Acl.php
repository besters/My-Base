<?php

class Model_Acl
{
   /**
    * Ukazatel na DbTable layer
    * @var Model_DbTable_Acl
    */
   private $_dbTable;

   /**
    * Konstruktor
    *
    */
   public function __construct()
   {
      $this->_dbTable = new Model_DbTable_Acl();
   }

   /**
    * Zjistuje opravneni uzivatele pro dany projekt
    *
    * @param string $user Uzivatelske jmeno
    * @param string $project ID projektu
    * @return array Opravneni
    *
    * @todo Upravit fetch dotaz aby vracel jen jeden vysledek (ne fetchAll), jelikoz jeden user muze mit v jednom projektu jen jeden ACL
    */
   public function getUserPerms($user, $project)
   {
      $userModel = new Model_UserMeta();
      $idUser = $userModel->getUserId($user);

      $acl = $this->_dbTable->fetchAllEntry('iduser = ' . $idUser . ' AND idproject = ' . $project . '', array('permission', 'idproject'));

      $return = unserialize($acl[0]->permission);

      return $return;
   }

   /**
    * Vraci opravneni podle zadaneho ID
    *
    * @param int $idacl Primary key v tabulce ACL
    * @return array Opravneni
    */
   public function getPerms($idacl)
   {
      $acl = $this->_dbTable->getRow($idacl, array('permission'));
      $perms = unserialize($acl['permission']);

      return $perms;
   }

   /**
    * Generuje data pro tabulku na editaci ACL
    *
    * @param int $idacl id
    * @return array
    */
   public function generatePermTable($idacl)
   {
      $acl = $this->getPerms($idacl);
      $res = $this->getResources();

      $return = array();
      foreach($res as $key => $name){
         $return[$key] = array('name' => $name, 'acl' => !isset($acl[$key]) ? 0 : $acl[$key]);
      }

      return $return;
   }

   /**
    * Zjistuje vsechna opravneni uzivatele
    *
    * @param string $user Uzivatelske jmeno
    * @return array Opravneni
    */
   public function getAllPerms($user)
   {
      $userModel = new Model_UserMeta();
      $idUser = $userModel->getUserId($user);

      $acl = $this->_dbTable->fetchAllEntry('iduser = ' . $idUser . '', array('permission', 'idproject'));

      $resources = $this->getResources();

      $return = array();
      $data = array();

      foreach($acl as $aclData){
         $unser = unserialize($aclData->permission);
         foreach($resources as $key => $name){
            $return[$key] = !isset($unser[$key]) ? 0 : $unser[$key];
         }
         $data[] = array('permission' => serialize($return), 'idproject' => $aclData->idproject);
      }

      return $data;
   }

   /**
    * Seznam resources pro projektovou podsekci
    *
    * @return array
    */
   public function getResources()
   {
      $resources = array(
          'index' => 'Dashboard',
          'milestone' => 'Milestones',
          'ticket' => 'Tickets',
          'team' => 'Team'
      );

      return $resources;
   }

   /**
    * Ulozi novy ACL zaznam = priradi k projektu noveho uzivatele
    *
    * @param array $formData $_POST data z formulare
    * @param int $iduser ID uzivatele
    * @param int $project ID projektu
    */
   public function addUserToProject($formData, $iduser, $project)
   {
      foreach($formData as $name => $perm){
         $formData[$name] = (int)$perm;
      }

      $formData['index'] = 7;

      $data = array(
          'iduser' => $iduser,
          'idproject' => $project,
          'permission' => serialize($formData)
      );

      $this->_dbTable->save($data);
   }

   /**
    * Uklada vychozi ACL
    *
    * @param int $idproject idproject
    * @param int $iduser iduser
    */
   public function createDefault($idproject, $iduser)
   {
      $author = $this->_createAuthor($idproject);

      if($iduser != $author){
         $leader = $this->_createLeader($idproject, $iduser);
      }
   }

   /**
    * Uklada ACL pro autora projektu
    *
    * @param int $idproject id
    * @return int id autora
    */
   private function _createAuthor($idproject)
   {
      $userModel = new Model_UserMeta();
      $iduser = $userModel->getUserId();

      $data = $this->_generatePerms($idproject, $iduser);

      $this->_dbTable->save($data);

      return $iduser;
   }

   /**
    * Uklada ACL pro majitele uctu
    *
    * @param int $idproject id
    * @return int id majitele
    *
    * @todo zjistit jestli je to vhodne, pripadne zakomponovat
    */
   private function _createOwner($idproject)
   {
      $userModel = new Model_User();
      $iduser = $userModel->getOwnerId($this->getAccountId());

      $data = $this->_generatePerms($idproject, $iduser);

      $this->_dbTable->save($data);

      return $iduser;
   }

   /**
    * Uklada ACL pro vedouciho projektu
    *
    * @param int $idproject id projektu
    * @param int $iduser id uzivatele
    * @return int id vedouciho projektu
    */
   private function _createLeader($idproject, $iduser)
   {
      $data = $this->_generatePerms($idproject, $iduser);

      $this->_dbTable->save($data);

      return $iduser;
   }

   /**
    * Generuje ACL data
    *
    * @param int $idproject id projektu
    * @param int $iduser id uzivatele
    * @return array
    */
   private function _generatePerms($idproject, $iduser)
   {
      $resources = $this->getResources();

      foreach($resources as $resource => $name){
         $perm[$resource] = 7;
      }

      $data = array(
          'iduser' => $iduser,
          'idproject' => $idproject,
          'permission' => serialize($perm)
      );

      return $data;
   }

   /**
    * Vraci asociativni pole se spolecnostmi a jejich uzivateli
    *
    * @param int $idproject ID projektu
    * @return array
    */
   public function getUsers($idproject)
   {
      $users = $this->_dbTable->getFullUserList($idproject);

      $return = array();

      foreach($users as $user){
         $return[$user->company][] = array(
             'iduser' => $user->iduser,
             'idacl' => $user->idacl,
             'user' => $user->user,
             'email' => $user->email,
             'administrator' => $user->administrator
         );
      }

      return $return;
   }

   /**
    * Smaze ACL zaznam
    *
    * @param int $idacl
    */
   public function removeFromProject($idacl)
   {
      $this->_dbTable->deleteEntry($idacl);
   }

   /**
    * Aktualizuje ACL v db
    *
    * @param  int $idacl id acl zaznamu
    * @param  array $perms ACL data
    * @return bool
    */
   public function updatePerms($idacl, $perms)
   {
      $perms = serialize($perms);
      $data = array('permission' => $perms);

      if($this->_dbTable->update($data, $idacl)){
         return true;
      }else{
         return false;
      }
   }

}

