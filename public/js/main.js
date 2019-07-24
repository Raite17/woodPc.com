/* Filters */
$('.w_sidebar input').on('change', function () {
    let checked = $('.w_sidebar input:checked'),
        data = '';
    checked.each(function () {
        data += $(this).val() + ',';
    });
    if (data) {
        $.ajax({
            url: location.href,
            data: {filter: data},
            type: "GET",
            beforeSend: function () {
                $('.preloader').fadeIn(300, () => {
                    $('.product-one').hide();
                    var url = location.search.replace(/filter(.+?)(&|$)/g, '');
                    var newURL = location.pathname + url + (location.search ? "&" : "?") + "filter=" + data;
                    newURL = newURL.replace('&&', '&');
                    newURL = newURL.replace('?&', '?');
                    history.pushState({}, '', newURL);
                });
            },
            success: function (res) {
                $('.preloader').delay(500).fadeOut('slow', () => {
                    $('.product-one').html(res).fadeIn();
                });
            },
            error: function () {
                alert('Ошибка!');
            }
        });
    } else {
        window.location = location.pathname;
    }
});


/* Search */
var products = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: '%QUERY',
        url: path + '/search/typeahead?query=%QUERY'
    }
});

products.initialize();

$("#typeahead").typeahead({
    // hint: false,
    highlight: true
}, {
    name: 'products',
    display: 'title',
    limit: 9,
    source: products
});

$('#typeahead').bind('typeahead:select', function (ev, suggestion) {
    window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
});

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