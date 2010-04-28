<?php
class Mybase_ProjectController extends Unodor_Controller_Action
{
	
	public function init()
	{
		$this->_model = new Model_Project();
		parent::init();
	}
	
	public function indexAction()
	{			
		$result = $this->_model->getProjectsList();	
		$this->view->project = $result;
	}

	public function newAction()
	{
		$this->_form = new Mybase_Form_Project();
		
		$this->view->form = $this->_form;

		$formData = $this->getRequest()->getPost();
				
		if($this->_request->isPost()){
			if($this->_form->isValid($formData)){
				$lastInsertId = $this->_model->save($formData);
				$acl = new Model_Acl;

				if(isset($formData['img'])){
					$account = new Model_Account();

					if(!is_dir(ROOT_PATH.'/public/files/'.$account->getId()))
						mkdir(ROOT_PATH.'/public/files/'.$account->getId());
					
					mkdir(ROOT_PATH.'/public/files/'.$account->getId().'/'.$lastInsertId.'/');
											
					rename(ROOT_PATH.'/public/files/tmp/'.$formData['img'], ROOT_PATH.'/public/files/'.$account->getId().'/'.$lastInsertId.'/'.$formData['img']);
				}
				
				$acl->createDefault($lastInsertId);
				$this->_flash('New project has been successfully created', 'done');
				return $this->_redirect('/'.$lastInsertId.'/people/overview');
			}else{
				$this->_flash('Formulář není vyplněn správně', 'error', false);
				$this->_form->populate($formData);
			}
		}		
	}
	
	public function uploadAction(){
		$this->disableMvc(true, true);
		$account = new Model_Account();

		$adapter = new Zend_File_Transfer_Adapter_Http();
		
		if(!is_dir(ROOT_PATH.'/public/files/tmp/'))
			mkdir(ROOT_PATH.'/public/files/tmp/');
						
		$adapter->setDestination(ROOT_PATH.'/public/files/tmp/');
		
		$info = $adapter->getFileInfo();
		
		$ex = explode('.', $info['Filedata']['name']);
		
		$fileType = $ex[count($ex)-1];
		$hash = $adapter->getHash('md5');
		$tmpFile = $info['Filedata']['destination'].'/'.$hash.'.'.$fileType;
		
		$adapter->addFilter('Rename', array('target' => $tmpFile, 'overwrite' => true));
		
		if($adapter->receive()){
			$img = new Unodor_Image_Resize($tmpFile);
			$img->adaptiveResize(50, 50)->save($tmpFile, false);
			
			echo $hash.'.'.$fileType;
		}
	}
	
	public function checkAction()
	{
		$this->disableMvc(true, true);
		echo true;
		return true;
	}

}