<?php
declare(strict_types=1);

namespace Hyperf\Filter;

use Hyperf\Database\Model\Builder;

abstract class QueryFilter
{
    protected Builder $builder;

    public function filter(Builder $builder, array $params): Builder
    {
        $this->builder = $builder;

        foreach ($params as $name => $value) {
            $name = $this->toCamelCase($name);
            if (method_exists($this, $name) && !$this->isEmptyValue($value)) {
                call_user_func_array([$this, $name], [$value]);
            }
        }

        return $this->builder;
    }

    private function isEmptyValue(mixed $value): bool
    {
        if($value === '') return true;
        if(is_array($value) && (sizeof($value) <= 0)) return true;
        return false;
    }

    private function toCamelCase(string $str): string
    {
        $array = explode('_', $str);
        $result = $array[0];
        $len = count($array);
        if ($len > 1) {
            for ($i = 1; $i < $len; $i++) {
                $result .= ucfirst($array[$i]);
            }
        }
        return $result;
    }
}