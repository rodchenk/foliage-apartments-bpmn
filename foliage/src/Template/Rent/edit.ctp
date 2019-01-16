<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rent $rent
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rent->RentID],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rent->RentID)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Rent'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="rent form large-9 medium-8 columns content">
    <?= $this->Form->create($rent) ?>
    <fieldset>
        <legend><?= __('Edit Rent') ?></legend>
        <?php
            echo $this->Form->control('UserID');
            echo $this->Form->control('ApartmentID');
            echo $this->Form->control('DateFrom');
            echo $this->Form->control('DateTo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
