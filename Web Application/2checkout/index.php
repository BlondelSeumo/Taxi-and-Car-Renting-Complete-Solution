<?php 
if(isset($_GET['amt']))
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <title>Checkout</title>
</head>
<body>

  <!-- Your form goes here -->
  <form id="checkoutForm" action='https://www.2checkout.com/checkout/purchase' method='post' style="display: none;">
    <input type='hidden' name='sid' value='254816786696' />
    <input type='hidden' name='mode' value='2CO' />
    <input type='hidden' name='li_0_name' value='test' />
    <input type='hidden' name='li_0_price' value='<?php echo $_GET['amt'];?>' />
    <input type='hidden' name='demo' value='Y' />
    <!-- You can remove the submit button since it's not needed -->
  </form>

  <script>
    // jQuery script to auto-submit the form on page load
    $(document).ready(function() {
      $("#checkoutForm").submit();
    });
  </script>

</body>
</html>
<?php } ?>
