<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rent[]|\Cake\Collection\CollectionInterface $rent
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Rent'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rent index large-9 medium-8 columns content">
    <h3><?= __('Rent') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('RentID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('UserID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ApartmentID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('DateFrom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('DateTo') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rent as $rent): ?>
            <tr>
                <td><?= $this->Number->format($rent->RentID) ?></td>
                <td><?= $this->Number->format($rent->UserID) ?></td>
                <td><?= $this->Number->format($rent->ApartmentID) ?></td>
                <td><?= h($rent->DateFrom) ?></td>
                <td><?= h($rent->DateTo) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rent->RentID]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rent->RentID]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rent->RentID], ['confirm' => __('Are you sure you want to delete # {0}?', $rent->RentID)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
