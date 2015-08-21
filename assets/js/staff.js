// TO CHANGE THE TEXT OF BUTTON
$('#hideButton').on('click', function () {
    if ($(this).hasClass('collapsed')){
    	$(this).html("Hide");
        $(this).removeClass("btn-warning");
        $(this).addClass("btn-info");
    }
    else {
        $(this).html("Show");
        $(this).removeClass("btn-info");
        $(this).addClass("btn-warning");
    }
});

// TO HIDE ALL ORDERS WHEN SEARCHING FOR THE USERNAME
$( "#txtUsername" ).focus(function() {
	$('#orderTable').collapse('hide');
	$('#hideButton').html("Show");
    $('#hideButton').removeClass("btn-info");
    $('#hideButton').addClass("btn-warning");
});

// AJAX TO SEARCH FOR THE ORDERS OF A GIVEN USER FOR TODAY
$('#searchForm').on('submit', function(e){
	e.preventDefault();
// 	$('#btnSearch').fadeOut(300);
	$.ajax({
	      url: '/assets/ajax/getOrdersForUser.php',
	      type: 'post',
	      data: {'username': $('#txtUsername').val()},
	      success: function(json) {
	    	  	var table = $('#searchResults');
	    	  	table.removeClass('table table-hover table-bordered');
	    	  	table.html('');
	    	  	$('#serveSubmitBtn').remove();
	    	  	if (json.username == '0') {
	    	  		table.append('<div class="alert alert-info">No Orders Found</div>');
	    	  	}
	    	  	else {
	    	  		
		    		$.each(json, function(i, item) {
			    		if (typeof item == 'object') {
							table.addClass('table table-hover table-bordered');
							var tr = '<tr id="td-'+ item.ID+'">' +
										'<td>' + item.name + '</td>' +
										'<td>' + item.quantity + '</td>'+
										'<td><div class="checkbox no-margin"><label class="center-block"><input name="orders[]" value="' + item.ID + '" type="checkbox" onchange="changeSubmitText(this)">Serve</label></div></td>' + 
									'</tr>';
							table.append(tr);
			    		}
			    		else {
				    		return false;
			    		}
		    		});
		    		var submitBtn = '<button type="submit" class="btn btn-primary" name="submit" id="serveSubmitBtn">Serve All</button>';
	    	  		$('#serveForm').append(submitBtn);
	    	  	}
	      },
	      error: function(xhr, desc, err) {
	        console.log(xhr);
	        console.log("Details: " + desc + "\nError:" + err);
	      }
	    }); // end ajax call
});


function changeSubmitText(t) {
	var serveBtn = $('#serveSubmitBtn');
	if (t.checked) {
		serveBtn.text('Serve');
	}
	else {
		if ($('#serveForm input[type="checkbox"]').prop("checked"))
			serveBtn.text('Serve');
		else {
			serveBtn.text('Serve All');
		}
	}
}

function checkBoxes() {
	var checks = $('#serveForm input[type="checkbox"]');
	if (checks.prop("checked"))
		return true;
	else {
		checks.each(function(index){
			$(this).prop("checked", true);
		});
	}
}