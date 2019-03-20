<?php

namespace Controller;

use Model\Listable;


class Listing
{
    public function filterList(Listable $list): Listable
    {
		if (!empty($_GET['sort'])) {
			$list = $list->sort($_GET['sort']);
		}

		if (!empty($_GET['search'])) {
			$list = $list->search($_GET['search']);
		}

		return $list;
	}

    public function delete(Listable  $list): Listable
    {
		return $list->delete($_POST['id']);
	}
}
