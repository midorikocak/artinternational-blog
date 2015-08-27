<?php
namespace App\Controller;

use App\Controller\AppController;
use PhpParser\Builder\Class_;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
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
            'contain' => [
                'Users',
                'FeaturedMedia',
                'Categories'
            ]
        ];
        $this->set('articles', $this->paginate($this->Articles->getArticlesOnMain()));
        $this->set('_serialize', [
            'articles'
        ]);
    }
    
    public function archives(){
        $query = $this->Articles->find();
        $query->select(['year' => $query->func()->year(['Articles.created'=>'literal'])])
            ->select(['month' => $query->func()->monthname(['Articles.created'=>'literal'])])
            ->select(['id','title','slug','category_id'])
            ->order('Articles.created')
            ->autoFields(true);
        $query->contain(['Categories']);
        $archives = $query->toArray();
        $this->set(compact('archives'));
    }

    /**
     * View method
     *
     * @param string|null $id
     *            Article id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($id == null){
            if(isset($this->request->params['article'])){
                $articleSlug = $this->request->params['article'];
            }
            
            if(isset($this->request->params['category'])){
                $categorySlug = $this->request->params['category'];
                $category = $this->Articles->Categories->find('slugId',['slug'=>$categorySlug])->toArray();
                $categoryId = $category[$categorySlug];
                $article = $this->Articles->find('slug',['category_id'=>$categoryId,'slug'=>$articleSlug,'contain'=>['Users','Categories']])->first();
            }else{
                $article = $this->Articles->find('slug',['slug'=>$articleSlug,'contain'=>['Users','Categories']])->first();
                if(!isset($article->category)){
                    $article->category = new Class_('Category');
                    $article->category->slug = "articles";
                }
            }
        }else{
            $article = $this->Articles->get($id, [
            'contain' => [
                'Users','Categories'
            ]
        ]);
        }
        
        $this->set('article', $article);
        $this->set('_serialize', [
            'article'
        ]);
    }

    public function isAuthorized($user)
    {
        // All registered users can add articles
        if ($this->request->action === 'add') {
            return true;
        }
        
        // The owner of an article can edit and delete it
        if (in_array($this->request->action, [
            'edit',
            'delete'
        ])) {
            $articleId = (int) $this->request->params['pass'][0];
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
    public function add($categoryId = null)
    {
        if ($categoryId != null) {
            $category = $this->Articles->Categories->get($categoryId);
            $this->request->data['category_id'] = $categoryId;
        }
        
        if (empty($this->request->data['featured_image']['name'])) {
            unset($this->request->data['featured_image']);
        }
        
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data, [
                'validate' => 'add'
            ]);
            $article->user_id = $this->Auth->user('id');
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('article', 'users'));
        $this->set('_serialize', [
            'article'
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id
     *            Article id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->session();
        $article = $this->Articles->get($id, [
            'contain' => [
                'Media',
                'FeaturedMedia'
            ]
        ]);
        
        if (empty($this->request->data['featured_image']['name'])) {
            unset($this->request->data['featured_image']);
        }
        
        if ($this->request->is([
            'patch',
            'post',
            'put'
        ])) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            
            if ($this->request->data['is_featured'] == '1' && empty($article->featured_image)) {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
                return $this->redirect($this->here);
            }
            
            $article->user_id = $this->Auth->user('id');
            if ($this->Articles->save($article, [
                'associated' => [
                    'Media'
                ]
            ])) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $users = $this->Articles->Users->find('list', [
            'limit' => 200
        ]);
        $this->set(compact('article', 'users'));
        $this->set('_serialize', [
            'article'
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id
     *            Article id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod([
            'post',
            'delete'
        ]);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }
}
