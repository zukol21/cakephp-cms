<?php
namespace Cms\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity.
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $excerpt
 * @property string $content
 * @property string $featured_img
 * @property string $category
 * @property string $created_by
 * @property string $modified_by
 * @property \Cake\I18n\Time $publish_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Article extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
