<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 11/06/18
 * Time: 22:03
 */

namespace App\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class VehicleValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:255',
            'year'        => 'required|integer|min:1900',
            'description' => 'required|string',
            'has_sold'    => 'required|boolean'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'        => 'string|max:255',
            'brand'       => 'string|max:255',
            'year'        => 'integer',
            'description' => 'string',
            'has_sold'    => 'boolean'
        ]
    ];
}