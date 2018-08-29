<?php
    class Alert
    {
        public function __construct($content, $type = "success")
        {
            echo '<div class="alertForJs" style="display: none;" data-type="'.$type.'">'.htmlspecialchars($content).'</div>';
        }
    }