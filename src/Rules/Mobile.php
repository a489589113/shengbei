<?php

namespace Crius\Smy\Rules;

use Illuminate\Contracts\Validation\Rule;
use Verification\CellPhoneCheck;

class Mobile implements Rule
{
    use CellPhoneCheck;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
//        return preg_match('/^1[3456789][0-9]{9}$/', $value) ? true : false;
        return $this->checkPhone($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '手机号码格式错误';
    }
}
