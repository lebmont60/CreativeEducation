<div class="table-responsive">
    <table class="table">
        <thead class="text-primary">
            
            <?php foreach($config['thead'] as $th): ?>

                <th><?php echo $th; ?></th>

            <?php endforeach; ?>

        </thead>
        <tbody>
           
            <?php foreach($config['content'] as $idUser => $user): ?>

                <tr>

                    <?php foreach($user as $key => $value):

                        if($key != 'actions'): ?>

                            <td><?php echo $value; ?></td>

                        <?php else: ?>

                            <td class="td-actions">

                                <?php foreach($user['actions'] as $btnType => $button): ?>

                                    <form action="<?php echo DIRNAME.$button['path']; ?>">
                                        <button class="btn btn-action btn-<?php echo $button['color']; ?>">
                                            <i class="material-icons"><?php echo $button['icon']; ?></i>
                                        </button>
                                    </form>
                            
                                <?php endforeach; ?>

                            </td>

                        <?php endif;

                    endforeach; ?>

                </tr>

            <?php endforeach; ?>

        </tbody>
    </table>
</div>