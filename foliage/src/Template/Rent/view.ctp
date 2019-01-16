<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rent $rent
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Rent'), ['action' => 'edit', $rent->RentID]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rent'), ['action' => 'delete', $rent->RentID], ['confirm' => __('Are you sure you want to delete # {0}?', $rent->RentID)]) ?> </li>
        <li><?= $this->Html->link(__('List Rent'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rent'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rent view large-9 medium-8 columns content">
    <h3><?= h($rent->RentID) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('RentID') ?></th>
            <td><?= $this->Number->format($rent->RentID) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('UserID') ?></th>
            <td><?= $this->Number->format($rent->UserID) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ApartmentID') ?></th>
            <td><?= $this->Number->format($rent->ApartmentID) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DateFrom') ?></th>
            <td><?= h($rent->DateFrom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DateTo') ?></th>
            <td><?= h($rent->DateTo) ?></td>
        </tr>
    </table>
</div>
