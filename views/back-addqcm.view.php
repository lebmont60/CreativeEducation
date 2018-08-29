<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="rose">
                            <i class="material-icons">add_circle</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Formulaire d'ajout de qcm</h4>

                            <?php $this->addModal("form_all", $config, $errors); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    let $addLink = $('#add_question');
    let $newLink = $('<div></div>').append($addLink);
    jQuery(document).ready(function() {
        let $form = $('form');
        $form.append($newLink);
        $form.data('index', $form.find(':input .question').length);

        $addLink.on('click', function(e) {
            e.preventDefault();
            addQuestion($form, $newLink);
        });


    });

    function addQuestion($form, $newLink) {
        let question = $addLink.data('question');

        let index = $form.data('index');

        if(index === 0){
            index = 1;
        }
        index+=1;

        $form.data('index', index);

        let newForm = question.replace(/__index__/g, index);

        let $newQuestion = $('#form_content').append(newForm);

        $('#question_'+(index)).append('<a href="#" class="remove-question">X</a>');

        $newLink.before($newQuestion);

        // handle the removal, just for this example

        $('.remove-question').click(function(e) {
            e.preventDefault();

            $form.data('index', index-1);
            $(this).parent().remove();

            return false;
        });
    }

</script>