<?php

namespace __\Traits\Sequence;

use __;
use Exception;

class ChainWrapper
{
    /**
     * @var mixed $value
     */
    private $value;

    /**
     * Php-lodash constructor.
     *
     * @param mixed $value the value that is going to be chained
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Dynamically calls php-lodash functions, prepend the list of parameters with the current collection list
     *
     * @param string $functionName must be a valid php-lodash function
     * @param array  $params
     *
     * @return $this
     * @throws \Exception
     */
    public function __call(string $functionName, array $params): self
    {
        if (is_callable('\__::' . $functionName, true)) {
            $params = $params == null ? [] : $params;
            $params = __::prepend($params, $this->value);
            /** @var callable $fnCallable */
            $fnCallable = ['\__', $functionName];
            $this->value = call_user_func_array($fnCallable, $params);

            return $this;
        } else {
            throw new Exception("Invalid function {$functionName}");
        }
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
