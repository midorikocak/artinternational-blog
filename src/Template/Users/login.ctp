<p>
  <?= __('Please enter your username and password') ?>
</p>
<div class="users form">
  <?= $this->Flash->render('auth') ?>
  <?= $this->Form->create() ?>

  <?= $this->Form->input('email') ?>
  <?= $this->Form->input('password') ?>
  <?= $this->Form->button(__('Login')); ?>
  <?= $this->Form->end() ?>
</div>
