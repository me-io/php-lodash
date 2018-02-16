<?php

namespace __\Sequence;

use __;

trait Chain
{
    /**
     * returns a wrapper instance, allows the value to be passed through multiple bottomline functions
     *
     * __::chain([0, 1, 2, 3, null])
     *   ->compact()
     *   ->prepend(4)
     *   ->value();
     * >> [4, 1, 2, 3]
     *
     * @param mixed $initialValue
     *
     * @return mixed
     *
     */
    public static function chain($initialValue)
    {
        return new PhpLodashWrapper($initialValue);
    }
}
