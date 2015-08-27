<div class="articles index large-12 medium-12 columns content">
  <div class="row">
    <div class="large-10 medium-10 columns"><h2><?= h($category->name) ?></h2></div>
    <div class="large-2 medium-2 columns">

      <?php
      if($session->read('Auth.User')):
      ?>
      <div class="editor-controls">
        <a data-dropdown="drop1" aria-controls="drop1" aria-expanded="false"><i class="caret">&nbsp;</i></a>
        <ul id="drop1" class="tiny f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
          <li><?= $this->Html->link(__('Add Article'), ['controller'=>'articles','action' => 'add', h($category->id)]) ?></li>
          <li><?= $this->Html->link(__('View'), ['action' => 'view', $category->id]) ?></li>
          <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id]) ?></li>
          <li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?></li>
        </ul>
      </div>
      <?php
      endif;
      ?>
    </div>
  </div>
  <?=  $this->element('featuredArticles',['articles'=>$articles, 'paginator'=>$this->Paginator]); ?>
  </div>
