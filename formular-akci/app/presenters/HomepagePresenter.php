<?php

namespace App\Presenters;

use App\Forms;
use App\Model;
use Nette\Utils\DateTime;
use Nette\Application\UI\Form;
use Tracy\Debugger;


class HomepagePresenter extends BasePresenter {    

	/** @var Forms\AkceFactory */
	private $akceFactory;

    /** @var Model\AkceManager */
    private $akceManager;

    /** @var Model\UserManager */
    private $userManager;    

    function __construct(Forms\AkceFormFactory $akceFactory, Model\AkceManager $akceManager, Model\UserManager $userManager) {
        $this->akceFactory = $akceFactory;
        $this->akceManager = $akceManager;
        $this->userManager = $userManager;
    }

    public function renderDefault($order = 'id') {
        $this->template->data = $this->akceManager->getAll($order);
        Debugger::barDump($this->template->data);    

        
        
    }

    public function renderList($order = 'id') {
        $this->template->data = $this->akceManager->getAll($order);
           Debugger::barDump($this->template->data);
       
    }
    
    public function renderType($type) {
        $this->template->data = $this->akceManager->getByType($type);
    }

    public function renderView($id) {
        $this->template->data = $this->akceManager->getOne($id);
    }

    public function renderCreate() {        
    }

    public function renderUpdate($id, $dateFormat = 'Y-m-d') {
        
        $zaznam = $this->akceManager->getOne($id);
        
        $zaznam = $zaznam->toArray();
        $zaznam['datum'] = date_format( $zaznam['datum'], $dateFormat);
        if (!$zaznam) { 
            throw new BadRequestException;
        }
        $this['akceForm']->setDefaults($zaznam);
    }

    public function actionDelete($id) {
        if ($row = $this->akceManager->getOne($id)) {
            $row->delete();
            $this->flashMessage("Úspěšně smazáno");
        } else {
            $this->flashMessage("Úspěšně nesmazáno!");
        }
        $this->redirect("Homepage:list");
    }
    
    public function createComponentAkceForm()
	{
		return $this->akceFactory->create(function () {
            $this->redirect("Homepage:list");
		});
	}
        
        
}
