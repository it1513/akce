<?php

namespace App\Presenters;

use App\Forms;
use Nette\Application\UI\Form;


class AkcePresenter extends BasePresenter
{
	/** @var Forms\SignInFormFactory */
	private $AkceFormFactory;




	public function __construct(Forms\AkceFormFactory $AkceFormFactory)
	{
		$this->AkceFormFactory = $AkceFormFactory;
	}


	/**
	 * Akce form factory.
	 * @return Form
	 */
	protected function createComponentSignInForm()
	{
		return $this->AkceFormFactory->create(function () {
			$this->redirect('Homepage:');
		});
	}


/*
	public function actionOut()
	{
		$this->getUser()->logout();
	}
*/

}
