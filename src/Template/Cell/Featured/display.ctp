<div class="featured-slider">
<?php

foreach($featuredArticles as $article){
  echo "<div>".$this->Html->image($article->featured_media->filename,['url'=>$this->Url->build(['controller'=>'articles','action' => 'view', $article->id],true)])."</div>";
}

?>
</div>
