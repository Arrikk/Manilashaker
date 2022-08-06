<main class="page-content">
    <?php __alerts() ?>
    <!-- < ?php __order_details($__details) ?> -->
</main>
<script>
    $('.save-order-status').on('click', function(){
        $(this).attr('disabled')
        let status = $('.order-selected-status').val()
        if(status !== ''){
            
            $(this).text('Processing...')
            fetch('/admin/product/orders'+location.search+'&change='+status)
            .then(res => res.json())
            .then(data => {
                location.reload()
                // console.log(data)
            })
        }else{
            alert('Please select an order status')
        }
    })
    // console.log(window.location)
</script>