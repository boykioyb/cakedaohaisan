<?php

/**
 * A simple CakePHP component that returns a list of controllers.
 *
 * Copyright (c) by Daniel Hofstetter (daniel.hofstetter@42dh.com, http://cakebaker.42dh.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ControllerListComponent extends Component {

    public $shared_actions = array(
        'reqDelete',
        'reqEdit',
    );

    public function getList(Array $controllersToExclude = array()) {
        $controllersToExclude[] = 'AppController';
        $controllerClasses = array_filter(App::objects('Controller'), function ($controller) use ($controllersToExclude) {
            return !in_array($controller, $controllersToExclude);
        });
        $result = array();

        foreach ($controllerClasses as $controller) {
            $controllerName = str_replace('Controller', '', $controller);
            $result[$controller]['name'] = $controllerName;
            $result[$controller]['displayName'] = Inflector::humanize(Inflector::underscore($controllerName));
            $result[$controller]['actions'] = $this->getActions($controller);
        }

        return $result;
    }

    private function getActions($controller) {
        App::uses($controller, 'Controller');
        $methods = get_class_methods($controller);
        $methods = $this->removeParentMethods($methods);
        $methods = $this->removePrivateActions($methods);

        $methods = array_merge($methods, $this->shared_actions);
        return $methods;
    }

    private function removeParentMethods(Array $methods) {
        $appControllerMethods = get_class_methods('AppController');

        return array_diff($methods, $appControllerMethods);
    }

    private function removePrivateActions(Array $methods) {
        return array_filter($methods, function ($method) {
            return $method{0} != '_';
        });
    }

    public function getPermissions() {

        $raw_permissions = $this->getList();
        if (empty($raw_permissions)) {

            return;
        }

        $permissions = array();
        foreach ($raw_permissions as $perm) {

            if (empty($perm['actions'])) {

                continue;
            }

            foreach ($perm['actions'] as $action) {

                $key = $perm['name'] . '/' . $action;
                $permissions[$perm['name']][$key] = $key;
            }
        }

        return $permissions;
    }
}
