<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://sandbox.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&components=buttonscurrency=dls"></script>

</head>
<body>

   <div id="paypal-button-container"></div>


    <script>
       paypal.Buttons().render('#paypal-button-container')
   </script>

</body>
</html>