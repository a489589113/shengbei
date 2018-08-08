<?php

namespace Crius\Smy\Rules;

use Crius\Smy\Helpers\Idcard;
use Illuminate\Contracts\Validation\Rule;

class IdNumber implements Rule
{
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $idCard = new Idcard();
        if (!$idCard->checkIdentityNumber($value)) {
            return false;
        }
        if (!$idCard->isChinaIDCard($value)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '身份证号码 无效';
    }
}
