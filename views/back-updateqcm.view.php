<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="rose">
                            <i class="material-icons">build</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Formulaire de modification de qcm</h4>

                            <?php $this->addModal("form_qcm", $config, $errors); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    jQuery(document).ready(function() {
        let $addLink = $('#add_question_link');
        let $form = $('form');
        $form.data('index', $form.find('div .question').length);
        $addLink.on('click', function(e) {
            e.preventDefault();
            addQuestion($form, $addLink);
        });

        $('.remove-question').click(function(e) {
            e.preventDefault();
            $('#'+$(this).data('remove')).remove();

            return false;
        });

    });

    function addQuestion($form, $addLink) {
        let question = $addLink.data('question');

        let index = $form.data('index');

        if(index === 0){
            index = 1;
        }
        index+=1;

        $form.data('index', index);

        let newForm = question.replace(/__index__/g, index);

        let $newQuestion = $('#add_question').before(newForm);

        $('#question_'+(index)).append('<a href="#" class="remove-question">X</a>');

        $('.remove-question').click(function(e) {
            e.preventDefault();

            $(this).parent().remove();

            return false;
        });
    }

</script>