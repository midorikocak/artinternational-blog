<ul class="social">
<?php
foreach ($social as $key => $value) :
    ?>
    
    <li><?php echo $this->Html->link("<i class='fa fa-$key'></i>" , $value ,['escape'=>false]); ?></li>
    
    <?php
endforeach;
?>
</ul>
