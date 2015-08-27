<div class="main-content">
	<br />
<?php foreach ($users as $user): ?>
<div class="row">
		<div class="users large-10 medium-10 columns">
        <?= $this->Html->link(h($user->email), ['action' => 'edit', $user->id])?>
    </div>
		<div class="large-2 medium-2 columns">
			<a data-dropdown="user-drop-<?= h($user->id) ?>"
				aria-controls="user-drop-<?= h($user->id) ?>" aria-expanded="false"><i
				class="caret">&nbsp;</i></a>
			<ul id="user-drop-<?= h($user->id) ?>" class="tiny f-dropdown"
				data-dropdown-content aria-hidden="true" tabindex="-1">
				<li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?></li>
				<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?></li>
			</ul>
		</div>
	</div>
	<br />
<?php endforeach; ?>
<center><?= $this->Html->link(__('Add A New User'), ['action' => 'add'])?>
</center>
</div>
<div class="paginator">
	<ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous'))?>
            <?= $this->Paginator->numbers()?>
            <?= $this->Paginator->next(__('next') . ' >')?>
        </ul>
	<p><?= $this->Paginator->counter() ?></p>
</div>
