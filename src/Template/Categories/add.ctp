<div class="categories form large-12 medium-12 columns content">
    <?= $this->Form->create($category) ?>
    <fieldset>
        <?php
            //echo $this->Form->input('parent_id', ['options' => $parentCategories, 'empty' => __('Root')]);
            echo $this->Form->input('name');
            //echo $this->Form->input('link');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
