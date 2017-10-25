<html>
<head>
<title>order no</title>
<script type="text/javascript">
function selector(str)
{
var str1=str;
if(str1=='am')
{
alert ("option-"+str1+"amazon is selected" );
document.getElementById("show"),style.display="block";
}}
function validate()
 var order=getElementById("order").value;
 var pattern=/^\d{3}-?\d{4}-?\d{4}$/;
 if(pattern.test(order))
 {
  alert("your valid order  no:+order);
  return true;
  }
  alert("no  valid order  no:+order);
  return false;
  }
  </script>
  </head>
  <body>
  <select id="dp1" onchange="selector(this.value);">
  <option value="am">amazon</option>
   <option value="pn">flip</option>
   </select>
   <div id="show" style="display:none;">
   order no: 
   <input type="text" name="order" id="order"/>
   <input type="submit" value="check" onclick="validate();/>
   </div>
   </body>
   </html>
  
  