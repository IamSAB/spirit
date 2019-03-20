<?php

namespace Model;

class JokeList implements Listable
{
	/* database connection */
	private $pdo;

	/* sort method */
	private $sort = 'oldest';

	/* search keywork if set */
	private $keyword;

	public function __construct(\PDO $pdo, string $sort = 'oldest', string $keyword = '')
	{
		$this->pdo = $pdo;
		$this->sort = $sort;
		$this->keyword = $keyword;
	}

	public function sort($dir): Listable
	{
		return new self($this->pdo, $dir, $this->keyword);
	}

	public function search($keyword): Listable
	{
		return new self($this->pdo, $this->sort, $keyword);
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
		$stmt = $this->pdo->prepare('DELETE FROM joke WHERE id = :id');
		$stmt->execute(['id' => $id]);

		return $this;
	}

	public function list(): array
	{
		$parameters = [];

		if ($this->sort == 'newest') {
			$order = ' ORDER BY id DESC';
		}
		else if ($this->sort == 'oldest') {
			$order = ' ORDER BY id ASC';
		}
		else {
			$order = '';
		}


		if ($this->keyword) {
			$where = ' WHERE text LIKE :text';
			$parameters['text'] = '%' . $this->keyword . '%';
		}
		else {
			$where = '';
		}


		$stmt = $this->pdo->prepare('SELECT * FROM joke ' . $where . $order);
		$stmt->execute($parameters);

		return $stmt->fetchAll();
	}
}
