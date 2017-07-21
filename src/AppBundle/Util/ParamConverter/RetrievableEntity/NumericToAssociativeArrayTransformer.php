<?php
declare(strict_types=1);

namespace AppBundle\Util\ParamConverter\RetrievableEntity;

class NumericToAssociativeArrayTransformer
{
    /**
     * Flip values and keys if the array is numerically indexed
     *
     * [
     *  0 => 'first',
     *  1 => 'second',
     *  2 => 'third',
     * ]
     * becomes
     * [
     *  'first' => 0,
     *  'second' => 1,
     *  'third' => 2,
     * ]
     *
     * @param array $input
     *
     * @return array
     */
    public function transform(array $input): array
    {
        if ($this->isNumericallyIndexed($input)) {
            return array_flip($input);
        }

        return $input;
    }

    /**
     * @param array $array
     *
     * @return bool
     */
    function isNumericallyIndexed(array $array): bool {
        return 0 === count(array_filter(array_keys($array), 'is_string'));
    }
}
