<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Apartment $apartment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Apartment'), ['action' => 'edit', $apartment->ApartmentID]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Apartment'), ['action' => 'delete', $apartment->ApartmentID], ['confirm' => __('Are you sure you want to delete # {0}?', $apartment->ApartmentID)]) ?> </li>
        <li><?= $this->Html->link(__('List Apartments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Apartment'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="apartments view large-9 medium-8 columns content">
    <h3><?= h($apartment->ApartmentID) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= h($apartment->Location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image') ?></th>
            <td><?= h($apartment->image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Topic') ?></th>
            <td><?= h($apartment->Topic) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ApartmentID') ?></th>
            <td><?= $this->Number->format($apartment->ApartmentID) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('UserID') ?></th>
            <td><?= $this->Number->format($apartment->UserID) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($apartment->Price) ?></td>
        </tr>
    </table>
</div>
