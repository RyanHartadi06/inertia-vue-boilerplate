<?php

namespace App\Models\User\Filters;

use App\Enums\RoleType;
use App\Libraries\Filters\DropdownFilter;
use Illuminate\Database\Eloquent\Builder;


class RoleFilter extends DropdownFilter
{
  /**
   * @var string
   */
  protected $name = 'role';
  protected $label = 'Role';

  /**
   * @var string
   */
  protected $vModel = 'query.filters.role';

  /**
   * @return array
   */
  protected function options(): array
  {
    $roles = RoleType::getValues();

    foreach ($roles as $item) {
      $result[$item] = $item;
    }
    return $result ?? [];
  }

  /**
   * @param Builder $builder
   * @param $value
   * @return Builder
   */
  public function applyFilter(Builder $query, $value): Builder
  {
    return $query->whereHas('roles', function ($query) use ($value) {
      $query->where('name', $value);
    });
  }
}
