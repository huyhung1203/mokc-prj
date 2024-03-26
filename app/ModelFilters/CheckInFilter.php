<?php
namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class CheckInFilter extends ModelFilter{
 public function checkDate($value){
  return $this->whereDate('check_in_date', $value);
 }
 public function guest($value){
  return $this->related('members', 'is_gues', $value);
 }
}