// Аяксовая корзина
$('form.cart').live('submit', function(e) {
	e.preventDefault();
	button = $(this).find('input[type="submit"]');
	$.ajax({
		url: "ajax/cart.php",
		data: {variant: $(this).find('select').val()},
		dataType: 'json',
		success: function(data){
			$('#cart_informer').html(data);
			if(button.attr('added_text'))
				button.val(button.attr('added_text'));
		}
	});
	$(this).find('input[type="submit"]').effect("transfer", { to: $("#cart_informer") }, 500);	
	return false;
});
