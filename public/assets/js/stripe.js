// Create a Stripe client.

var stripe = Stripe($("#stripe_publish_key").val());
let clientSecret =$("#clientSecret").val();
alert(clientSecret);
// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.on('change', function (event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementsByClassName('payment-form');

form.addEventListener('submit', function (event) {
    event.preventDefault();
    stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: card
        }
    })
    .then(function (result) {
        var displayError = document.getElementById('card-errors');
        if (result.error) {
            // Show error to your customer
            displayError.textContent = result.error.message;
        } else {
            // The payment succeeded!
            stripeTokenHandler(result.paymentIntent.id);
        }
    });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementsByClassName('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
