<div class="row">
    <section class="col-lg-12 col-md-12 col-sm-12 col-xs">
        <div class="errorMessage">
            <?php echo $code.' - '.$message; ?>
        </div>
    </section>
</div>
<div class="row">
    <section class="col-lg-12 col-md-12 col-sm-12 col-xs">
        <form method="POST" action="<?php echo DIRNAME.'index/home'; ?>">
            <button name="button" class="btn btn-rose">
                ACCUEIL
            </button>
        </form>
    </section>
</div>