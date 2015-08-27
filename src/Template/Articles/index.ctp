<?php
  echo $this->element('slider');
?>
  <?php
   echo $this->element('featuredArticles',['articles'=>$articles,'paginator'=>$this->Paginator]);
  ?>
