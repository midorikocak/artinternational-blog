<div class="articles form large-12 medium-12 columns content">

  <div class="quill-wrapper">


    <?= $this->Form->create($article,['type'=>'file']) ?>
    <fieldset>

      <?php
      echo $this->Form->input('title',['label'=>false,'placeholder'=>__('Title')]);
      ?>
      <div id="toolbar-toolbar" class="toolbar">
        <span class="ql-format-group">
          <span title="Bold" class="ql-format-button ql-bold"></span>
          <span class="ql-format-separator"></span>
          <span title="Italic" class="ql-format-button ql-italic"></span>
          <span class="ql-format-separator"></span>
          <span title="Link" class="ql-format-button ql-link"></span>
          <span class="ql-format-separator"></span>
          <span title="Image" class="ql-format-button ql-image"></span>
          <span class="ql-format-separator"></span>
          <span title="Underline" class="ql-format-button ql-underline"></span>
          <span class="ql-format-separator"></span>
          <span title="Strikethrough" class="ql-format-button ql-strike"></span>
        </span>
        <span class="ql-format-group">
          <span title="List" class="ql-format-button ql-list"></span>
          <span class="ql-format-separator"></span>
          <span title="Bullet" class="ql-format-button ql-bullet"></span>
          <span class="ql-format-separator"></span>
          <select title="Text Alignment" class="ql-align">
            <option value="left" label="Left" selected=""></option>
            <option value="center" label="Center"></option>
            <option value="right" label="Right"></option>
            <option value="justify" label="Justify"></option>
          </select>
        </span>
      </div>
      <div id="toolbar-editor" class="editor"></div>
      <div class="info right silent">
        <span class="ql-format-separator"></span>
        <span id="counter"></span>
      </div>
      <?php
      echo $this->Form->input('is_featured',['label'=>__('Is featured?')]);
      echo $this->Form->input('featured_image',['type'=>'file']);
      ?>
      <?php
      echo $this->Form->input('body',['type'=>'hidden', 'name'=>'body', 'id'=>'body','label'=>false,'placeholder'=>__('Body'),'value'=>__('Write here...')]);
      //echo $this->Form->input('category_id', ['options' => $categories, 'empty' => true]);
      //echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
      ?>
    </fieldset>
    <?php

    // $this->Form->button('Add Info', array(
    //        'type'=>'button',
    //        'onclick'=>'infoAdd();'
    // ));

    echo $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
  </div>

  <div id="preview-template" style="display: none;">
    <div class="dz-preview dz-file-preview">
    </div>

  </div>
  <?= $this->Html->script('quill.min', ['block' => 'scriptBottom']); ?>
  <?= $this->Html->script('commander', ['block' => 'scriptBottom']); ?>

</div>
