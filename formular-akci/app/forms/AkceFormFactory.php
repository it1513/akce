<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Controls;
use App\Forms\DateInput;
use Tracy\Debugger;


class AkceFormFactory
{
	use Nette\SmartObject;

    private $flashes;

	/** @var FormFactory */
	private $factory;

    private $akce;

    /** @var AkceManager */
    private $akceManager;

    /** @var UserManager */
    private $userManager;


	public function __construct(FormFactory $factory, \App\Model\AkceManager $akceManager, \App\Model\UserManager $userManager, FlashMessages $flashes)
	{        
		$this->factory = $factory;
        $this->akceManager = $akceManager;
        $this->userManager = $userManager;
		$this->flashes = $flashes;
	}

     
	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{




            $rows = $this->userManager->getAllTeachers();
            Debugger::barDump($rows);
            foreach($rows as $row) {
                $ucitele[$row['id']] = $row['username'];
            }

            $typ = [
                '1' => 'exkurze',
                '2' => 'výlet',
            ];
            
            $dvpp = [
                'ano' => 'ANO',
                'ne' => 'NE',
            ];
            
            $msmt = [
                'ano' => 'ANO',
                'ne' => 'NE',
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
                $form->addHidden('id');
                
                $form->addSelect('ucitel','učitel',$ucitele)
                        ->setRequired('vyberte vedoucího akce');
                
		$form->addText('nazev', 'Název:')
			->setRequired('vložte název akce');

                $form->addText('datum','datum:')
                        ->setType('date')
			->setRequired('vložte datum akce');
                

                $form->addRadioList('typ','typ:',$typ)
                        ->setRequired('vyberte typ akce');
                
                $form->addTextArea('popis','popis akce:')
			            ->setRequired(false)
                        ->setAttribute('class', 'mceEditor')
                        ->addRule(Form::MAX_LENGTH,'popis je příliš dlouhý',10000);
                
                $form->addInteger('zaci', 'počet žáků:')
                         ->setRequired('vložte počet žáků přítomných na akci')
                          ->addRule(Form::RANGE, 'počet záků musí být od 1 do 300', [1, 300]);
                
                $form->addRadioList('dvpp','DVPP:',$dvpp)
                        ->setRequired('vyberte ano ne');
                
                $form->addRadioList('msmt','MŠMT:',$msmt)
                        ->setRequired('vyberte ano ne');
                
                $form->addText('poradatel', 'Pořadatel:')
			->setRequired('vložte název pořadatele');
                
                $form->addInteger('vyukove_hodiny', 'počet výukových hodin:')
                         ->setRequired('vložte počet hodin')
                          ->addRule(Form::RANGE, 'počet hodin musí být od 1 do 300', [1, 300]);
                //add upload pro nahrání souboru
                $form->addUpload('file', 'Soubory');
                
                    
                
                $form->addSubmit('Upload', 'odeslat');
           
                
		
              
                $form->onSuccess[] = function (Form $form,$values) use ($onSuccess){
                    //ukladani uploadu do slozky
                    $values = $form->getValues();
                    $path = "/uploads" . $values->file->getName();
                    $values->file->move($path);
                    Debugger::barDump($values->file->getName()); 
                    //uprava
                    try {                        
                        if ($values['id']){
                            $akce = $this->akceManager->update($values['id'], $values);
                            $this->flashes->flashMessage("Akce byla úspěšně změněna.", 'success');
                        } else {
                            $this->akceManager->insert($values);
                            $this->flashes->flashMessage("Nová akce byla úspěšně vložena.", 'success');
                        }
                    } catch (Exception $e) {
                        $form->addError('Nepodařilo se vytvořit článek');
                    return;
                    }
                    $onSuccess();    
            


      
                };
                       

		return $form;
	}
}
