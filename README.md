### 说明

### install

```bash
composer require linron/hyperf-filter
```

### use

####新建Filter

```bash
<?php
declare(strict_types=1);

namespace App\Filter;
use Hyperf\Filter\QueryFilter;
use Hyperf\Database\Model\Builder;

class TenderListFilter extends QueryFilter
{
    public function projectId(int $projectId): Builder
    {
        return $this->builder->where('project_id', $projectId);
    }

    public function partyName(string $partyName): Builder
    {
        return $this->builder->whereHas('project.partyUnit', function (Builder $query) use ($partyName) {
            $query->where('name', 'like', "%$partyName%");
        });
    }

    public function humanCost(array $humanCost): Builder
    {
        [$start, $end] = $humanCost;
        if($start) $this->builder->where('human_cost', '>=', $start);
        if($end) $this->builder->where('human_cost', '<=', $end);
        return $this->builder;
    }

    public function masterCost(array $masterCost): Builder
    {
        [$start, $end] = $masterCost;
        if($start) $this->builder->where('master_cost', '>=', $start);
        if($end) $this->builder->where('master_cost', '<=', $end);
        return $this->builder;
    }

    public function slaveCost(array $slaveCost): Builder
    {
        [$start, $end] = $slaveCost;
        if($start) $this->builder->where('slave_cost', '>=', $start);
        if($end) $this->builder->where('slave_cost', '<=', $end);
        return $this->builder;
    }

    public function deviceCost(array $deviceCost): Builder
    {
        [$start, $end] = $deviceCost;
        if($start) $this->builder->where('device_cost', '>=', $start);
        if($end) $this->builder->where('device_cost', '<=', $end);
        return $this->builder;
    }

    public function totalCost(array $totalCost): Builder
    {
        [$start, $end] = $totalCost;
        if($start) $this->builder->where('total_cost', '>=', $start);
        if($end) $this->builder->where('total_cost', '<=', $end);
        return $this->builder;
    }

    public function status(int $status): Builder
    {
        return $this->builder->where('status', $status);
    }
}
```

####使用Filter

```bash
$query = TenderModel::filter($post, TenderListFilter::class);
````
