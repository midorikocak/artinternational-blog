<div class="main-content">
<?php
use PhpParser\Builder\Class_;
foreach ($articles as $archiveArticle){
    if(empty($archiveArticle->category)){
        $archiveArticle->category = new Class_('Category');
        $archiveArticle->category->slug= 'articles';
    }
    echo '<div class="archive-article">'.$this->Html->link($archiveArticle['title'],'/'.$archiveArticle->category->slug.'/'.$archiveArticle['slug']).'</div>';
}
?>
</div>
<?= $this->element('paginator',['paginator'=>$paginator]) ?>