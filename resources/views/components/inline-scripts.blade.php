<script>
    function getCsrfToken(){
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    function handleAddToCart(event) {
        event.preventDefault();

        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const productSlug = event.target.getAttribute('data-slug');

        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                productSlug: productSlug
            })
        });
    }

    function handleRemoveCart(cardID) {
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var cartDeleteUrl = '{{ route('cart.remove', ':id') }}';
        var url = cartDeleteUrl.replace(':id', cardID);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        });
    }

    function setCartItemCounts(){
        const headerCartItemCounts = document.querySelectorAll('#cart-item-counts');
        if(headerCartItemCounts){
            headerCartItemCounts.forEach(item => {
                item.textContent = {{ App\Models\Cart::count() }};
            });
        }
    }

    function updateCartQuantity(cartQuantity, cardID) {
        var cartUpdateUrl = '{{ route('cart.update', ':id') }}';
        var url = cartUpdateUrl.replace(':id', cardID);
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (cartQuantity >= 0) {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    quantity: cartQuantity,
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Assuming the response is JSON data
                return response.json();
            })
            .then(response => {
                elementTotal = '#cart-total-'+response.data.id;
                document.querySelector(elementTotal).textContent = response.data.total;
                document.querySelector('#cart-subtotal').textContent = response.calculation.subtotal;
                document.querySelector('#cart-total').textContent = response.calculation.totalWithShipping;
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors if needed
            });
        }
    }

    document.addEventListener('click', function(event) {
        if(event.target.classList.contains('add-to-cart')){
            handleAddToCart(event);
        }
    });

    document.addEventListener('focusout', function(event) {
        var quantityInputBox = event.target;
        
        // if exists cart quantity input
        if(quantityInputBox.classList.contains('cart-quantity')){
            const newVal = quantityInputBox.value;
            var cartID = quantityInputBox.getAttribute('data-id');
            updateCartQuantity(newVal,cartID);
        }
    });
    setCartItemCounts();
</script>