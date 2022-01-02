var stripe = Stripe('pk_test_51JcEGHFMxtKFBF8CTMbQiZwuQtVxQQcHe8NUXz4GuAQXtOwslggUyfttT228stIZK3ADqx2Y2cmZFP2fP5SuMaol00fmXR0F2d');

    document.querySelector("#submit").disabled = true;
    fetch("./server-scripts/charge_worker.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
    })

    .then(function(result){
        return result.json();
        console.log(result);
    })

    .then(function(data) {
        var elements = stripe.elements();

        var style = {
            base: {
            color: "#32325d",
            fontFamily: 'Arial, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "20px",
            "::placeholder": {
                color: "#32325d"
            }
            },

            invalid: {
            fontFamily: 'Arial, sans-serif',
            color: "#fa755a",
            iconColor: "#fa755a"
            }
        };

        document.getElementById("payment-form").style.display = "block";

        console.log(data);

        var card = elements.create("card", {style: style});
        card.mount('#card-element');

        card.on("change", function(event){
            console.log(document.querySelector("#submit").disabled);
            document.querySelector("#submit").disabled = event.empty;
            console.log(document.querySelector("#submit").disabled);
            document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
        });

        var form = document.getElementById("payment-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            payWithCard(stripe, card, data.clientSecret);
        });
    });


    var payWithCard = function(stripe, card, clientSecret){
        loading(true);
        stripe
            .confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            })
            .then(function(result) {
                if(result.error){
                    showError(result.error.message);
                }
                else{
                    //console.log("homalaule");
                    orderComplete(result.paymentIntent.id);
                }
            });
    };

    var orderComplete = function(paymentIntentId) {

        loading(false);
    
        document.querySelector(".result-message a")
        document.querySelector(".result-message").classList.remove("hidden");
        document.querySelector("#submit").disabled = true;

        $.ajax({
            url:"./server-scripts/endComission.php"
        });
        window.location.href='worker-chores-type.php';
    };

    var showError = function(errorMsgText) {
        loading(false);
        var errorMsg = document.querySelector("#card-error");
        errorMsg.textContent = errorMsgText;
        setTimeout(function() {
            errorMsg.textContent = "";
        }, 4000);
    };

    var loading = function(isLoading) {
    
        if (isLoading) {
        document.querySelector("#submit").disabled = true;
        //document.querySelector("#spinner").classList.remove("hidden");
        //document.querySelector("#button-text").classList.add("hidden");
        } 
        
        else {
        document.querySelector("#submit").disabled = false;
        //document.querySelector("#spinner").classList.add("hidden");
        //document.querySelector("#button-text").classList.remove("hidden");
        }

    };
