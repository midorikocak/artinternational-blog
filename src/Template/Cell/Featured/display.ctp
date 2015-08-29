<div class="featured-slider">
    <?php     
    use PhpParser\Builder\Class_;

    foreach($featuredArticles as $article){
        if(empty($article->category)){
            $article->category = new Class_('Category');
            $article->category->slug = 'articles';
        }
        echo "<div class='featured-image'>".$this->Html->image($article->featured_media->filename,['url'=>$this->Url->build('/'.$article->category->slug.'/'.$article->slug,true)])."</div>";
    }

    ?>
</div>
