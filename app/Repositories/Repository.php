<?php

namespace App\Repositories;

abstract class Repository
{
    /**
     *
     * @param array $inputs
     * @return array
     */
    public function removeNullables(array $inputs)
    {
        foreach ($inputs as $key => $value)
        {
            if (is_array($value))
            {
                $inputs[$key] = $this->removeNullables($inputs[$key]);
            }

            if (empty($inputs[$key]) && !is_string($inputs[$key]))
            {
                unset($inputs[$key]);
            }
        }

        return $inputs;
    }
}