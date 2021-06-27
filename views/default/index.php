<?php
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $rules array */
/** @var $showRequestForm bool */

$this->title = Yii::t('app', 'REST API Documentation');

$methodColorMap = [
    'GET' => 'info',
    'HEAD' => 'info',
    'OPTIONS' => 'info',
    'DELETE' => 'danger',
    'POST' => 'success',
    'PUT' => 'warning',
    'PATCH' => 'warning',
];

$fnGetHtmlIdForRule = function ($rule) {
    if ($rule['method'] === 'GET' && !empty($rule['params'])) {
        return 'get-id';
    } else {
        return strtolower($rule['method']);
    }
};

?>
<div class="docs-index">

    <input type="hidden" id="username" value="<?= Html::encode(Yii::$app->user->identity->username) ?>">

    <div>
        <?= Yii::t('app', 'Please, click on APIs names/methods listed further and send queries to our server for getting results.') ?>
    </div>
    <br/><br/>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php
        if (!sizeof($rules)) {
            ?>
            <div class="alert alert-warning">
                <?= Yii::t('app', 'Sorry, you have not access to any API. Please, contact system administrator to assign the required API permissions to your role.') ?>
            </div>
            <?php
        }
        ?>
        <?php foreach ($rules as $ei => $entity) : ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?= $entity['title'] ?>">
                            <?= $entity['title'] ?>
                        </a>
                    </h4>
                </div>
                <div id="<?= $entity['title'] ?>" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">

                        <div class="list-group" id="<?= $entity['title'] ?>-list" role="tablist" aria-multiselectable="true">
                            <?php foreach ($entity['rules'] as $ri => $rule) : ?>
                            <?php
                                // for better readability and generic logic in tests
                                $ri = $fnGetHtmlIdForRule($rule);
                            ?>
                                <a class="endpoint-toggle list-group-item" role="button" data-parent="#<?= $entity['title'] ?>-list" data-toggle="collapse" href="#rule-<?= $entity['title'] ?>-<?= $ri ?>" aria-expanded="false" aria-controls="rule-<?= $entity['title'] ?>-<?= $ri ?>">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <span class="label bg-<?= $methodColorMap[$rule['method']] ?> pull-left col-lg-1 method"><?= $rule['method'] ?></span>
                                            <span class="col-lg-11 text-nowrap ellipsis">
                                                <strong class="url"><?= htmlspecialchars($rule['url']) ?></strong>
                                                <?php if (!empty($rule['description'])) : ?>
                                                    - 
                                                    <i><?= htmlspecialchars(strip_tags($rule['description'])) ?></i>
                                                <?php endif; ?>
                                            </span>


                                        </div>
                                    </div>
                                </a>

                                <div id="rule-<?= $entity['title'] ?>-<?= $ri ?>" class="panel panel-primary collapse" role="tabpanel">
                                    <div class="panel-body">
                                        <?php if (!empty($rule['description'])) : ?>
                                            <p><?= $rule['description'] ?></p>
                                        <?php endif ?>
                                        <?php
                                        if ($showRequestForm) {
                                            echo $this->render('_form', [
                                                'rule' => $rule,
                                                'ri' => $ri,
                                            ]);
                                        }
                                        ?>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
