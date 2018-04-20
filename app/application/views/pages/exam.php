<div class="left-pane">

	<?php echo form_open(site_url('pages/finish'), array('id' => 'exam-form')); ?>

		<div class="questions">
			
			<?php $i = 1; foreach ($exam_set as $exam_question) : ?>

				<div class="question">

					<h1>No.  <?php echo $i; ?> (Point : <?php echo $exam_question['question']['weight']; ?>)</h1>
					<?php echo str_replace('/body>','/div>',str_replace('<body', '<div', $exam_question['question']['content'])); ?>

					<?php foreach ($exam_question['answers'] as $answer) : ?>
					
					<?php 
					//$c = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5("hurrdurr"), $answer['id'], MCRYPT_MODE_CBC, md5(md5("hurrdurr")))); 
					$c=$answer['id'];
					?>

					<p class="answer">

						<?php if ($answer_log[$exam_question['question']['id']] == $answer['id']) : ?>
							<input type="radio" name="<?php echo $i; ?>" value="1" class="answer" id="<?php echo $c; ?>" checked="checked" />
						<?php else : ?>
							<input type="radio" name="<?php echo $i; ?>" value="1" class="answer" id="<?php echo $c; ?>" />
						<?php endif; ?>

						<?php echo str_replace('/body>','/div>',str_replace('<body', '<div', $answer['content'])); ?>

					</p>

					<?php endforeach; ?>

				</div>

			<?php $i++; endforeach; ?>

			<br />

			<div class="control">
				<span class="button" id="prev">&lt;</span>
				<span class="button" id="next">&gt;</span>
			</div>

		</div>

	<?php echo form_close(); ?>

</div>

<div class="right-pane">

	<h1>Remaining Time</h1>
	<p id="timer"></p>

	<h1>Question List</h1>

	<div class="triggers">

			<?php $i = 1; foreach ($exam_set as $exam_question) : ?>
				<?php if (!empty($answer_log[$exam_question['question']['id']])) : ?>
					<a href="#<?php echo $i; ?>" class="trigger green" id="<?php echo $i; ?>" >
				<?php else : ?>
					<a href="#<?php echo $i; ?>" class="trigger red" id="<?php echo $i; ?>" >
				<?php endif; ?>
					<?php echo $i; ?>
				</a>
			<?php $i++; endforeach; ?>

	</div>

	<br />

	<p>
		<span class="button" onclick="document.getElementById('end_test_button').setAttribute('style', '')">End Exam</span>
		<span class="button" id="end_test_button" style="display: none" onclick="document.getElementById('exam-form').submit()">Confirm</span>
	</p>
	
	<h2>Registration Code :</h2>
	<p><?php echo $code; ?></p>

	<h2>Student Name :</h2>
	<p><?php echo $name; ?></p>

</div>

<div class="expander"></div>

<script type="text/javascript">

	document.body.onload = start_timer();

	$(function() {

		var api = $('div.triggers').tabs('div.questions > div.question').history({api: true});

		$('#prev').click(function() {
			api.prev();
		});

		$('#next').click(function() {
			api.next();
		});

		$('input').click(function() {
			$('a.trigger[id=' + $(this).attr('name') + ']').removeClass('red').addClass('green');
			$.post('<?php echo site_url('pages/answer'); ?>', {id: $(this).attr('id'), time: get_cookie('remaining_time')});
		});

		$('a.trigger').mouseover(function() {
			$(this).removeClass('red').addClass('blue');
		});

		$('a.trigger').mouseout(function() {
			if ($(this).hasClass('green')) {
				$(this).removeClass('blue').addClass('green');
			} else {
				$(this).removeClass('blue').addClass('red');
			}
		});

	});

</script>
