<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Utility\Inflector;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-tags"></i>
        <h3 class="box-title"><?= __('Read More') ?></h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-stacked">
            <?php foreach ($types as $type => $typeOptions) : ?>
            <li>
                <?= $this->Html->link(Inflector::pluralize($typeOptions['label']), [
                    'controller' => 'Articles',
                    'action' => 'type',
                    $site->slug,
                    $type
                ]) ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
