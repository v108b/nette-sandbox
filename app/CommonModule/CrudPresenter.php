<?php

namespace App\CommonModule;

class CrudPresenter extends \App\CommonModule\BasePresenter {

	public function actionListTable($tableName)
	{
		$this['crudList'] = $this->getCrudExtenstion()->getComponents()->buildTableGrid($tableName);
	}
	/**
	 * @return \V108B\NetteCrud\Extension
	 */
	public function getCrudExtenstion()
	{
		return $this->context->getService('crud');
	}
}