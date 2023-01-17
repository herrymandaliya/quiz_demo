$("#qt-0").change(function () {
	$("#i-0").css('display', 'none');
	$("#mc-0").css('display', 'none');
	$("#tf-0").css('display', 'none');

	if($(this).val() == 1){
			$("#i-0").css('display', 'inline');
	}
	else if ($(this).val() == 2){
			 $("#mc-0").css('display', 'inline');
	}
	else if($(this).val() == 3){
			$("#tf-0").css('display', 'inline');
	}
});

var newId = 1;
var template = jQuery.validator.format(`
		<div class="row">
						<div class="col-8">
								<label for="">Question</label>
								<textarea class="form-control"name="question[{0}]" id="" cols="30" rows="5" placeholder="Input question here..." required></textarea>
						</div>
						<div class="col-3">
								<div class="form-group">
										<label for="">Question Type</label>

										<select name="qt[{0}]" id="qt-{0}" class="form-control qt" required>
												<option value="">---Select a question type---</option>
												<!--<option value="1">Identification</option>-->
												<option value="2">Multiple Choice</option>
												<option value="3">True or False</option>
										</select>
								</div>
								<!-- <div class="form-group form-inline">
								 		<label for="" class="pr-2">Points:</label><input type="number" class="form-control" min="1" name="points[]" value="1" style="max-width: 100px">
									 </div>-->
								<div class="form-group">
										<button type="button" class="btn btn-primary btn-block btn-sm ml-1" onclick="addQuestion()">Add Another Question</button>
								</div>
						</div>
						
						<div class="col-6" id="i-{0}" style="padding-top: 10px; display: none">
								<label for="">Correct answer</label>
								<input name="i[{0}]" type="text" class="form-control">
						</div>
						<div class="multiple-choice" id="mc-{0}" style="display: none">
								<div class="col-12" style="padding-top: 10px;">
										<div class="row">
												<div class="col-3"><label>Choice 1</label><input name="mc[{0}][0]" type="text" class="form-control"></div>
												<div class="col-3"><label>Choice 2</label><input name="mc[{0}][1]" type="text" class="form-control"></div>
												<div class="col-3"><label>Choice 3</label><input name="mc[{0}][2]" type="text" class="form-control"></div>
												<div class="col-3"><label>Choice 4</label><input name="mc[{0}][3]" type="text" class="form-control"></div>
										</div>
										<div class="row" style="padding-top: 10px;">
												<div class="col-8">
														<label for="">Correct choice</label>
														<select name="c-mc[{0}]" id="c-mc[{0}]" class="form-control">
																<option value="1">Choice 1</option>
																<option value="2">Choice 2</option>
																<option value="3">Choice 3</option>
																<option value="4">Choice 4</option>
														</select>
												</div>
										</div>
								</div>
						</div>
						<div class="col-3" id="tf-{0}" style="padding-top: 10px;  display: none">
								<label for="">Correct answer</label>
								<select name="tf[{0}]" id="" class="form-control">
										<option value="1">True</option>
										<option value="0">False</option>
								</select>
						</div>
						<script>
								$("#qt-{0}").change(function () {
										$("#i-{0}").css('display', 'none');
										$("#mc-{0}").css('display', 'none');
										$("#tf-{0}").css('display', 'none');

										if($(this).val() == 1){
												$("#i-{0}").css('display', 'inline');
										}
										else if ($(this).val() == 2){
												 $("#mc-{0}").css('display', 'inline');
										}
										else if($(this).val() == 3){
												$("#tf-{0}").css('display', 'inline');
										}
								});
						<\/script>
		</div>
		<hr>
`);
function addQuestion(){
		$('#question').append(template(newId));
		newId++;
}

$(document).ready(function() {
          
	$(function() {
			$( "#exam_date" ).datepicker();
	});
})