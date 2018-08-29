<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 col-lg-7 col-sm-7">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="rose">
                            <i class="material-icons">supervised_user_circle</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Apprenants</h4>

                            <div class="ripple-container"></div>

                            <?php $this->addModal('table', $studentsList); ?>

                            <form method="POST" action="<?php echo DIRNAME.'user'; ?>">
                                <p class="pull-right">
                                    <button class="btn btn-rose">
                                        VOIR PLUS
                                        <span class="btn-label btn-label-right">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                        </span>
                                    </button>
                                </p>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="rose">
                            <i class="material-icons">supervised_user_circle</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Professeurs</h4>
                            
                            <?php $this->addModal('table', $professorsList); ?>

                            <form method="POST" action="<?php echo DIRNAME.'user'; ?>">
                                <p class="pull-right">
                                    <button class="btn btn-rose">
                                        VOIR PLUS
                                        <span class="btn-label btn-label-right">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                        </span>
                                    </button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-5 col-sm-5">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="rose">
                            <i class="material-icons">data_usage</i>
                        </div>

                        <div class="card-content">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="rose">
                            <i class="material-icons">data_usage</i>
                        </div>
                        <div class="card-content">
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
