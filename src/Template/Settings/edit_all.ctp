<div class="settings form large-12 medium-12 columns content">
    <?= $this->Form->create($settings) ?>
    <fieldset>
        <?php
        foreach($fields as $formGroup => $groupValues){
          foreach($groupValues as $name => $value){
            echo $this->Form->input($formGroup.'.'.$name,['value'=>$value]);
          }
        }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
