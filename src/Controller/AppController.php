<?php
/**
* CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
* Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
*
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
* @link      http://cakephp.org CakePHP(tm) Project
* @since     0.2.9
* @license   http://www.opensource.org/licenses/mit-license.php MIT License
*/
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 *      
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'storage' => 'Session',
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email'
                    ]
                ]
            ],
            'loginRedirect' => [
                'controller' => 'Articles',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'display',
                'home'
            ]
        ]);
        
        // if ($this->Auth->user('id')) {
        $this->viewBuilder()->layout('public');
        $this->checkIfThereIsAdminIfNotCreate();
        $this->checkIfThereSettingIfNotCreate();
        // } else {
        // $this->viewBuilder()->layout('logout');
        // }
    }

    public function checkIfThereSettingIfNotCreate()
    {
        $siteSettings = Cache::read('site');
        if (empty($siteSettings['title'])) {
            $settingsTable = TableRegistry::get('Settings');
            $settingsList = $settingsTable->getSettingsForCache();

            if (! empty($settingsList['site']['title'])) {
                foreach ($settingsList as $key => $value) {
                    Cache::write($key, $value);
                }
            } elseif (($this->request->params['controller'] != 'settings' && $this->request->params['action'] != 'editAll') && $this->request->params['action'] != 'login') {
                $this->redirect([
                    'controller' => 'settings',
                    'action' => 'editAll'
                ]);
            }
        } else {
            return true;
        }
    }

    public function checkIfThereIsAdminIfNotCreate()
    {
        $users = TableRegistry::get('Users');
        $admin = $users->find('list')
            ->where([
            'role' => 'admin'
        ])
            ->toArray();
        if (empty($admin)) {
            if ($this->request->params['controller'] == 'Users') {
                $this->Auth->allow([
                    'add'
                ]);
            }
            if ($this->request->params['controller'] != 'users' && $this->request->params['action'] != 'add') {
                $this->layout = 'logout';
                $this->redirect([
                    'controller' => 'users',
                    'action' => 'add'
                ]);
            }
        } else {
            return true;
        }
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow([
            'index',
            'view',
            'display'
        ]);
        $this->set('session', $this->request->session());
        $this->set('serverUrl', Router::url('/', true));
        $this->set('site',Cache::read('site'));
        $this->set('social',Cache::read('social'));
    }

    public function isAuthorized($user)
    {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        
        // Default deny
        return false;
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event
     *            The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (! array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), [
            'application/json',
            'application/xml'
        ])) {
            $this->set('_serialize', true);
        }
    }
}
