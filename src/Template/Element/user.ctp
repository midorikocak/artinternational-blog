<?php
if($session->read('Auth.User')):
?>
<div class="user-controls">
  <a href="#" data-dropdown="user-drop" aria-controls="user-drop" aria-expanded="false"><?= $session->read('Auth.User.email')?></a>
  <ul id="user-drop" class="tiny f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
      <li><a href="<?= $this->Url->build(['controller'=>'users','action'=>'edit',$session->read('Auth.User.id')])?>"><?= __('Edit') ?></a></li>
      <li><a href="<?= $this->Url->build(['controller'=>'categories','action'=>'index'])?>"><?= __('Categories') ?></a></li>
      <li><a href="<?= $this->Url->build(['controller'=>'settings','action'=>'editAll'])?>"><?= __('Settings') ?></a></li>
      <li><a href="<?= $this->Url->build(['controller'=>'users','action'=>'index'])?>"><?= __('Users') ?></a></li>
      <li><a href="<?= $this->Url->build(['controller'=>'users','action'=>'logout'])?>"><?= __('Logout') ?></a></li>
    </ul>
</div>
<?php
endif;
?>
