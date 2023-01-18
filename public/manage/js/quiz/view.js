$.ajaxSetup({
	headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$("#opt").change(function () {
	$("#f-multiple-choice").css("display", "none"); //Multiple Choice
	$("#cf-mc").css("display", "none"); //correct choice
	$("#cf-tf").css("display", "none"); //True or False
	$("#cf-identify").css("display", "none"); //Identification

	if ($("#opt").val() == 1) { //Identification
			// console.log("Identify");
			$("#cf-identify").css("display", "inline"); //Identification
	} else if ($("#opt").val() == 2) { //Multiple choice
			// console.log("Multiple Choice");
			$("#f-multiple-choice").css("display", "inline"); //Multiple Choice
			$("#cf-mc").css("display", "inline"); //correct choice
	} else if ($("#opt").val() == 3) { //True or false
			// console.log("True or False");
			$("#cf-tf").css("display", "inline"); //True or False
	}
});

$("#a_opt").change(function () {
	$("#a_f-multiple-choice").css("display", "none"); //Multiple Choice
	$("#a_cf-mc").css("display", "none"); //correct choice
	$("#a_cf-tf").css("display", "none"); //True or False
	$("#a_cf-identify").css("display", "none"); //Identification

	if ($("#a_opt").val() == 1) { //Identification
			// console.log("Identify");
			$("#a_cf-identify").css("display", "inline"); //Identification
	} else if ($("#a_opt").val() == 2) { //Multiple choice
			// console.log("Multiple Choice");
			$("#a_f-multiple-choice").css("display", "inline"); //Multiple Choice
			$("#a_cf-mc").css("display", "inline"); //correct choice
	} else if ($("#a_opt").val() == 3) { //True or false
			// console.log("True or False");
			$("#a_cf-tf").css("display", "inline"); //True or False
	}
});

$('#editQuestion').on('show.bs.modal', function (event) {
	console.log(event.qid);
	var button = $(event.relatedTarget); // Button that triggered the modal
	var qid = button.data('qid');
	var question = button.data('question');
	var qtype = button.data('question-type');
	var choices1 = button.data('choices1');
	var choices2 = button.data('choices2');
	var choices3 = button.data('choices3');
	var choices4 = button.data('choices4');
	var ans = button.data('correct-ans');
	var modal = $(this)
	modal.find('#question').val(question)
	modal.find('#opt').val(qtype)
	modal.find('#_qid').val(qid);
	$("#opt").trigger("change")

	if ($("#opt").val() == 2) { //Multiple Choice
			console.log("MC")
			// var ch = choices.split(";");
			$("#mc0").val(choices1)
			$("#mc1").val(choices2)
			$("#mc2").val(choices3)
			$("#mc3").val(choices4)
			modal.find("#c-mc").val(ans)
	} else if ($("#opt").val() == 3) { //True or False
			
			modal.find("#c-tf").val(ans)
	}
});

$('#deleteQuestion').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Button that triggered the modal
	var qid = button.data('qid')

	var modal = $(this)
	modal.find('#q_id').val(qid)
});

function UpdateQuestion() {
	var q_name = $('#question').val();
	var q_type = $('#opt').val();
	var q_id = $('#_qid').val();
	var q_ans = "";

	var choices1 = "";
	var choices2 = "";
	var choices3 = "";
	var choices4 = "";
	if(q_type == 1){
			q_ans = $('#c-identify').val();
	}
	else if(q_type == 2){
			q_ans = $('#c-mc').val();
			choices1 = $('#mc0').val();
			choices2 = $('#mc1').val();
			choices3 = $('#mc2').val();
			choices4 = $('#mc3').val();
	}
	else if(q_type = 3){
			q_ans = $('#c-tf').val();
	}

	$.ajax({
			url: '/manage/question/edit/' + q_id,
			type: 'PUT', //type is any HTTP method
			data: {
					q_name, q_type, choices1,choices2,choices3,choices4, q_ans
			}, //Data as js object
			success: function () {
					window.location.reload(true);
			}
	});
}

function AddQuestion() {
	var q_name = $('#a_question').val();
	var q_type = $('#a_opt').val();
	var q_id = $('#a_qid').val();
	var q_ans = "";

	var choices1 = "";
	var choices2 = "";
	var choices3 = "";
	var choices4 = "";
	if(q_type == 2){
			q_ans = $('#a_c-mc').val();
			choices1 = $('#a_mc0').val();
			choices2 = $('#a_mc1').val();
			choices3 = $('#a_mc2').val();
			choices4 = $('#a_mc3').val();
	}
	else if(q_type = 3){
			q_ans = $('#a_c-tf').val();
	}
console.log("choices1",choices1);
	$.ajax({
			url: '/manage/question/add',
			type: 'POST', //type is any HTTP method
			data: {
					q_id, q_name, q_type, choices1,choices2, choices3, choices4, q_ans
			}, //Data as js object
			success: function () {
					window.location.reload(true);
			}
	});
}

function DeleteQuestion() {
	var q_id = $('#q_id').val();

	$.ajax({
			url: '/question/delete/' + q_id,
			type: 'DELETE', //type is any HTTP method
			data: {
					q_id
			}, //Data as js object
			success: function () {
					window.location.reload(true);
			}
	});
}