<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TwoRadioGroups implements Rule
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
        $groups = collect($value)->groupBy(function ($item) {
            return explode('.', $item)[0];
        });

        return $groups->count() === 2 && $groups->every(function ($group) {
                return count($group) === 1;
            });
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please select one option from each group.';
    }
}
