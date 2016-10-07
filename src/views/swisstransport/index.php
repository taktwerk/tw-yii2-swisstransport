<div class="col-sm-12">'
    <h4><?= \Yii::t('app', 'Bus Lines') ?></h4>
    <?php foreach ($busLines as $bus => $line): ?>
        <div class="row">
            <div class="col-sm-12">
                <?= $line['from'] ?>, <?= $bus ?>
            </div>
            <?php foreach ($line['to'] as $to => $departure): ?>
                <div class="col-sm-3 col-sm-offset-1">
                    <?= $to ?>
                </div>
                <div class="col-sm-8">
                    <?= $departure ?>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
