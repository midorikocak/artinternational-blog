<div class="main-content">
<?php foreach ($articles as $article): ?>
  <?php
   echo $this->element('article',['article'=>$article]);
  ?>
<?php endforeach; ?>
</div>
<? $this->element('paginator',['paginator'=>$paginator]) ?>
