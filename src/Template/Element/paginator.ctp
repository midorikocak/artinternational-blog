<div class="row">
  <div class="large-12 medium-12 columns">
    <div class="paginator">
      <ul class="pagination">
        <?= $paginator->prev('< ' . __('previous')) ?>
        <?= $paginator->numbers() ?>
        <?= $paginator->next(__('next') . ' >') ?>
      </ul>
      <p><?= $this->Paginator->counter() ?></p>
    </div>
  </div>
</div>
