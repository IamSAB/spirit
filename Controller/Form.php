<?php

namespace Controller;

use Model\Editable;


class Form
{
    public function edit(Editable $list): Editable
    {
        if (isset($_GET['id'])) {
            return $list->load($_GET['id']);
        }
        else {
            return $list;
        }
    }

    public function submit(Editable $list): Editable
    {
        return $list->save($_POST['joke']);
    }
}
