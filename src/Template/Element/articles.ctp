<?php foreach ($articles as $article): ?>
  <?php
   echo $this->element('article',['article'=>$article]);
  ?>
<?php endforeach; ?>
<? $this->element('paginator',['paginator'=>$paginator]) ?>
