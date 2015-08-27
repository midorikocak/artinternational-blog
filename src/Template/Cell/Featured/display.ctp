<div class="featured-slider">
<?php
foreach($featuredArticles as $article){
  echo "<div class='featured-image'>".$this->Html->image($article->featured_media->filename,['url'=>$this->Url->build('/'.$article->category->slug.'/'.$article->slug,true)])."</div>";
}

?>
</div>
