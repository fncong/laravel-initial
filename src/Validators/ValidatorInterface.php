<?php

namespace App\Http\Validators;

interface ValidatorInterface
{
	public function rules(): array;


	public function scenes($scene);


	public function messages(): array;


	public function attributes(): array;
}
