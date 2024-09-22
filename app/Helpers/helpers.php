<?php

if (!function_exists('formatRupiah')) {
  /**
   * Format a number into Rupiah currency format.
   *
   * @param  int|float  $amount
   * @return string
   */
  function formatRupiah($amount)
  {
    return 'Rp ' . number_format($amount, 0, ',', '.');
  }
}
