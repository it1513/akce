<?php

declare(strict_types=1);

namespace App\Forms;
use Nette;

interface IFlashMessages {
    public function flashMessage($message, $type = 'info');
}

class FlashMessages implements IFlashMessages {

    private $application;

    public function __construct(Nette\Application\Application $application) {
        $this->application = $application;
    }

    public function flashMessage($message, $type = 'info') {
        if (!$this->application->getPresenter()) {
            throw new Exception('Presenter is not created yet.');
        }

        return $this->application->getPresenter()->flashMessage($message, $type);
    }

}