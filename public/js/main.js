//cart
$('body').on('click', '.add-to-cart', function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let qty = $('.quantity input').val() ? $('.quantity input').val() : 1;
    $.ajax({
        url: '/cart/add',
        type: 'GET',
        data: {id: id, qty: qty},
        success: function (res) {
            showCart(res);
        },
        error: function () {
            alert('Ошибка, попробуйте позже!');
        }
    });
});

$('body').on('click', '.delete-item', function () {
    const id = $(this).data("id");
    $.ajax({
        url: '/cart/delete',
        data: {id: id},
        type: 'GET',
        success: function (res) {
            showCart(res);
        },
        error: function () {
            alert('Произошла ошибка,попробуйте позже!')
        }
    })
});

function showCart(cart) {
    if ($.trim(cart) == '<h3>Корзина пуста</h3>') {
        $('.cart-empty').hide();
    } else {
        $('.cart-empty').show();
    }
    $('.modal-body').html(cart);
    $("#cart").modal();
    if ($('.cart-amount').text()) {
        $('.simpleCart_total').html($('.cart-amount').text());
    } else {
        $('.simpleCart_total').text('Корзина пуста');
    }
}

function getCart() {
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: function (res) {
            showCart(res);
        },
        error: function () {
            alert('Ошибка, попробуйте позже!');
        }
    });
}

function clearCart() {
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function (res) {
            showCart(res);
        },
        error: function () {
            alert('Произошла ошибка,попробуйте позже!')
        }
    })
}

$('#currency').on('change', function () {
    window.location = 'currency/change?curr=' + $(this).val();
});