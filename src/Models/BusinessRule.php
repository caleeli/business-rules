<?php

namespace ProcessMaker\Package\BusinessRules\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessRule extends Model
{

    protected $fillable = [
        'id',
        'variable',
        'condition',
        'status'
    ];

    /**
     * Validation rules
     *
     * @return array
     */
    public static function rules()
    {

        return [
            'variable' => ['required'],
            'condition' => ['required'],
            'status' => 'in:ENABLED,DISABLED',
        ];
    }
}
