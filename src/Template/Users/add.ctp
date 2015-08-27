<div class="users form large-12 medium-12 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <?php
        echo $this->Form->input('email');
        echo $this->Form->input('password');
        echo $this->Form->input('role', [
            'options' => ['admin' => 'Admin', 'author' => 'Author']
                ]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
