<?php
namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class MemberFilter extends ModelFilter{
 public function name($value){
  return $this->whereLike('full_name', $value);
 }
 public function code($value){
  return $this->where('code', $value);
 }
}