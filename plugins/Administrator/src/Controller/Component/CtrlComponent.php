<?php namespace Administrator\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;


class CtrlComponent extends Component {

    /**
     * Return an array of user Controllers and their methods.
     * The function will exclude ApplicationController methods
     * @return array
     */
    public function get() {

        $aCtrlClasses = App::objects('controller');

        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));

                // Load its methods / actions
                $aMethods = get_class_methods($controller);

                foreach ($aMethods as $method => $idx) {

                    if ($method{0} == '_') {
                        unset($aMethods[$idx]);
                    }
                }

                // Load the ApplicationController (if there is one)
                App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');

                $controllers[$controller] = array_diff($aMethods, $parentActions);
            }
        }

        return $controllers;
    }

}


 //echo pr($this->Ctrl->get()); //esta es la funcion que va en el controlador para listar los controladores con sus vistas corespondientes.
//var_dump($aControllers);