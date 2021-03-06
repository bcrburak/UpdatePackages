<?php

class Users_CheckUserEmail_Action extends Vtiger_Action_Controller {

	function checkPermission(Vtiger_Request $request) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if(!$currentUser->isAdminUser()) {
			throw new NoPermittedException('LBL_PERMISSION_DENIED');
		}
	}

    public function process(Vtiger_Request $request) {
        
        $moduleModel = Vtiger_Module_Model::getInstance('Users');
        $output = !$moduleModel->checkMailExist($request->get('email'), $request->get('cUser'));
        
        $response = new Vtiger_Response();
        $response->setResult($output);
        $response->emit();
    }

}
