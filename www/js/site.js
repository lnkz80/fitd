function getUrlVar(){
    var urlVar = window.location.search; // получаем параметры из урла
    var arrayVar = []; // массив для хранения переменных
    var valueAndKey = []; // массив для временного хранения значения и имени переменной
    var resultArray = []; // массив для хранения переменных
    arrayVar = (urlVar.substr(1)).split('&'); // разбираем урл на параметры
    if(arrayVar[0]=="") return false; // если нет переменных в урле
    for (i = 0; i < arrayVar.length; i ++) { // перебираем все переменные из урла
        valueAndKey = arrayVar[i].split('='); // пишем в массив имя переменной и ее значение
        resultArray[valueAndKey[0]] = valueAndKey[1]; // пишем в итоговый массив имя переменной и ее значение
    }
    return resultArray; // возвращаем результат
}

$(document).ready(function() { 
	jQuery.noConflict();
	var data = $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'}).val();
	$("#datepicker").datepicker();


	$("form.mineforms").on('submit', function(){
		var err = false;
		//var formdata = $(".mineforms").serialize();
		var that = $(this),
			url = that.attr('action'),
			type = that.attr('method'),
			data={};
		
	    that.find('[name]').each(function(index, value){
	    	if ($(this).val()!=''){
	    	var that = $(this),
	    		name = that.attr('name'),
	    		value = that.val();
	    		data[name] = value;
	    		}
	    	else {
	    		$(this).css("border", "1px solid red");
				$(".itemstatus").css("color", "red");
				$(".itemstatus").css("font", "14px 'Gill Sans'");
				$(this).css("background-color", "rgba(255, 0, 0, 0.03)");
	    		$(".itemstatus").html("Заполните все поля!");
	    		err = true;
	    	}	

	    });
		
		var rslt = getUrlVar();
	    data.type = rslt['cat'];
	    //console.log(data);

	    if (!err){
	    $.ajax({
	    	url: url,
	    	type: type,
	    	data: data,
	    	success: function(response){
	    		var obj = $.parseJSON(response);
	    		console.log(obj.arr['id']);
	    		if (!obj.error){
		    		$(".itemstatus").css("color", "green");
		    		$(".itemstatus").html(obj.data);
		    		$("#libtab > tbody").append("<tr><td>" + obj.arr['id'] + "</td><td>" + obj.arr['name'] + "</td></tr>");
	    		}
	    		else {
	    			$(".itemstatus").css("color", "red");
		    		$(".itemstatus").html(obj.error);
	    		}
	    		//console.log(response);
	    	}
	    });
	    }
		return false;


	});
});