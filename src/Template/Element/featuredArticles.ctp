<div class="main-content">
<?php foreach ($articles as $article): ?>
  <?php
   echo $this->element('featuredArticle',['article'=>$article]);
  ?>
<?php endforeach; ?>
</div>
<?= $this->element('paginator',['paginator'=>$paginator]) ?>
<?= $this->Html->script('image-cropper', ['block' => 'scriptBottom']); ?>
