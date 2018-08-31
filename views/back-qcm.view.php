<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="rose">
                            <i class="material-icons">class</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Qcm</h4>
                            <div class="ripple-container"></div>
                            <?php if(count($config['content']) > 0): ?>
                                <?php $this->addModal('table', $config); ?>
                            <?php else: ?>
                                <b>Aucun QCM n'a été créé pour l'instant.</b>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>