<?php

namespace Model;

class JokeForm implements Editable
{
	private $maphper;

	/* $submitted: Whether or not the form has been submitted */
	private $submitted = false;

	/* Validation errors of submitted data */
	private $errors = [];

	/* The record being represented. May come from the database or a form submission */
	private $record = [];

	public function __construct(\Maphper\Maphper $maphper, $submitted = false, array $record = [], array $errors = [])
	{
		$this->maphper = $maphper;
		$this->record = $record;
		$this->submitted = $submitted;
		$this->errors = $errors;
	}

	/*
	* @description load a record from the database
	* @param $id - ID of the record to load from the database
	*/
	public function load(int $id): Editable
	{
		return new self($this->maphper, $this->submitted, (array) $this->maphper[$id]);
	}

	/*
	* @description return the record currently being represented
	*              this may have come from the DB or $_POST
	*/
	public function get(): array
	{
		return $this->record;
	}

	/*
	* @description has the form been submitted or not?
	*/
	public function isSubmitted(): bool
	{
		return $this->submitted;
	}

	/*
	* @description return a list of validation errors in the current $record
	*/
	public function getErrors(): array
	{
		return $this->errors;
	}


	/*
	* @description attempt to save $record to the database, insert or update
    *			   depending on whether $record['id'] is set
	*/
	public function save(array $record): Editable
	{
		$errors = $this->validate($record);

		if (!empty($errors)) {
			// Return a new instance with $record set to the form submission
			// When the view displays the joke, it will display the invalid
			// form submission back in the box
			return new self($this->maphper, true, $record, $errors);
		}

		$this->maphper[] = (object) $record;

		return new self($this->maphper, true, $record);
	}

	/*
	* @description validates $record
	*/
	private function validate(array $record): array
	{
		$errors = [];

		if (empty($record['text'])) {
			$errors[] = 'Text cannot be blank';
		}

		return $errors;
	}
}
