function calculateBMI(lenght, weight)
{
    var result = Math.round(weight / (lenght/100 * lenght/100)*10)/10;

    var leftPos = (result*10)-22;
    if(leftPos > 450) {
        leftPos = 450;
        result = Math.round(result);
    }

    $('#bmiScalePointer').html("BMI<br/><br/>" + result);
    $('#bmiScalePointer').css('left', leftPos);
}

$(document).ready(function() {
		$("#lengthSlider").slider({
			value: 175,
			min: 130,
			max: 220,
			step: 1,
			slide: function( event, ui ) {
                calculateBMI(ui.value, $('#weight').val());
				$("#length").val(ui.value);
			}
		});
		$("#length").val($("#lengthSlider").slider("value"));
        
		$("#weightSlider").slider({
			value: 75,
			min: 24,
			max: 250,
			step: 1,
			slide: function( event, ui ) {
                calculateBMI($('#length').val(), ui.value);
				$("#weight").val(ui.value);
			}
		});
		$("#weight").val($("#weightSlider").slider("value"));        
        
        calculateBMI($('#length').val(), $('#weight').val());
});
