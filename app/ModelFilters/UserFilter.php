<?php
namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter{
 public function name($value){
  return $this->whereLike('full_name', $value);
 }
 public function id($value){
  return $this->where('id', $value);
 }
}