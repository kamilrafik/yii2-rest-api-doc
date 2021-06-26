<?php

use yii\helpers\Html;

/** @var $rule array */

?>
<form class="form">
    <input type="hidden" name="method" value="<?= $rule['method'] ?>" />
    <input type="hidden" name="url" value="<?= Html::encode(YII_ENV_TEST ? '/index-test.php'.$rule['url'] : $rule['url']) ?>" />
    <?php if (!empty($rule['params'])) : ?>
        <fieldset class="params">
            <legend>Query Parameters</legend>
            <?php foreach ($rule['params'] as $param) : ?>
                <div class="form-group">
                    <label><?= $param['title'] ?></label>
                    <input data-key="<?= $param['key'] ?>" class="form-control" type="text" required="required" />
                </div>
            <?php endforeach; ?>
        </fieldset>
    <?php endif; ?>
    <?php if (!empty($rule['filters'])) : ?>
        <fieldset class="filters">
            <legend>Query Filters</legend>
            <?php foreach ($rule['filters'] as $filter) : ?>
                <div class="form-group">
                    <label><?= $filter['title'] ?></label>
                    <input data-key="<?= $filter['key'] ?>" class="form-control" type="text" />
                </div>
            <?php endforeach; ?>
        </fieldset>
    <?php endif; ?>
    <?php if (!empty($rule['expand'])) : ?>
        <fieldset class="params expand">
            <legend>Expand Parameters</legend>
            <?php foreach ($rule['expand'] as $expand) : ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="<?= $expand['key'] ?>" />
                        <?= $expand['title'] ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </fieldset>
    <?php endif; ?>
    <?php if (!in_array($rule['method'], ['GET', 'DELETE']) && empty($rule['fileFields'])) : ?>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-7">
                    <label for="body-<?= $ri ?>">Request Body: </label>
                    <textarea rows="10" id="body-<?= $ri ?>" class="form-control" name="body"></textarea>
                </div>
                <?php if (!empty($rule['fields'])) : ?>
                    <div class="col-lg-5">
                        <?php foreach ($rule['fields'] as $fi => $fields) : ?>
                            <label>Sample Model #<?= $fi + 1 ?>: </label>
                            <div class="well sample pointer">
                                <?= \yii\helpers\Json::encode($fields) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!empty($rule['fileFields'])) : ?>
        <div class="files">
            <?php foreach ($rule['fileFields'] as $field) : ?>
                <div class="form-group">
                    <label><?= ucfirst($field) ?></label>
                    <input name="<?= $field ?>" class="form-control" type="file" />
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="form-group buttons">
        <?php if (!in_array($rule['method'], ['GET', 'DELETE'])) : ?>
            <button class="btn btn-default prettify">Prettify Body</button>
        <?php endif; ?>
        <button class="btn btn-primary send <?php if ($rule['method'] == 'DELETE') print 'btn-danger' ?>">Send</button>
    </div>
    <div class="response well">
        <p class="text-center loader hidden">Loading...</p>
        <div class="data hidden">
            <h5>Action: <?= $rule['method'] ?> <span class="final-url"></span></h5>
            <h4>Status: <span class="element code"></span> (<span class="element text"></span>)</h4>
            <h4>Headers:</h4>
            <p class="element headers"></p>
            <h4>Body:</h4>
            <p class="element body"></p>
        </div>
    </div>
</form>