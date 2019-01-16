<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class StartController extends AppController{

    public function index(){
        $this->viewBuilder()->setLayout('main');
        $this->viewBuilder()->setTemplate('index');
        $this->loadModel('Apartments');

        $this->set('apartments', $this->Apartments->find('all'));
    }
}
