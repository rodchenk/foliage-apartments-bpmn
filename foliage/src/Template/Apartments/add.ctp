<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Apartment $apartment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Apartments'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="apartments form large-9 medium-8 columns content">
    <?= $this->Form->create($apartment) ?>
    <fieldset>
        <legend><?= __('Add Apartment') ?></legend>
        <?php
            echo $this->Form->control('UserID');
            echo $this->Form->control('Location');
            echo $this->Form->control('Price');
            echo $this->Form->control('image');
            echo $this->Form->control('Topic');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
