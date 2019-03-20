<?php

namespace Model;


interface Editable
{
    /*
	* @description load a record from the database
	* @param $id - ID of the record to load from the database
	*/
	public function load(int $id): self;

	/*
	* @description return the record currently being represented
	*              this may have come from the DB or $_POST
	*/
	public function get(): array;

	/*
	* @description has the form been submitted or not?
	*/
	public function isSubmitted(): bool;

	/*
	* @description return a list of validation errors in the current $record
	*/
	public function getErrors(): array;

	/*
	* @description attempt to save $record to the database, insert or update
    *			   depending on whether $record['id'] is set
	*/
	public function save(array $record): self;
}

