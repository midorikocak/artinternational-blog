<?php
use PhpParser\Builder\Class_;
$year = '';
$month = '';
foreach ($archives as $archiveArticle){
    if(empty($archiveArticle->category)){
        $archiveArticle->category = new Class_('Category');
        $archiveArticle->category->slug= 'articles';
    }
    if($archiveArticle['year']!=$year){
        echo '<div class="archive-year">'.$archiveArticle['year']."</div>";
        $year = $archiveArticle['year'];
    }
    if($archiveArticle['month']!=$month){
        echo '<div class="archive-month">'.$archiveArticle['month']."</div>";
        $month = $archiveArticle['month'];
    }
    echo '<div class="archive-article">'.$this->Html->link($archiveArticle['title'],'/'.$archiveArticle->category->slug.'/'.$archiveArticle['slug']).'</div>';
}