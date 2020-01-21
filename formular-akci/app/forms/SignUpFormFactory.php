<?php

namespace App\Forms;

use App\Model;
use Nette;
use Nette\Application\UI\Form;


class SignUpFormFactory
{
	use Nette\SmartObject;

	const PASSWORD_MIN_LENGTH = 7;

	/** @var FormFactory */
	private $factory;

	/** @var Model\UserManager */
	private $userManager;


	public function __construct(FormFactory $factory, Model\UserManager $userManager)
	{
		$this->factory = $factory;
		$this->userManager = $userManager;
	}


	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$role = [
                '1' => 'učitel',
                '2' => 'admin',
            ];

		$form = $this->factory->create();

		//bootstrap 3
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = NULL;
        $renderer->wrappers['pair']['container'] = 'div class=form-group';
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class=col-sm-9';
        $renderer->wrappers['label']['container'] = 'div class="col-sm-3 control-label"';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block'; 

        $form->getElementPrototype()->class('form-horizontal');

        foreach ($form->getControls() as $control) {
            if ($control instanceof Controls\Button) {
                $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
                $usedPrimary = TRUE;

            } elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
                $control->getControlPrototype()->addClass('form-control');

            } elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
                $control->getSeparatorPrototype()->setName('div')->addClass($control->getControlPrototype()->type);
            }
        } 
        //formular
		$form->addText('username', 'Jméno:')
			->setRequired('Vložte prosím vaše přihlašovací jméno.');

		$form->addEmail('email', 'e-mail:')
			->setRequired('Vložte prosím váš e-mail.');

		$form->addPassword('password', 'Heslo:')
			->setOption('description', sprintf('alespoň %d písmen nebo číslic.', self::PASSWORD_MIN_LENGTH))
			->setRequired('Vložte prosím vaše heslo.')
			->addRule($form::MIN_LENGTH, null, self::PASSWORD_MIN_LENGTH);

		$form->addRadioList('role','role:',$role)
                        ->setRequired('vyberte roli uživatele');	

		$form->addSubmit('send', 'Registrovat');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				$this->userManager->add($values->username, $values->email, $values->password);
			} catch (Model\DuplicateNameException $e) {
				$form['username']->addError('Přihlašovací jméno již existuje.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}
