<div id="paypal-button-container-P-4HW47629B9418231PMTIMQ6Y"></div>
<script src="https://www.paypal.com/sdk/js?client-id=AfFysLO93q_Wp_tATCIWS37HcrIAEzZUh-ko82N8OZpPo7Eofoq_76gQcLEXvSD9LPIhtiSH7wF37IN4&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<script>
  paypal.Buttons({
      style: {
          shape: 'rect',
          color: 'black',
          layout: 'horizontal',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: 'P-4HW47629B9418231PMTIMQ6Y',
          quantity: 1 // The quantity of the product for a subscription
        });
      },
      onApprove: function(data, actions) {
        alert(data.subscriptionID); // You can add optional success message for the subscriber here
      }
  }).render('#paypal-button-container-P-4HW47629B9418231PMTIMQ6Y'); // Renders the PayPal button
</script>
