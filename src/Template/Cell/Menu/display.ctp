<ul>
  <?php foreach ($categories as $category): ?>
    <li><?php
      //var_dump($category->children);
      if(empty($category->link))
      {
        echo $this->Html->link(
        h($category->name), '/'.$category->slug);
      }else{
        echo $this->Html->link(
        h($category->name),$category->link);
      }
 ?></li>
  <?php endforeach; ?>
<?php
  if($session->read('Auth.User')):
?>
  <li>
    <?php
    echo $this->Html->link(
    '+', ['controller' => 'Categories', 'action' => 'add' , '_full' => true]);
    ?>
  </li>
</ul>
<?php
endif;
 ?>
