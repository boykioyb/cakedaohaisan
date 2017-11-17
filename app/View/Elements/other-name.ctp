<?php

if (!empty($listOtherNames)) {
    foreach ($listOtherNames as $lang_code => $name) {
        if(!empty($name)) {
            echo '<small>' . $lang_code . ': ' . $name . '</small><br/>';
        }
    }
}
