<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rent Entity
 *
 * @property int $RentID
 * @property int $UserID
 * @property int $ApartmentID
 * @property \Cake\I18n\FrozenDate $DateFrom
 * @property \Cake\I18n\FrozenDate $DateTo
 */
class Rent extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'UserID' => true,
        'ApartmentID' => true,
        'DateFrom' => true,
        'DateTo' => true
    ];
}
