<?php

namespace Model;

interface Listable
{
    public function sort($dir): self;

	public function search($keyword): self;

	public function getKeyword(): string;

	public function getSort(): string;

	public function delete($id): self;

	public function list(): array;
}
