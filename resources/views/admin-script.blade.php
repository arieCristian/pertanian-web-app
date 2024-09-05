<script>
  document.addEventListener('DOMContentLoaded', function() {
    const formatRupiah = (number) => {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency'
        , currency: 'IDR'
        , minimumFractionDigits: 0
      }).format(number);
    }

    document.querySelectorAll('.currency-input').forEach(function(input) {
      input.addEventListener('input', function(e) {
        const value = input.value.replace(/[^0-9]/g, '');
        input.value = formatRupiah(value);
      });

      // Initial format
      const initialValue = input.value.replace(/[^0-9]/g, '');
      input.value = formatRupiah(initialValue);
      console.log(initialValue);
      console.log(formatRupiah(initialValue));
      console.log('tests aja');
    });
  });

</script>
