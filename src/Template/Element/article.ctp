<article>
  <h3><a href="#"><?= h($article->title) ?></a></h3>
  <div class="row">
    <div class="large-10 medium-10 columns article-info">
      <span class="silent">Written by <a href="#"><?= $article->has('user') ? $this->Html->link($article->user->email, ['controller' => 'Users', 'action' => 'view', $article->user->id]) : '' ?></a> on
        <time pubdate datetime="<?= h($article->created) ?>"><?= h($article->created) ?></time>
      </span>
    </div>
    <div class="large-2 medium-2 columns article-controls">
      <?php
      if($session->read('Auth.User')):
      ?>
      <a data-dropdown="article-drop-<?= h($article->id) ?>" aria-controls="article-drop" aria-expanded="false"><i class="caret">&nbsp;</i></a>
      <ul id="article-drop-<?= h($article->id) ?>" class="tiny f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
        <li><?= $this->Html->link(__('View'), ['controller'=>'articles','action' => 'view', $article->id]) ?></li>
        <li><?= $this->Html->link(__('Edit'), ['controller'=>'articles','action' => 'edit', $article->id]) ?></li>
        <li><?= $this->Form->postLink(__('Delete'), ['controller'=>'articles','action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id)]) ?></li>
      </ul>
      <?php
      endif;
      ?>
    </div>
  </div>
  <?= strip_tags($article->body, '<ul><ol><li><p><i><a><img><b><br><div><br/>'); ?>
</article>
