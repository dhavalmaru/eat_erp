console.log("Test");

<script type="text/javascript">
	requirejs(['jquery'], function(jQuery) {
		jQuery(function($) {
			var requestUrl = "http://ip-api.com/json";

	        $.ajax({
	            url: requestUrl,
	            type: 'GET',
	            success: function(json)
	            {
	                console.log("My country is: " + json.country);

	                var country = json.country;

	                if(country=="India"){
	                	jquery('#header-account').hide();
	                }
	            },
	            error: function(err)
	            {
	                console.log("Request failed, error= " + err);
	            }
	        });
		});
	});
</script>

// https://blog.logrocket.com/detect-location-and-local-timezone-of-users-in-javascript-3d9523c011b9/

<script type="text/javascript">
    // window.onload = function() 
    document.addEventListener("DOMContentLoaded", () => {
						        fetch('https://extreme-ip-lookup.com/json/')
						        .then( res => res.json())
						        .then(response => {
						            var country = response.country.trim();
						            // console.log("Country: ", country);

						            if(country!='United States') {
						            	document.getElementById('header-account').style.display = 'none';
						            	// document.getElementById('header-account').getElementsByTagName("ul")[0].getElementsByTagName("li")[3].style.display = 'none';

						            	// var element =  document.getElementsByClassName('block-new-customer')[0];
										// if (typeof(element) != 'undefined' && element != null)
										// {
										// 	element.style.display = 'none';
										// }

						                element =  document.getElementsByClassName('login-container')[0];
										if (typeof(element) != 'undefined' && element != null)
										{
											element.innerHTML = 'Sign In is allowed from United States only.';
										}
						                
						                element =  document.getElementsByClassName('form-create-account')[0];
										if (typeof(element) != 'undefined' && element != null)
										{
											element.innerHTML = 'Sign Up is allowed from United States only.';
										}
						            }

						            // console.log(country);
						        })
						        // .catch((data, status) => {
						        //     console.log('Coutry Request failed '+data+' '+status);
						        // })
						    });
</script>