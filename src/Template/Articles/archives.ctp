<?php
$year = '';
$month = '';
foreach ($archives as $archiveArticle){
    if(empty($archiveArticle['Category'])){
        $archiveArticle['Category'] = [];
        $archiveArticle['Category']['slug']= 'articles';
    }
    if($archiveArticle['year']!=$year){
        echo '<div class="archive-year">'.$archiveArticle['year']."</div>";
        $year = $archiveArticle['year'];
    }
    if($archiveArticle['month']!=$month){
        echo '<div class="archive-month">'.$archiveArticle['month']."</div>";
        $month = $archiveArticle['month'];
    }
    echo '<div class="archive-article">'.$this->Html->link($archiveArticle['title'],'/'.$archiveArticle['Category']['slug'].'/'.$archiveArticle['slug']).'</div>';
}