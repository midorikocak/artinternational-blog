<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;

/**
* Articles Controller
*
* @property \App\Model\Table\ArticlesTable $Articles
*/
class ArticlesController extends AppController
{

  /**
  * Index method
  *
  * @return void
  */
  public function index()
  {
    $this->paginate = [
      'contain' => ['Users']
    ];
    $this->set('articles', $this->paginate($this->Articles));
    $this->set('_serialize', ['articles']);
  }

  /**
  * View method
  *
  * @param string|null $id Article id.
  * @return void
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function view($id = null)
  {
    $article = $this->Articles->get($id, [
      'contain' => ['Users']
      ]);
      $this->set('article', $article);
      $this->set('_serialize', ['article']);
    }

    public function isAuthorized($user)
    {
      // All registered users can add articles
      if ($this->request->action === 'add') {
        return true;
      }

      // The owner of an article can edit and delete it
      if (in_array($this->request->action, ['edit', 'delete'])) {
        $articleId = (int)$this->request->params['pass'][0];
        if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
          return true;
        }
      }

      return parent::isAuthorized($user);
    }

    /**
    * Add method
    *
    * @return void Redirects on successful add, renders view otherwise.
    */
    public function add()
    {
      $article = $this->Articles->newEntity();
      if ($this->request->is('post')) {
        $article = $this->Articles->patchEntity($article, $this->request->data);
        $article->user_id = $this->Auth->user('id');
        if ($this->Articles->save($article)) {
          $this->Flash->success(__('The article has been saved.'));
          return $this->redirect(['action' => 'index']);
        } else {
          $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }
      }
      $this->set(compact('article', 'users'));
      $this->set('_serialize', ['article']);
    }

    /**
    * Edit method
    *
    * @param string|null $id Article id.
    * @return void Redirects on successful edit, renders view otherwise.
    * @throws \Cake\Network\Exception\NotFoundException When record not found.
    */
    public function edit($id = null)
    {
      $session = $this->request->session();
      $article = $this->Articles->get($id, [
        'contain' => ['Media']
        ]);


        if ($this->request->is(['patch', 'post', 'put'])) {
          $article = $this->Articles->patchEntity($article, $this->request->data);
          //var_dump($this->request->data['body']);

          //$media = TableRegistry::get('Media');

          $article->user_id = $this->Auth->user('id');
          if ($this->Articles->save($article, ['associated' => ['Media']])) {
            $this->Flash->success(__('The article has been saved.'));
            return $this->redirect(['action' => 'index']);
          } else {
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
          }
        }
        $users = $this->Articles->Users->find('list', ['limit' => 200]);
        $this->set(compact('article', 'users'));
        $this->set('_serialize', ['article']);
      }

      /**
      * Delete method
      *
      * @param string|null $id Article id.
      * @return void Redirects to index.
      * @throws \Cake\Network\Exception\NotFoundException When record not found.
      */
      public function delete($id = null)
      {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
          $this->Flash->success(__('The article has been deleted.'));
        } else {
          $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
      }
    }
