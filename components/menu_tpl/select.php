<?php if( isset($category['childs'])): ?>
    <li class="dropdown side-dropdown">

        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" href="<?=\yii\helpers\Url::to(['category/view', 'id' => $category['id']])?>"><?= $category['name']?>
            <?php if( isset($category['childs'])): ?><i class="fa fa-angle-right"></i><?php endif;?>
        </a>
        <div class="custom-menu">

            <div class="row">
                <div class="col">

                    <ul class="category-list">
                        <li><?= $this->getMenuHtml($category['childs'])?></li>
                    </ul>
                </div>
            </div>
        </div>

    </li>
<?php else: ?>
    <li><a href="<?=\yii\helpers\Url::to(['category/view', 'id' => $category['id']])?>"><?= $category['name']?></a></li>
<?php endif;?>