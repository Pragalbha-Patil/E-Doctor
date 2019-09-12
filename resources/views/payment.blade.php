<html>
   <head>
      <title>Merchant Check Out Page</title>
   </head>
   <body>
      <center>
         <h1>Please do not refresh this page...</h1>
      </center>
      <form method="post" action="https://securegw-stage.paytm.in/order/process" name="paytm">
         <table border="1">
            <tbody>
               <input type="hidden" name="MID" value="SyuUkx08977375519728">
               <input type="hidden" name="WEBSITE" value="WEBSTAGING">
               <input type="hidden" name="ORDER_ID" value="sample">
               <input type="hidden" name="CUST_ID" value="1">
               <input type="hidden" name="MOBILE_NO" value="91827364544">
               <input type="hidden" name="EMAIL" value="abc@example.com">
               <input type="hidden" name="INDUSTRY_TYPE_ID" value="CS">
               <input type="hidden" name="CHANNEL_ID" value="WEB">
               <input type="hidden" name="TXN_AMOUNT" value="100">
               <input type="hidden" name="CALLBACK_URL" value="http://127.0.0.1:8000/paymentcomplete">
               <input type="hidden" name="CHECKSUMHASH" value="abcd">
            </tbody>
         </table>
         <script type="text/javascript">
            document.paytm.submit();
         </script>
      </form>
   </body>
</html>
