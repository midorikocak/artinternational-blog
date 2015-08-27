<br />
<?php foreach ($categories as $category): ?>
<div class="row">
	<div class="categories large-10 medium-10 columns">
        <?= $this->Html->link(h($category->name), ['action' => 'view', $category->id])?>
    </div>
	<div class="large-2 medium-2 columns">
		<a data-dropdown="category-drop-<?= h($category->id) ?>"
			aria-controls="category-drop-<?= h($category->id) ?>"
			aria-expanded="false"><i class="caret">&nbsp;</i></a>
		<ul id="category-drop-<?= h($category->id) ?>" class="tiny f-dropdown"
			data-dropdown-content aria-hidden="true" tabindex="-1">
			<li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id]) ?></li>
			<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?></li>
			<li><?= $this->Form->postLink(__('Move down'), ['action' => 'moveDown', $category->id], ['confirm' => __('Are you sure you want to move down # {0}?', $category->id)]) ?></li>
			<li><?= $this->Form->postLink(__('Move up'), ['action' => 'moveUp', $category->id], ['confirm' => __('Are you sure you want to move up # {0}?', $category->id)]) ?></li>
		</ul>
	</div>
</div>
<br />
<?php endforeach; ?>
