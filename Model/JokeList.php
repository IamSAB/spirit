<?php

namespace Model;

class JokeList implements Listable
{
	/* database connection */
	private $maphper;

	/* sort method */
	private $sort = 'oldest';

	/* search keywork if set */
	private $keyword;

	public function __construct(\Maphper\Maphper $maphper, string $sort = 'oldest', string $keyword = '')
	{
		$this->maphper = $maphper;
		$this->sort = $sort;
		$this->keyword = $keyword;
	}

	public function sort($dir): Listable
	{
		return new self($this->maphper, $dir, $this->keyword);
	}

	public function search($keyword): Listable
	{
		return new self($this->maphper, $this->sort, $keyword);
	}

	public function getKeyword(): string
	{
		return $this->keyword;
	}

	public function getSort(): string
	{
		return $this->sort;
	}

	public function delete($id): Listable
	{
		unset($this->maphper[$id]);
		return $this;
	}

	public function get(): \Maphper\Maphper
	{
		$jokes = $this->maphper;

		if ($this->sort == 'newest') {
			$jokes = $jokes->sort('id asc');
		}
		else if ($this->sort == 'oldest') {
			$jokes = $jokes->sort('id desc');
		}

		if ($this->keyword) {
			$jokes = $jokes->filter([\Maphper\Maphper::FIND_LIKE => ['text' => $this->keyword]]);
		}

		return $jokes;
	}
}
