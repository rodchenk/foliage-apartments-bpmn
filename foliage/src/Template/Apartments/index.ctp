<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Apartment[]|\Cake\Collection\CollectionInterface $apartments
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Apartment'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="apartments index large-9 medium-8 columns content">
    <h3><?= __('Apartments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('ApartmentID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('UserID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Location') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Topic') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apartments as $apartment): ?>
            <tr>
                <td><?= $this->Number->format($apartment->ApartmentID) ?></td>
                <td><?= $this->Number->format($apartment->UserID) ?></td>
                <td><?= h($apartment->Location) ?></td>
                <td><?= $this->Number->format($apartment->Price) ?></td>
                <td><?= h($apartment->image) ?></td>
                <td><?= h($apartment->Topic) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $apartment->ApartmentID]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $apartment->ApartmentID]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $apartment->ApartmentID], ['confirm' => __('Are you sure you want to delete # {0}?', $apartment->ApartmentID)]) ?>
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
